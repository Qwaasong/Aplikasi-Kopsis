<?php

namespace App\Http\Controllers;

use App\Models\LedgerEntry;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LedgerEntryController extends Controller
{
    public function create()
    {
        return view('ledger_entries.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'telepon' => 'nullable|string|max:20',
        'tipe' => 'required|in:hutang,piutang',
        'nominal' => 'required|numeric|min:0', // Pastikan ini numeric
        'keterangan' => 'required|string|max:500',
        'tanggal_transaksi' => 'required|date',
        'jatuh_tempo' => 'nullable|date|after_or_equal:tanggal_transaksi',
    ]);

    // Debug: lihat nilai nominal yang diterima
    // dd($request->nominal);

    LedgerEntry::create([
        'nama' => $request->nama,
        'telepon' => $request->telepon,
        'tipe' => $request->tipe,
        'nominal' => $request->nominal, // Pastikan ini angka, bukan string
        'keterangan' => $request->keterangan,
        'tanggal_transaksi' => $request->tanggal_transaksi,
        'jatuh_tempo' => $request->jatuh_tempo,
    ]);

    $jenis = $request->tipe === 'hutang' ? 'hutang' : 'piutang';
    
    return redirect()->route('ledger_entries.index')
        ->with('success', "Catatan $jenis berhasil ditambahkan.");
}

    public function edit($id)
    {
        $entry = LedgerEntry::findOrFail($id);
        return view('ledger_entries.edit', compact('entry'));
    }

    public function update(Request $request, $id)
    {
        $entry = LedgerEntry::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'tipe' => 'required|in:hutang,piutang',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:500',
            'tanggal_transaksi' => 'required|date',
            'jatuh_tempo' => 'nullable|date|after_or_equal:tanggal_transaksi',
        ]);

        $entry->update($request->all());

        return redirect()->route('ledger_entries.index')
            ->with('success', 'Catatan hutang/piutang berhasil diperbarui.');
    }

    // Update jatuh tempo
public function updateJatuhTempo(Request $request, $id)
{
    try {
        $entry = LedgerEntry::findOrFail($id);
        
        $request->validate([
            'jatuh_tempo' => 'required|date'
        ]);

        $entry->update([
            'jatuh_tempo' => $request->jatuh_tempo
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jatuh tempo berhasil diupdate'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal update jatuh tempo: ' . $e->getMessage()
        ], 500);
    }
}

// Tambah hutang/piutang
public function tambahUtang(Request $request, $id)
{
    try {
        $entry = LedgerEntry::findOrFail($id);
        
        $request->validate([
            'nominal' => 'required|numeric|min:0'
        ]);

        // Tambah nominal yang ada
        $entry->update([
            'nominal' => $entry->nominal + $request->nominal
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah: ' . $e->getMessage()
        ], 500);
    }
}
// Bayar hutang/piutang
public function bayarUtang(Request $request, $id)
{
    try {
        $entry = LedgerEntry::findOrFail($id);
        
        $request->validate([
            'nominal' => 'required|numeric|min:0|max:' . $entry->nominal
        ]);

        // Kurangi nominal yang ada
        $entry->update([
            'nominal' => $entry->nominal - $request->nominal
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal melakukan pembayaran: ' . $e->getMessage()
        ], 500);
    }
}
// Lunaskan (hapus entry)
public function lunaskan($id)
{
    try {
        $entry = LedgerEntry::findOrFail($id);
        $entry->delete();

        return response()->json([
            'success' => true,
            'message' => ($entry->tipe == 'hutang' ? 'Hutang' : 'Piutang') . ' berhasil dilunasi'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal melunasi: ' . $e->getMessage()
        ], 500);
    }
}
   
}
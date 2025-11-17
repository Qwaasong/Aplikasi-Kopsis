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
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:500',
            'tanggal_transaksi' => 'required|date',
            'jatuh_tempo' => 'nullable|date|after_or_equal:tanggal_transaksi',
        ]);

        LedgerEntry::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'tipe' => $request->tipe,
            'nominal' => $request->nominal,
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

    // 🎯 Method untuk melunasi hutang/piutang
    public function lunaskan($id)
    {
        $entry = LedgerEntry::findOrFail($id);
        $entry->delete();

        $jenis = $entry->tipe === 'hutang' ? 'hutang' : 'piutang';
        
        return redirect()->route('ledger_entries.index')
            ->with('success', "$jenis telah dilunasi dan dihapus dari catatan.");
    }
}
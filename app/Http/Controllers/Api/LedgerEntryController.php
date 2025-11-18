<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LedgerEntry;
use Illuminate\Http\Request;

class LedgerEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = LedgerEntry::query();

        // 🔍 Pencarian berdasarkan nama atau keterangan
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('keterangan', 'like', '%' . $search . '%')
                  ->orWhere('telepon', 'like', '%' . $search . '%');
            });
        }

        // 🏷️ Filter berdasarkan tipe
        if ($tipe = $request->input('tipe')) {
            $query->where('tipe', $tipe);
        }

        // 📅 Filter berdasarkan status jatuh tempo
        if ($status = $request->input('status')) {
            if ($status === 'terlambat') {
                $query->where('jatuh_tempo', '<', now())->whereNotNull('jatuh_tempo');
            } elseif ($status === 'mendatang') {
                $query->where('jatuh_tempo', '>', now())->whereNotNull('jatuh_tempo');
            }
        }
        

        $entries = $query->latest()->paginate(10);

        $entries->getCollection()->transform(function ($entry) {
            return [
                'id'             => $entry->id,
                'nama'           => $entry->nama, 
                'tipe'           => $entry->tipe,
                'nominal'        => 'Rp ' . number_format($entry->nominal, 0, ',', '.'),
                'keterangan'     => $entry->keterangan,
                'telepon'        => $entry->telepon,
                
            ];
        });
        return response()->json([
            'success' => true,
            'data' => $entries
        ]);
    }

    public function destroy($id)
    {
        $entry = LedgerEntry::findOrFail($id);
        $entry->delete();

        return response()->json([
            'success' => true,
            'message' => 'Catatan hutang/piutang berhasil dihapus.'
        ]);
    }

    // 📈 Method untuk dashboard summary
    public function summary()
    {
        $totalHutang = LedgerEntry::hutang()->sum('nominal');
        $totalPiutang = LedgerEntry::piutang()->sum('nominal');
        $hutangTerlambat = LedgerEntry::hutang()
            ->where('jatuh_tempo', '<', now())
            ->whereNotNull('jatuh_tempo')
            ->sum('nominal');
        $piutangTerlambat = LedgerEntry::piutang()
            ->where('jatuh_tempo', '<', now())
            ->whereNotNull('jatuh_tempo')
            ->sum('nominal');

        return response()->json([
            'success' => true,
            'data' => [
                'total_hutang' => $totalHutang,
                'total_piutang' => $totalPiutang,
                'hutang_terlambat' => $hutangTerlambat,
                'piutang_terlambat' => $piutangTerlambat,
            ]
        ]);
    }
}
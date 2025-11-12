<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    /**
     * Menampilkan semua transaksi (masuk & keluar).
     */
    public function index(Request $request)
    {
        $query = StockOut::with('product');

        // Filter berdasarkan jenis transaksi: masuk / keluar
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Filter waktu (mingguan, bulanan, tahunan)
        // if ($filter = $request->input('filter')) {
        //     $query->when($filter === 'minggu', fn($q) =>
        //         $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        //     );
        //     $query->when($filter === 'bulan', fn($q) =>
        //         $q->whereMonth('created_at', now()->month)
        //     );
        //     $query->when($filter === 'tahun', fn($q) =>
        //         $q->whereYear('created_at', now()->year)
        //     );
        // }

        // Pencarian berdasarkan field-field yang relevan
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('tanggal', 'like', "%{$search}%")
                  ->orWhere('no_faktur', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%")
                        ->orWhere('no_telp', 'like', "%{$search}%");
                  });
            });
        }

        // 🔢 Pagination (10 per halaman)
        $stockOuts = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $stockOuts,
        ]);
    }
    
    /**
     * Menghapus transaksi (opsional).
     * Jika dihapus, stok dikembalikan seperti semula.
     */
    public function destroy(StockOut $id)
    {
        DB::beginTransaction();

        try {
            // Hapus data terkait seperti item pembelian dan transaksi finansial
            $id->items()->delete(); // Hapus semua item pembelian
            if($id->financialTransaction) {
                $id->financialTransaction->delete(); // Hapus transaksi finansial terkait
            }
            
            $id->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Barang keluar berhasil dihapus.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus barang keluar: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Ringkasan jumlah transaksi dalam minggu, bulan, dan tahun ini untuk chart
    public function summary()
    {
        $data = [
            'minggu' => StockOut::whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'bulan' => StockOut::whereMonth('tanggal', now()->month)->count(),
            'tahun' => StockOut::whereYear('tanggal', now()->year)->count(),
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}

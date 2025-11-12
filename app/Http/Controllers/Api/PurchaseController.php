<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Menampilkan semua transaksi (masuk & keluar).
     */
    public function index(Request $request)
    {
        $query = Purchase::with('vendor');

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
                $q->where('jumlah_pack', 'like', "%{$search}%")
                  ->orWhere('tanggal', 'like', "%{$search}%")
                  ->orWhereHas('vendor', function ($q) use ($search) {
                      $q->where('nama_vendor', 'like', "%{$search}%")
                        ->orWhere('kategori', 'like', "%{$search}%");
                  });
            });
        }

        // 🔢 Pagination (10 per halaman)
        $purchase = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $purchase,
        ]);
    }
    
    /**
     * Menghapus transaksi (opsional).
     * Jika dihapus, stok dikembalikan seperti semula.
     */
    public function destroy(Purchase $purchase)
    {
        DB::beginTransaction();

        try {
            // Hapus data terkait seperti item pembelian dan transaksi finansial
            $purchase->items()->delete(); // Hapus semua item pembelian
            if($purchase->financialTransaction) {
                $purchase->financialTransaction->delete(); // Hapus transaksi finansial terkait
            }
            
            $purchase->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Barang masuk berhasil dihapus.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus barang masuk: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Ringkasan jumlah transaksi dalam minggu, bulan, dan tahun ini untuk chart
    public function summary()
    {
        $data = [
            'minggu' => Purchase::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'bulan' => Purchase::whereMonth('created_at', now()->month)->count(),
            'tahun' => Purchase::whereYear('created_at', now()->year)->count(),
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}

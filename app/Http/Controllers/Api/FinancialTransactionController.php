<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialTransactionController extends Controller
{
    /**
     * Menampilkan semua transaksi (masuk & keluar).
     */
    public function index(Request $request)
    {
        $query = FinancialTransaction::with('purchase', 'stockOut');

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
                $q->where('pemasukan', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhere('tanggal', 'like', "%{$search}%")
                  ->orWhere('jumlah', 'like', "%{$search}%");
            });
        }

        // 🔢 Pagination (10 per halaman)
        $financialTransactions = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $financialTransactions,
        ]);
    }
    
    /**
     * Menghapus transaksi (opsional).
     * Jika dihapus, stok dikembalikan seperti semula.
     */
    public function destroy(FinancialTransaction $id)
    {
        DB::beginTransaction();

        try {
            // Hapus data terkait seperti item pembelian dan transaksi finansial
            $id->items()->delete(); // Hapus semua item pembelian
            if($id->purchase && $id->stockOut) {
                $id->purchase->delete();
                $id->stockOut->delete();
            }
            
            $id->delete();

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
            'minggu' => FinancialTransaction::whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'bulan' => FinancialTransaction::whereMonth('tanggal', now()->month)->count(),
            'tahun' => FinancialTransaction::whereYear('tanggal', now()->year)->count(),
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}

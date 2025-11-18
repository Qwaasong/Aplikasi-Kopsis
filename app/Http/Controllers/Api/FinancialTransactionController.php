<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
        if ($type = $request->input('tipe')) {
            $query->where('tipe', $type);
        }

        // Filter waktu (mingguan, bulanan, tahunan)
        if ($filter = $request->input('filter')) {
            $query->when(
                $filter === 'minggu',
                fn($q) =>
                $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            );
            $query->when(
                $filter === 'bulan',
                fn($q) =>
                $q->whereMonth('created_at', now()->month)
            );
            $query->when(
                $filter === 'tahun',
                fn($q) =>
                $q->whereYear('created_at', now()->year)
            );
        }

        // Pencarian berdasarkan field-field yang relevan
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('tipe', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%")
                    ->orWhere('jumlah', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $transactions,
        ]);
    }

    /**
     * Menghapus transaksi (opsional).
     * Jika dihapus, stok dikembalikan seperti semula.
     */
    public function destroy(FinancialTransaction $financialTransaction) // Ganti parameter name
{
    DB::beginTransaction();

    try {
        // Hanya hapus transaksi, tidak perlu adjust stok produk
        // Karena FinancialTransaction adalah pencatatan keuangan, bukan inventory
        $financialTransaction->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi keuangan berhasil dihapus.',
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus transaksi: ' . $e->getMessage(),
        ], 500);
    }
}
    // Ringkasan jumlah transaksi dalam minggu, bulan, dan tahun ini untuk chart
    public function summary()
    {
        $data = [
            'minggu' => FinancialTransaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'bulan' => FinancialTransaction::whereMonth('created_at', now()->month)->count(),
            'tahun' => FinancialTransaction::whereYear('created_at', now()->year)->count(),
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}

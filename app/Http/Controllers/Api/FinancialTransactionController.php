<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FinancialTransactionController extends Controller
{
    /**
     * Menampilkan semua transaksi (masuk & keluar).
     */
    public function index(Request $request)
    {
        // 1. Tentukan jumlah HARI per halaman
        $perPage = 3;

        // 2. Ambil filter dari request (yang dikirim oleh component)
        $filterTipe = $request->input('filter.tipe');
        $startDate = $request->input('filter.start_date');
        $endDate = $request->input('filter.end_date');

        // 3. Buat query dasar
        $query = FinancialTransaction::query();

        // 4. Terapkan Filter
        if ($filterTipe) {
            $query->where('tipe', $filterTipe);
        }

        if ($startDate && $endDate) {
            // Asumsi Anda punya kolom 'tanggal'
            // Ganti 'tanggal' dengan 'created_at' jika Anda pakai itu
            $query->whereDate('tanggal', '>=', $startDate)
                ->whereDate('tanggal', '<=', $endDate);
        }

        // 5. Ambil SEMUA data yang terfilter (PENTING: kita .get() dulu)
        $allTransactions = $query->orderBy('tanggal', 'desc')->get();

        // 6. Kelompokkan data berdasarkan tanggal
        $groupedByDay = $allTransactions->groupBy(function ($tx) {
            // Pastikan kolom 'tanggal' adalah Carbon/Date object.
            // Jika tidak, tambahkan $casts di Model Anda:
            // protected $casts = ['tanggal' => 'datetime'];
            if (is_string($tx->tanggal)) {
                return \Carbon\Carbon::parse($tx->tanggal)->format('Y-m-d');
            }
            return $tx->tanggal->format('Y-m-d');
        });

        // 7. Ubah (Transformasi) data ke format yang diharapkan komponen
        $dailySummaries = $groupedByDay->map(function ($transactionsOnThisDay, $date) {

            // Hitung total penjualan (pemasukan) dan pengeluaran
            $totalSales = $transactionsOnThisDay->where('tipe', 'pemasukan')->sum('jumlah');
            $totalExpense = $transactionsOnThisDay->where('tipe', 'pengeluaran')->sum('jumlah');

            $summaryAmount = $totalSales - $totalExpense;
            $summaryType = $summaryAmount >= 0 ? 'profit' : 'loss';

            // Format ulang transaksi individual untuk frontend
            $formattedTransactions = $transactionsOnThisDay->map(function ($tx) {
                // SESUAIKAN NAMA KOLOM INI DENGAN DATABASE ANDA
                return [
                    'id' => $tx->id,
                    'note' => $tx->keterangan, // 'keterangan' dari DB
                    'sales' => $tx->tipe == 'pemasukan' ? $tx->jumlah : 0,
                    'expense' => $tx->tipe == 'pengeluaran' ? $tx->jumlah : 0
                ];
            });

            // Kembalikan format yang diharapkan <x-financial-log>
            return [
                'date' => $date, // 'date', BUKAN 'tanggal'
                'summaryType' => $summaryType,
                'summaryAmount' => abs($summaryAmount),
                'transactions' => $formattedTransactions
            ];
        });

        // 8. Buat Paginasi secara Manual dari hasil grup harian
        $currentPage = $request->input('page', 1);
        $currentPageItems = $dailySummaries->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $currentPageItems,
            $dailySummaries->count(), // Total jumlah HARI
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // 9. Kembalikan Paginator
        // Ini akan mengirim JSON format 'grup harian' yang benar
        return $paginator;
    }

    /**
     * Menghapus transaksi (opsional).
     * Jika dihapus, stok dikembalikan seperti semula.
     */
    // DENGAN FUNGSI INI
    public function destroy($id) // Terima $id (string/int)
    {
        try {
            // Cari transaksinya secara manual
            $financialTransaction = FinancialTransaction::findOrFail($id);

            // Hapus
            $financialTransaction->delete();

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil dihapus.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Ini jika ID-nya tidak ditemukan
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus transaksi.'], 500);
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

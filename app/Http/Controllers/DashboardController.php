<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FinancialTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter dari query (default: 'bulan')
        $filter = $request->get('filter', 'bulan');

        // Tentukan rentang tanggal berdasarkan filter
        switch ($filter) {
            case 'minggu':
                $startDate = Carbon::now()->startOfWeek();
                $endDate   = Carbon::now()->endOfWeek();
                break;
            case 'tahun':
                $startDate = Carbon::now()->startOfYear();
                $endDate   = Carbon::now()->endOfYear();
                break;
            default: // 'bulan'
                $startDate = Carbon::now()->startOfMonth();
                $endDate   = Carbon::now()->endOfMonth();
                break;
        }

        // Ambil data berdasarkan rentang waktu
        $transactions = FinancialTransaction::whereBetween('tanggal', [$startDate, $endDate])->get();

        // Total pemasukan, pengeluaran, saldo
        $pemasukan = $transactions->where('tipe', 'pemasukan')->sum('jumlah');
        $pengeluaran = $transactions->where('tipe', 'pengeluaran')->sum('jumlah');
        $saldo = $pemasukan - $pengeluaran;

        // Data chart per tanggal
        $dataChart = FinancialTransaction::selectRaw('tanggal,
                SUM(CASE WHEN tipe="pemasukan" THEN jumlah ELSE 0 END) as total_pemasukan,
                SUM(CASE WHEN tipe="pengeluaran" THEN jumlah ELSE 0 END) as total_pengeluaran')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();


        return view('welcome', [
            'filter' => $filter,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldo' => $saldo,
            'dataChart' => $dataChart
        ]);
    }
}

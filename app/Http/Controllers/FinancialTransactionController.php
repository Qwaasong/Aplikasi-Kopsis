<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FinancialTransactionController extends Controller
{
    

    public function create()
    {
        return view('riwayat_transaksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'required|string|max:500',
            'jumlah' => 'required|numeric|min:0',
        ]);

        FinancialTransaction::create($request->all());

        return redirect()->route('riwayat_transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $transaction = FinancialTransaction::findOrFail($id);
        return view('riwayat_transaksi.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = FinancialTransaction::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'required|string|max:500',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $transaction->update($request->all());

        return redirect()->route('riwayat_transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function generatePDF(Request $request)
    {

        // Ambil data transaksi keuangan
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        if (!$startDate || !$endDate) {
            return redirect()->back()->with('error', 'Tanggal awal dan akhir harus diisi.');
        }
        
        $transactions = FinancialTransaction::whereBetween('tanggal', [$startDate, $endDate])
            ->with('purchase', 'stockOut')
            ->get();
            
        $totalPemasukan = FinancialTransaction::where('tipe', 'pemasukan')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');
            
        $totalPengeluaran = FinancialTransaction::where('tipe', 'pengeluaran')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah');
            
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Data yang akan dikirim ke view
        $data = [
            'transactions' => $transactions,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $saldo,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        // Generate PDF
        $pdf = Pdf::loadView('riwayat_transaksi.laporan_keuangan', $data);
        return $pdf->download('laporan-keuangan-' . date('Y-m-d') . '.pdf');
    }
}

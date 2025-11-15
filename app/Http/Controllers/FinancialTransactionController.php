<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use Illuminate\Http\Request;

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

    
}
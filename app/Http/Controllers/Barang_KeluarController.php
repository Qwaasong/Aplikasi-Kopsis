<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use Illuminate\Http\Request;

class Barang_KeluarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'jumlah'          => 'required|integer|min:1',
            'tanggal_keluar'  => 'required|date',
            'keterangan'      => 'nullable|string|max:500',
        ]);

        StockOut::create($request->all());
        return redirect()->route('barang_keluar.index')->with('success', 'Data barang keluar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $stockOut = StockOut::findOrFail($id);
        return view('barang_keluar.edit', compact('stockOut'));
    }

    
    public function update(Request $request, $id)
    {
        $stockOut = StockOut::findOrFail($id);

        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'jumlah'          => 'required|integer|min:1',
            'tanggal_keluar'  => 'required|date',
            'keterangan'      => 'nullable|string|max:500',
        ]);

        $stockOut->update($request->all());
        return redirect()->route('barang_keluar.index')->with('success', 'Data barang keluar berhasil diperbarui.');
    }

    
}

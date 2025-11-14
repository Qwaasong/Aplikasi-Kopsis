<?php

namespace App\Http\Controllers;
use App\Models\Product;

use App\Models\StockOut;
use Illuminate\Http\Request;

class Barang_KeluarController extends Controller
{

    public function create()
    {
        // ambil semua produk
        $products = Product::select('id', 'nama')->orderBy('nama')->get();

        return view('barang_keluar.store', compact('products'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'jumlah_pack'          => 'required|integer|min:1',
            'tanggal'  => 'required|date',
            'keterangan'      => 'nullable|string|max:500',
        ]);

        StockOut::create($request->all());
        return redirect()->route('barang_keluar.index')->with('success', 'Data barang keluar berhasil ditambahkan.');
    }

    public function edit($id)
{
    $stockOut = StockOut::findOrFail($id);
    $products = Product::select('id', 'nama')->orderBy('nama')->get();
    
    return view('barang_keluar.edit', compact('stockOut', 'products'));
}

    
    public function update(Request $request, $id)
    {
        $stockOut = StockOut::findOrFail($id);

        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'jumlah_pack'     => 'required|integer|min:1',
            'tanggal'         => 'required|date',
            'keterangan'      => 'nullable|string|max:500',
        ]);

        $stockOut->update($request->all());
        return redirect()->route('barang_keluar.index')->with('success', 'Data barang keluar berhasil diperbarui.');
    }

    
}

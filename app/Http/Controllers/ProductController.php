<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Tampilkan halaman index produk (jika ada)
     */
    public function index()
    {
        return view('produk.index');
    }

    /**
     * Tampilkan halaman create produk
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:1000',
            'isi_per_pack' => 'required|integer|min:1',
            'satuan_pack' => 'required|string|max:50',
        ]);

        Product::create($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Tampilkan halaman edit produk.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('produk.edit', compact('product'));
    }

    /**
     * Update data produk yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:1000',
            'isi_per_pack' => 'required|integer|min:1',
            'satuan_pack' => 'required|string|max:50',
        ]);

        $product->update($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_produk' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
                'deskripsi' => 'nullable|string|max:1000',
            ]);

            Product::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan.',
                'data' => $request
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage(),
                'errors' => $request->errors()
            ], 422);
        }
    }

    /**
     * Tampilkan halaman edit produk.
     */
    public function edit($id)
    {
        $produk = Product::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    /**
     * Update data produk yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $product->update($request->all());

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }
}

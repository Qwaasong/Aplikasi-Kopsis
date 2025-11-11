<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk dengan pencarian dan pagination.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // 🔍 Pencarian global (nama, kategori, satuan_pack)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('satuan_pack', 'like', "%{$search}%");
            });
        }

        // 🔧 Filter tambahan (opsional)
        if ($filters = $request->input('filter')) {
            if (isset($filters['kategori']) && $filters['kategori']) {
                $query->where('kategori', $filters['kategori']);
            }

            if (isset($filters['satuan_pack']) && $filters['satuan_pack']) {
                $query->where('satuan_pack', $filters['satuan_pack']);
            }
        }

        // 🔢 Pagination (10 per halaman)
        $products = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'isi_per_pack' => 'required|numeric|min:1',
            'satuan_pack' => 'required|string',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ]);
    }

    /**
     * Menghapus produk (soft/hard delete sesuai kebutuhan).
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}

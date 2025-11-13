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
                  ->orWhere('kategori', 'like', "%{$search}%");
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

        // 🔢 Pagination (10 per halaman) - PASTIKAN field yang diperlukan di-select
        $products = $query->latest()->select(['id', 'nama', 'kategori', 'satuan_pack', 'isi_per_pack'])->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $products
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
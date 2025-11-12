<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Menampilkan daftar stok terkini semua produk.
     * Hitungan stok = total masuk - total keluar
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // 🔍 Pencarian berdasarkan nama produk atau kategori
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Ambil semua produk dengan relasi pembelian & stok keluar
        $products = $query->with(['purchaseItems', 'stockOuts'])->get();

        // Hitung stok terkini untuk setiap produk
        $data = $products->map(function ($product) {
            $masuk = $product->purchaseItems->sum('jumlah');
            $keluar = $product->stockOuts->sum('jumlah');
            $stok_terkini = $masuk - $keluar;

            return [
                'id' => $product->id,
                'nama' => $product->nama,
                'kategori' => $product->kategori,
                'stok_masuk' => $masuk,
                'stok_keluar' => $keluar,
                'stok_tersedia' => $stok_terkini,
                'satuan' => $product->satuan_pack,
            ];
        });

        $data = $query->latest()->select(['id', 'nama', 'kategori', 'satuan_pack', 'isi_per_pack'])->paginate(10);

        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'data' => $data,
        ]);
    }
}

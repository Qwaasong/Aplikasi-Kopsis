<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase; // Menggunakan model Purchase
use Illuminate\Http\Request;

class Barang_MasukController extends Controller
{
    /**
     * Tampilkan daftar Barang Masuk (Purchase) dengan paginasi dan pencarian.
     * Mirip dengan ProductController::index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search', '');

        $purchases = Purchase::with('vendor') 
            ->when($search, function ($query, $search) {
                // Sederhana: cari berdasarkan no_faktur saja, 
                // atau Anda bisa tambahkan pencarian di PurchaseItem/Vendor nanti.
                return $query->where('no_faktur', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage);

        return response()->json($purchases);
    }
    
    /**
     * Hapus satu Barang Masuk (Purchase) dari database.
     * Mirip dengan ProductController::destroy
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        
        // Catatan: Logika kompleks (stok/transaksi) harus ditangani di sini.
        // Untuk saat ini, kita biarkan sederhana dengan hanya menghapus data Purchase utama.
        $purchase->delete();

        return response()->json([
            'message' => 'Barang Masuk berhasil dihapus.',
        ], 200);
    }
}
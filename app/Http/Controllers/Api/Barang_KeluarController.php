<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockOut;
use Illuminate\Http\Request;

class Barang_KeluarController extends Controller
{
    /**
     * Menampilkan data barang keluar dengan pagination dan pencarian.
     */
    public function index(Request $request)
    {
        $query = StockOut::with('product'); // relasi ke product jika ada

        // Pencarian global
        if ($search = $request->input('search')) {
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })
            ->orWhere('keterangan', 'like', "%{$search}%");
        }

        // Filter tambahan (opsional)
        if ($filters = $request->input('filter')) {
            $query->filter($filters); // hanya jika kamu punya scopeFilter di model
        }

        // Pagination
        $stockOuts = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $stockOuts,
        ]);
    }

    

    /**
     * Menghapus data barang keluar (opsional untuk AJAX Delete)
     */
    public function destroy($id)
    {
        try {
            $data = StockOut::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data barang keluar berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data barang keluar',
                'error' => $e->getMessage()
            ]);
        }
    }
}

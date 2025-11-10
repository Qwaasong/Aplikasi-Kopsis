<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Menampilkan semua transaksi (masuk & keluar).
     */
    public function index(Request $request)
    {
        $query = Transaction::with('product');

        // Filter berdasarkan jenis transaksi: masuk / keluar
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Filter waktu (mingguan, bulanan, tahunan)
        if ($filter = $request->input('filter')) {
            $query->when($filter === 'minggu', fn($q) => 
                $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            );
            $query->when($filter === 'bulan', fn($q) => 
                $q->whereMonth('created_at', now()->month)
            );
            $query->when($filter === 'tahun', fn($q) => 
                $q->whereYear('created_at', now()->year)
            );
        }

        // Pencarian berdasarkan nama produk
        if ($search = $request->input('search')) {
            $query->whereHas('product', fn($q) => 
                $q->where('nama', 'like', "%{$search}%")
            );
        }

        $transactions = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $transactions,
        ]);
    }

    /**
     * Menambahkan transaksi baru (barang masuk / keluar).
     * type = masuk | keluar
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
            'type' => 'required|in:masuk,keluar',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Simpan transaksi
            $transaction = Transaction::create($validated);

            // Update stok produk
            $product = Product::find($validated['product_id']);
            if ($validated['type'] === 'masuk') {
                $product->stok += $validated['jumlah'];
            } else {
                $product->stok -= $validated['jumlah'];
                if ($product->stok < 0) {
                    throw new \Exception("Stok produk tidak mencukupi untuk transaksi keluar!");
                }
            }

            $product->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => $transaction,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Menghapus transaksi (opsional).
     * Jika dihapus, stok dikembalikan seperti semula.
     */
    public function destroy(Transaction $transaction)
    {
        DB::beginTransaction();

        try {
            $product = Product::find($transaction->product_id);

            if ($transaction->type === 'masuk') {
                $product->stok -= $transaction->jumlah;
            } else {
                $product->stok += $transaction->jumlah;
            }

            $product->save();
            $transaction->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus dan stok dikembalikan.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }
    // Ringkasan jumlah transaksi dalam minggu, bulan, dan tahun ini untuk chart
    public function summary()
    {
        $data = [
            'minggu' => Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'bulan' => Transaction::whereMonth('created_at', now()->month)->count(),
            'tahun' => Transaction::whereYear('created_at', now()->year)->count(),
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}

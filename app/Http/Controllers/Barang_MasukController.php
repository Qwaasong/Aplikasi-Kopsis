<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem; // NEW: Untuk menyimpan detail barang masuk
use App\Models\Product; // NEW: Untuk update stok
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // NEW: Untuk memastikan transaksi atomik

class Barang_MasukController extends Controller
{
    /**
     * Tampilkan halaman index Barang Masuk
     */
    public function index()
    {
        return view('barang_masuk.index');
    }

    /**
     * Tampilkan halaman create Barang Masuk
     */
    public function create()
    {
        // Dalam implementasi nyata, perlu memuat daftar Vendor dan Product untuk form
        return view('barang_masuk.store');
    }

    /**
     * Simpan Barang Masuk baru ke database, termasuk item-itemnya, dan update stok.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data Utama dan Item Pembelian
        $request->validate([
            'tanggal' => 'required|date',
            'vendor_id' => 'required|integer|exists:vendors,id', 
            'no_faktur' => 'nullable|string|max:255|unique:purchases,no_faktur',
            'keterangan' => 'nullable|string|max:1000',
            
            // Validasi array item
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.jumlah_pack' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction(); // Memulai transaksi database

        try {
            // 2. Buat Entri Purchase Utama
            $purchase = Purchase::create([
                'tanggal' => $request->tanggal,
                'vendor_id' => $request->vendor_id,
                'no_faktur' => $request->no_faktur,
                'keterangan' => $request->keterangan ?? null,
            ]);
            // Catatan: Model Purchase akan otomatis membuat FinancialTransaction (pengeluaran)

            // 3. Proses Item Pembelian dan Update Stok
            foreach ($request->items as $itemData) {
                // Simpan PurchaseItem
                $purchaseItem = new PurchaseItem($itemData);
                $purchase->items()->save($purchaseItem); // Menyimpan item terkait Purchase

                // Update Stok Produk (Asumsi: kolom stok di model Product adalah 'stock')
                Product::where('id', $itemData['product_id'])
                    ->increment('stock', $itemData['jumlah_pack']); 
            }

            DB::commit(); // Menyelesaikan transaksi

            return redirect()->route('barang_masuk.index')->with('success', 'Barang Masuk dan detail item berhasil dicatat. Stok diperbarui.');

        } 
    }

    /**
     * Tampilkan halaman edit Barang Masuk.
     */
    public function edit($id)
    {
        // Memuat detail Purchase dan PurchaseItem terkait
        $purchase = Purchase::with('items')->findOrFail($id); 
        return view('barang_masuk.edit', compact('purchase'));
    }

    /**
     * Update data Barang Masuk yang sudah ada (Hanya update header).
     */
    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'vendor_id' => 'required|integer|exists:vendors,id', 
            'no_faktur' => 'nullable|string|max:255|unique:purchases,no_faktur,' . $id,
            'keterangan' => 'nullable|string|max:1000',
        ]);
        
        // Catatan: Logika untuk memperbarui PurchaseItem (item di dalamnya)
        // dan menyesuaikan stok sangat kompleks, sehingga untuk saat ini 
        // hanya header Purchase yang diperbarui.
        $purchase->update($request->only(['tanggal', 'vendor_id', 'no_faktur', 'keterangan']));

        return redirect()->route('barang_masuk.index')->with('success', 'Header Barang Masuk berhasil diperbarui.');
    }
    
    /**
     * Hapus data Barang Masuk yang sudah ada.
     */
    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        
        // PENTING: Untuk implementasi yang lengkap, 
        // Anda perlu memastikan *semua* perubahan stok dan transaksi 
        // dibalikkan (dikurangi) sebelum baris di bawah dieksekusi.
        $purchase->delete();

        return redirect()->route('barang_masuk.index')->with('success', 'Barang Masuk berhasil dihapus.');
    }
}
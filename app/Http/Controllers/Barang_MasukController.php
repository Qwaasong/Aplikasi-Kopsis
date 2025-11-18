<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem; // NEW: Untuk menyimpan detail barang masuk
use App\Models\Product; // NEW: Untuk update stok
use App\Models\FinancialTransaction; // NEW: Untuk mencatat transaksi keuangan
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
            'items.*.jumlah_pack' => 'required|integer|min:1', // Hanya pack, tidak perlu satuan
            'items.*.harga_beli' => 'required|numeric|min:0',
            'items.*.harga_jual' => 'required|numeric|min:0', // Simpan harga jual baru
        ]);
        
        // Memastikan semua operasi database berjalan sukses (atomik)
        DB::beginTransaction();

        try {
            // 2. Simpan Header Pembelian (Purchase)
            $totalBiaya = collect($request->items)->sum(function ($item) {
                return $item['jumlah_pack'] * $item['harga_beli']; 
            });

            $purchase = Purchase::create(array_merge(
                $request->only(['tanggal', 'vendor_id', 'no_faktur', 'keterangan']),
                ['total_biaya' => $totalBiaya] // Tambahkan total biaya ke Purchase
            ));

            // 3. Simpan Detail Item Pembelian (PurchaseItem)
            $purchase->items()->createMany($request->items);

            // -----------------------------------------------------------------------------------
            // 4. Buat entri di Riwayat Transaksi (FinancialTransaction) sebagai PENGELUARAN
            // Pindahkan logika ini ke sini, menggunakan data $purchase yang benar.

            FinancialTransaction::create([
                'tanggal' => $purchase->tanggal,
                'tipe' => 'pengeluaran',
                'keterangan' => 'Biaya Pembelian Barang Masuk: ' . $purchase->no_faktur ?? $purchase->id,
                'jumlah' => $totalBiaya, // Gunakan total biaya yang sudah dihitung
                'purchase_id' => $purchase->id,
                'stock_out_id' => null,
            ]);

            // -----------------------------------------------------------------------------------
            // ...
            DB::commit();
            // 3. Simpan Detail Item Pembelian (PurchaseItem)
            // Model Event di PurchaseItem akan otomatis mengupdate stok (increment)
            // Model Event di Purchase akan otomatis membuat FinancialTransaction
            
            // Siapkan data item, hapus kunci yang tidak perlu dari input request
            $itemsData = collect($request->items)->map(function ($item) use ($purchase) {
                return [
                    'purchase_id' => $purchase->id, // Tambahkan foreign key
                    'product_id' => $item['product_id'],
                    'jumlah_pack' => $item['jumlah_pack'],
                    'harga_beli' => $item['harga_beli'],
                    'harga_jual' => $item['harga_jual'],
                    'created_at' => now(), // Tambahkan timestamp
                    'updated_at' => now(), // Tambahkan timestamp
                ];
            })->toArray();
            // ... (Langkah 1: Validasi data dan simpan data Barang Masuk/Purchase) ...            
            // Insert semua item sekaligus untuk efisiensi. 
            // NOTE: Batch insert tidak memicu Model Event, jadi harus diubah ke createMany.
            // Pilihan A: Menggunakan createMany (Memicu Model Event per item)
            $purchase->items()->createMany($request->items);

            // Pilihan B: Menggunakan batch insert (Lebih cepat, TAPI HARUS memanggil update stok secara manual)
            // $purchase->items()->insert($itemsData); 
            // foreach ($itemsData as $item) {
            //      Product::where('id', $item['product_id'])->increment('stok', $item['jumlah_pack']);
            // }

            DB::commit();

            $message = 'Barang Masuk berhasil disimpan.';
            
            // Logika Simpan dan Buat Lagi
            if ($request->has('save_and_create')) {
                return redirect()->route('barang_masuk.create')->with('success', $message);
            }

            return redirect()->route('barang_masuk.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            // Anda bisa log $e->getMessage() untuk debugging
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan Barang Masuk: ' . $e->getMessage());
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
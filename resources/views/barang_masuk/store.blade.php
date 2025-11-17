@extends('layouts.main')
@section('title', 'KopsisApp - Tambah Barang Masuk')

@php
    // Anggap ini sudah dimuat dari controller atau langsung di view
    // Dalam kasus nyata, lebih baik dimuat dari controller
    $vendors = \App\Models\Vendor::all();
    // Perlu memuat daftar produk juga untuk dropdown item
    $products = \App\Models\Product::all(); 
@endphp

@section('content')
    <style>
        /* CSS yang sudah ada... */
        .judul { padding: 4% 6% 5%; font-size: 25px; text-align: center; }
        .block { margin: 0 6%; }
        .form-section { margin-bottom: 24px; border-radius: 8px; padding: 0; }
        .form-row { display: flex; gap: 16px; margin-bottom: 24px; }
        .form-column { flex: 1; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px; }
        .form-input, .form-select, .form-textarea { 
            width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 6px; 
            font-size: 16px; transition: border-color 0.3s; background-color: #fafafa; 
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus { 
            outline: none; border-color: #4a90e2; background-color: white; 
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2); 
        }
        
        /* CSS Tambahan untuk Item */
        .item-section { 
            background-color: #f7f9fc; padding: 24px; border: 1px solid #e0e0e0; border-radius: 8px; 
            margin-bottom: 24px;
        }
        .item-table { 
            width: 100%; border-collapse: collapse; margin-top: 16px; 
        }
        .item-table th, .item-table td { 
            padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; 
        }
        .item-table th { 
            background-color: #eef1f7; font-weight: 600; font-size: 14px; color: #555;
        }
        .item-table td .form-input, .item-table td .form-select {
            padding: 8px;
        }
        .btn-add-item, .btn-remove-item {
            padding: 8px 12px; font-size: 14px; cursor: pointer; border-radius: 4px;
            transition: background-color 0.3s;
        }
        .btn-add-item {
            background-color: #4a90e2; color: white; border: none;
        }
        .btn-add-item:hover {
            background-color: #357ABD;
        }
        .btn-remove-item {
            background-color: #dc3545; color: white; border: none;
        }
        .btn-remove-item:hover {
            background-color: #c82333;
        }
        .total-row td { 
            border-top: 2px solid #333; font-weight: bold; 
        }
        
        /* CSS yang sudah ada untuk tombol */
        .button-container { 
            display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; 
            padding-bottom: 4%; 
        }
        .btn { 
            padding: 10px 20px; border: none; border-radius: 6px; 
            font-size: 16px; font-weight: 500; cursor: pointer; 
            transition: background-color 0.3s; 
        }
        .btn-save { background-color: #007bff; color: white; }
        .btn-save:hover { background-color: #0056b3; }
        .btn-save-again { background-color: #28a745; color: white; }
        .btn-save-again:hover { background-color: #1e7e34; }
        .btn-cancel { background-color: #6c757d; color: white; text-decoration: none; display: inline-block; }
        .btn-cancel:hover { background-color: #5a6268; }
        .error-message { color: #D20D24; margin-top: 5px; font-size: 14px; }
        
    </style>

    <div class="judul">Form Tambah Barang Masuk</div>
    
    @if ($errors->any())
        <div style="margin: 0 6%; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="block">
        <form action="{{ route('barang_masuk.store') }}" method="POST">
            @csrf
            
            <div class="form-section">
                <h3>Header Barang Masuk</h3>
                <div class="form-row">
                    <div class="form-column">
                        <label class="form-label" for="vendor_id">Vendor <span style="color: #D20D24;">*</span></label>
                        <select id="vendor_id" name="vendor_id" class="form-select" required>
                            <option value="">Pilih Vendor</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->nama_vendor }}
                                </option>
                            @endforeach
                        </select>
                        @error('vendor_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-column">
                        <label class="form-label" for="no_faktur">No Faktur</label>
                        <input type="text" id="no_faktur" name="no_faktur" class="form-input" 
                               placeholder="Masukkan nomor faktur..." value="{{ old('no_faktur') }}">
                        @error('no_faktur')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-column">
                        <label class="form-label" for="tanggal">Tanggal <span style="color: #D20D24;">*</span></label>
                        <input type="date" id="tanggal" name="tanggal" class="form-input" required 
                               value="{{ old('tanggal') ?? date('Y-m-d') }}">
                        @error('tanggal')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-column">
                        <label class="form-label" for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-textarea" rows="3" 
                                  placeholder="Tambahkan keterangan (opsional)...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="item-section">
                <h3>Detail Barang Masuk <button type="button" id="add-item-btn" class="btn-add-item">➕ Tambah Item</button></h3>
                <table class="item-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th style="width: 15%;">Jml. Pack</th>
                            <th style="width: 20%;">Harga Beli/Pack</th>
                            <th style="width: 20%;">Harga Jual/Pack</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="item-list">
                        </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="2" style="text-align: right;">Total Pengeluaran:</td>
                            <td colspan="3" id="total-pengeluaran">Rp 0</td>
                        </tr>
                    </tfoot>
                </table>
                @error('items')
                    <p class="error-message">Item pembelian harus diisi minimal 1.</p>
                @enderror
            </div>

            <div class="button-container">
                <button type="submit" name="save_and_create" value="1" class="btn btn-save-again">Simpan Data Dan Buat Lagi</button>
                <button type="submit" class="btn btn-save">Simpan</button>
                <a href="{{ route('barang_masuk.index') }}" class="btn btn-cancel">Batal</a>
            </div>
        </form>
    </div>

    <script>
        const itemList = document.getElementById('item-list');
        const addItemBtn = document.getElementById('add-item-btn');
        let itemIndex = 0; // Untuk index array di PHP (items[0], items[1], dst)

        // Template HTML untuk satu baris item
        function createItemRow(index) {
            const row = document.createElement('tr');
            row.id = `row-${index}`;
            row.innerHTML = `
                <td>
                    <select name="items[${index}][product_id]" class="form-select item-product" required>
                        <option value="">Pilih Produk</option>
                        @foreach ($products as $product)
                            <option 
                                value="{{ $product->id }}" 
                                data-harga-beli="{{ $product->harga_beli }}" 
                                data-harga-jual="{{ $product->harga_jual }}"
                            >
                                {{ $product->nama }} (Stok: {{ $product->stok }})
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="items[${index}][jumlah_pack]" class="form-input item-qty" 
                           min="1" value="1" required style="width: 100px;">
                </td>
                <td>
                    <input type="number" name="items[${index}][harga_beli]" class="form-input item-beli" 
                           min="0" value="0" required style="width: 120px;">
                </td>
                <td>
                    <input type="number" name="items[${index}][harga_jual]" class="form-input item-jual" 
                           min="0" value="0" required style="width: 120px;">
                </td>
                <td>
                    <button type="button" class="btn-remove-item" data-index="${index}">🗑️</button>
                </td>
            `;
            return row;
        }

        // Fungsi untuk menghitung total
        function calculateTotal() {
            let total = 0;
            itemList.querySelectorAll('tr').forEach(row => {
                const qtyInput = row.querySelector('.item-qty');
                const beliInput = row.querySelector('.item-beli');
                
                const qty = parseInt(qtyInput ? qtyInput.value : 0);
                const beli = parseInt(beliInput ? beliInput.value : 0);
                
                total += qty * beli;
            });

            document.getElementById('total-pengeluaran').textContent = formatRupiah(total);
        }
        
        // Fungsi format Rupiah sederhana
        function formatRupiah(angka) {
            let reverse = angka.toString().split('').reverse().join('');
            let ribuan = reverse.match(/\d{1,3}/g);
            let result = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + result;
        }

        // Handler untuk menambah item
        addItemBtn.addEventListener('click', () => {
            const newRow = createItemRow(itemIndex);
            itemList.appendChild(newRow);
            itemIndex++;
            calculateTotal(); // Hitung ulang setelah menambah

            // Jika ada data lama (old input) dari validasi gagal, isi datanya
            // (Logika ini akan sangat kompleks jika diimplementasikan sepenuhnya di sini)
        });

        // Handler untuk menghapus item dan perubahan input
        itemList.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-remove-item')) {
                const index = e.target.getAttribute('data-index');
                const row = document.getElementById(`row-${index}`);
                if (row) {
                    row.remove();
                    calculateTotal(); // Hitung ulang setelah menghapus
                }
            }
        });

        // Handler untuk perubahan di kolom Produk, Qty, dan Harga Beli
        itemList.addEventListener('change', (e) => {
            const target = e.target;
            if (target.classList.contains('item-product')) {
                // Ketika produk diubah, isi Harga Beli dan Harga Jual dari data-attribute
                const selectedOption = target.options[target.selectedIndex];
                const hargaBeli = selectedOption.getAttribute('data-harga-beli');
                const hargaJual = selectedOption.getAttribute('data-harga-jual');
                
                const row = target.closest('tr');
                if (row) {
                    row.querySelector('.item-beli').value = hargaBeli || 0;
                    row.querySelector('.item-jual').value = hargaJual || 0;
                }
                calculateTotal();
            } else if (target.classList.contains('item-qty') || target.classList.contains('item-beli')) {
                calculateTotal();
            }
        });
        
        itemList.addEventListener('input', (e) => {
             const target = e.target;
             if (target.classList.contains('item-qty') || target.classList.contains('item-beli')) {
                 calculateTotal();
             }
        });

        // Tambahkan satu baris item secara default saat halaman dimuat
        if (itemList.children.length === 0) {
            addItemBtn.click();
        }

        // Lakukan perhitungan total saat halaman dimuat (untuk kasus old input)
        document.addEventListener('DOMContentLoaded', calculateTotal);
    </script>
@endsection
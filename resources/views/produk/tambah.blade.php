@extends('layouts/main')
@section('title', 'KopsisApp - Vendor')
@section('content')

    <style>
        .judul {
            padding: 4% 6% 5%;
            font-size: 25px;

        }

        .block {
            margin: 0 6%;
        }

        .form-section {
            margin-bottom: 24px;
            border-radius: 8px;
            padding: 0;
        }

        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-column {
            flex: 1;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
            background-color: #fafafa;
        }

        .form-input::placeholder {
            color: #999;
            font-style: italic;
        }

        .form-input:focus {
            outline: none;
            border-color: #4a90e2;
            background-color: white;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.1);
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s;
            min-width: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: auto;
            min-height: 20px;
        }

        .btn-cancel {
            background-color: #D20D24;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #b00a1f;
        }

        .btn-save {
            background-color: #22C55E;
            color: white;
        }

        .btn-save:hover {
            background-color: #1ea34e;
        }

        .btn-save-again {
            background-color: #4a90e2;
            color: white;
        }

        .btn-save-again:hover {
            background-color: #3a7bc8;
        }

        /* Layout khusus untuk form produk */
        .form-row-top {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-row-bottom {
            display: flex;
            gap: 16px;
        }

        .vendor-column {
            flex: 1;
        }

        .satuan-column {
            flex: 1;
        }

        .kategori-column {
            flex: 1;
        }

        .isi-column {
            flex: 1;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .judul {
                padding: 8% 5% 6%;
            }

            .block {
                margin: 0 4%;
            }

            .form-row-top,
            .form-row-bottom {
                flex-direction: column;
                gap: 0;
                margin-bottom: 0;
            }

            .form-column,
            .vendor-column,
            .satuan-column,
            .kategori-column,
            .isi-column {
                margin-bottom: 16px;
            }

            .form-input {
                font-size: 16px;
                /* Prevent zoom on iOS */
                padding: 14px 12px;
            }

            .button-container {
                flex-direction: column;
                justify-content: center;
                gap: 12px;
            }

            .btn {
                width: 100%;
                padding: 14px 24px;
                font-size: 16px;
                min-height: 44px;
                /* Better touch target for mobile */
            }

            textarea.form-input {
                min-height: 100px;
            }
        }

        /* Small Mobile Devices */
        @media (max-width: 480px) {
            .judul {
                padding: 10% 4% 8%;
            }

            .block {
                margin: 0 2%;
            }

            .form-input {
                padding: 16px 12px;
            }

            .btn {
                padding: 16px 24px;
                font-size: 17px;
            }

            .judul h2 {
                font-size: 1.5rem;
                text-align: center;
            }
        }

        /* Very Small Devices */
        @media (max-width: 320px) {
            .judul {
                padding: 12% 3% 10%;
            }

            .block {
                margin: 0 1%;
            }

            .btn {
                padding: 18px 16px;
                font-size: 16px;
            }
        }
    </style>

    <div class="judul">
        <h2 class="font-bold">Tambah Produk</h2>
    </div>

    <div class="block">
        <form action="##" method="POST">
            @csrf

            <div class="form-section">
                <div class="form-row-top">
                    <div class="vendor-column">
                        <label class="form-label" for="nama_vendor">Nama Produk</label>
                        <input type="text" id="nama_vendor" name="nama_vendor" class="form-input"
                            placeholder="Nama Vendor..." required>
                    </div>

                    <div class="satuan-column">
                        <label class="form-label" for="satuan_pack">Satuan Pack</label>
                        <input type="text" id="satuan_pack" name="satuan_pack" class="form-input"
                            placeholder="Satuan Pack...">
                    </div>
                </div>

                <div class="form-row-bottom">
                    <div class="kategori-column">
                        <label class="form-label" for="kategori">Kategori</label>
                        <input type="text" id="kategori" name="kategori" class="form-input" placeholder="Kategori...">
                    </div>

                    <div class="isi-column">
                        <label class="form-label" for="isi_per_pack">Isi Per-Pack</label>
                        <input type="text" id="isi_per_pack" name="isi_per_pack" class="form-input"
                            placeholder="Isi Per-Pack...">
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button type="button" class="btn btn-cancel">Batal</button>
                <button type="submit" class="btn btn-save">Simpan</button>
                <button type="submit" name="save_and_create" value="1" class="btn btn-save-again">Simpan Data Dan Buat
                    Lagi</button>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/js/fab.js') }}"></script>
@endsection

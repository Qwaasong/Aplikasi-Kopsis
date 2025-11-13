@extends('layouts/main')
@section('title', 'KopsisApp - Tambah Barang Masuk')
@section('content')

    <style>
        .judul {
            padding: 4% 6% 5%;
            font-size: 25px;
            text-align: center;
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
            margin-bottom: 24px;
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

        .form-input, .form-select {
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

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #4a90e2;
            background-color: white;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.1);
        }
        
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
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
            align-items: center;
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

        @media (max-width: 768px) {
            .judul {
                padding: 8% 5% 6%;
            }

            .block {
                margin: 0 4%;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
                margin-bottom: 0;
            }

            .form-column {
                margin-bottom: 16px;
            }

            .button-container {
                padding: 12px;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 12px;
            }

            .btn {
                width: 100%;
                max-width: 300px;
                padding: 14px 24px;
                font-size: 16px;
                min-height: 44px;
            }
        }
    </style>

    <div class="judul">
        <h2 class="font-bold">Tambah Barang Masuk</h2>
    </div>

    <div class="block">
        <form action="" method="POST">
            @csrf
            <div class="form-section">
                <div class="form-row">
                    <div class="form-column">
                        <label class="form-label" for="tanggal">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-input" required>
                    </div>

                    <div class="form-column">
                        <label class="form-label" for="no_faktur">No Faktur</label>
                        <input type="text" id="no_faktur" name="no_faktur" class="form-input" placeholder="Nomor Faktur..." required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-column">
                        <label class="form-label" for="vendor_id">Vendor</label>
                        <select id="vendor_id" name="vendor_id" class="form-select" required>
                            <option value="" disabled selected>Pilih Vendor...</option>
                            {{-- Vendor options will be populated from the database --}}
                        </select>
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button type="submit" class="btn btn-save">Simpan</button>
                <button type="button" class="btn btn-cancel" onclick="window.location.href='{{ route('barang_masuk.index') }}'">Batal</button>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/js/fab.js') }}"></script>
@endsection
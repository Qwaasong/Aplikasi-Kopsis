<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LedgerEntry extends Model
{
    protected $fillable = [
        'nama',
        'telepon', 
        'tipe',
        'nominal',
        'keterangan',
        'tanggal_transaksi',
        'jatuh_tempo'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'jatuh_tempo' => 'date',
        'nominal' => 'decimal:2',
    ];

    // Scope untuk hutang
    public function scopeHutang($query)
    {
        return $query->where('tipe', 'hutang');
    }

    // Scope untuk piutang
    public function scopePiutang($query)
    {
        return $query->where('tipe', 'piutang');
    }

    // Scope berdasarkan nama
    public function scopeByNama($query, $nama)
    {
        return $query->where('nama', 'like', "%{$nama}%");
    }

    // Cek apakah telat bayar - PERBAIKAN
    public function isTerlambat(): bool
    {
        return $this->jatuh_tempo && Carbon::parse($this->jatuh_tempo)->isPast();
    }

    // Accessor untuk format tanggal
    public function getJatuhTempoFormattedAttribute()
    {
        return $this->jatuh_tempo ? Carbon::parse($this->jatuh_tempo)->format('d/m/Y') : '-';
    }

    public function getTanggalTransaksiFormattedAttribute()
    {
        return Carbon::parse($this->tanggal_transaksi)->format('d/m/Y');
    }
}
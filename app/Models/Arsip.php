<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $fillable = [
        'perusahaan_id',
        'nama',
        'tanggal',
        'tahun_pajak',
        'keterangan',
        'baris',
        'sisi',
        'rak',
        'lantai',
        'box',
        'url',
        'status',
    ];

    public function perusahaan() {
        return $this->belongsTo(Perusahaan::class);
    }
}

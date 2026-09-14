<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AngketHarian extends Model
{
    use HasFactory;

    protected $table = 'angket_harian';

    protected $fillable = [
        'orang_tua_id',
        'siswa_id',
        'tanggal',
        'bangun_pagi',
        'sholat_subuh',
        'sholat_ashar',
        'kegiatan_membantu',
        'sholat_magrib',
        'sholat_isya',
        'belajar',
        'sarapan',
        'makan_siang',
        'makan_malam',
        'olahraga',
        'tidur_malam',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'sholat_subuh' => 'boolean',
        'sholat_ashar' => 'boolean',
        'sholat_magrib' => 'boolean',
        'sholat_isya' => 'boolean',
        'belajar' => 'boolean',
        'sarapan' => 'boolean',
        'makan_siang' => 'boolean',
        'makan_malam' => 'boolean',
        'olahraga' => 'boolean',
    ];

    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AngketHarian extends Model
{
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
        'tidur_malam',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'sholat_subuh' => 'boolean',
        'sholat_ashar' => 'boolean',
        'sholat_magrib' => 'boolean',
        'sholat_isya' => 'boolean',
        'belajar' => 'boolean',
    ];

    /**
     * Angket ini diisi oleh orang tua.
     */
    public function orangTua(): BelongsTo
    {
        return $this->belongsTo(OrangTua::class, 'orang_tua_id');
    }

    /**
     * Angket ini berkaitan dengan siswa.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\AngketHarian;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'kelas_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function orangTua()
    {
        return $this->hasMany(OrangTua::class);
    }

    public function angketHarian()
    {
        return $this->hasMany(AngketHarian::class, 'siswa_id');
    }
}
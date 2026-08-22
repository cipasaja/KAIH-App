<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard khusus orang tua.
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan yang mengakses adalah orang tua
        if (!$user || $user->role !== 'orang_tua') {
            abort(403, 'Akses hanya untuk orang tua.');
        }

        // Ambil data orang tua beserta data siswa
        $orangTua = $user->orangTua()
            ->with('siswa.kelas')
            ->first();

        if (!$orangTua) {
            abort(
                403,
                'Akun orang tua belum terhubung dengan data orang tua.'
            );
        }

        $siswa = $orangTua->siswa;

        if (!$siswa) {
            abort(
                403,
                'Data siswa belum terhubung dengan orang tua.'
            );
        }

        // PENTING:
        // Jangan lagi menggunakan:
        // admin.orangtua.dashboard
        //
        // Gunakan view khusus orang tua.
        return view('orangtua.dashboard', compact(
            'user',
            'orangTua',
            'siswa'
        ));
    }
}
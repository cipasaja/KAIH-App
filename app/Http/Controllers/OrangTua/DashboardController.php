<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard Orang Tua
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan akun adalah orang tua
        if (!$user || $user->role !== 'orang_tua') {
            abort(403, 'Akses hanya untuk orang tua.');
        }

        // Ambil data orang tua beserta data siswa
        $orangTua = $user->orangTua()
            ->with('siswa.kelas')
            ->first();

        if (!$orangTua) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Akun orang tua belum terhubung dengan data orang tua.'
                );
        }

        // Tampilkan dashboard orang tua
        return view('orangtua.dashboard', compact(
            'user',
            'orangTua'
        ));
    }
}
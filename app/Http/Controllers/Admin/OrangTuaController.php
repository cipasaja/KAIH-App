<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    /**
     * Menampilkan data orang tua
     */
    public function index(Request $request)
    {
        // Ambil semua kelas untuk card kelas di halaman Orang Tua
        $kelas = Kelas::with('jurusan')
            ->withCount('siswas')
            ->orderBy('nama_kelas', 'asc')
            ->get();

        // Ambil data orang tua
        // Menggunakan paginate karena Blade memakai:
        // total(), firstItem(), dan links()
        $orangTuas = OrangTua::with([
            'siswa',
            'siswa.kelas'
        ])
            ->orderBy('id', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.orangtua.index',
            compact('orangTuas', 'kelas')
        );
    }


    /**
     * Menampilkan data orang tua berdasarkan kelas
     */
    public function kelas($id)
    {
        // Pastikan kelas yang dipilih memang ada
        $kelasTerpilih = Kelas::with('jurusan')
            ->findOrFail($id);

        // Ambil semua kelas
        // Dibutuhkan oleh card kelas pada Blade
        $kelas = Kelas::with('jurusan')
            ->withCount('siswas')
            ->orderBy('nama_kelas', 'asc')
            ->get();

        // Ambil orang tua yang siswanya berada
        // pada kelas yang dipilih
        $orangTuas = OrangTua::with([
            'siswa',
            'siswa.kelas'
        ])
            ->whereHas('siswa', function ($query) use ($id) {
                $query->where('kelas_id', $id);
            })
            ->orderBy('id', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.orangtua.index',
            compact(
                'orangTuas',
                'kelas',
                'kelasTerpilih'
            )
        );
    }


    /**
     * Menampilkan form tambah orang tua
     */
    public function create()
    {
        // Ambil data siswa untuk pilihan pada form tambah orang tua
        $siswas = Siswa::with('kelas')
            ->orderBy('nama_siswa', 'asc')
            ->get();

        return view(
            'admin.orangtua.create',
            compact('siswas')
        );
    }


    /**
     * Menyimpan data orang tua
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nama_orang_tua' => 'required|string|max:255',
            'nik' => 'nullable|string|max:50',
            'hubungan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
        ]);

        OrangTua::create($validated);

        return redirect()
            ->route('orangtua.index')
            ->with('success', 'Data orang tua berhasil ditambahkan.');
    }


    /**
     * Menampilkan form edit orang tua
     */
    public function edit($id)
    {
        $orangTua = OrangTua::with([
            'siswa',
            'siswa.kelas'
        ])->findOrFail($id);

        return view(
            'admin.orangtua.edit',
            compact('orangTua')
        );
    }


    /**
     * Mengupdate data orang tua
     */
    public function update(Request $request, $id)
    {
        $orangTua = OrangTua::findOrFail($id);

        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nama_orang_tua' => 'required|string|max:255',
            'nik' => 'nullable|string|max:50',
            'hubungan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
        ]);

        $orangTua->update($validated);

        return redirect()
            ->route('orangtua.index')
            ->with('success', 'Data orang tua berhasil diperbarui.');
    }


    /**
     * Menghapus data orang tua
     */
    public function destroy($id)
    {
        $orangTua = OrangTua::findOrFail($id);

        $orangTua->delete();

        return redirect()
            ->route('orangtua.index')
            ->with('success', 'Data orang tua berhasil dihapus.');
    }
}
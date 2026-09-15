<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Imports\OrangTuaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrangTuaController extends Controller
{
    /**
     * =========================================================
     * MENAMPILKAN DATA ORANG TUA
     * =========================================================
     */
    public function index(Request $request)
    {
        // Ambil semua kelas untuk card kelas
        $kelas = Kelas::with('jurusan')
            ->withCount('siswas')
            ->orderBy('nama_kelas', 'asc')
            ->get();

        // Ambil data orang tua
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
     * =========================================================
     * MENAMPILKAN DATA ORANG TUA BERDASARKAN KELAS
     * =========================================================
     */
    public function kelas($id)
    {
        // Pastikan kelas tersedia
        $kelasTerpilih = Kelas::with('jurusan')
            ->findOrFail($id);

        // Ambil semua kelas
        $kelas = Kelas::with('jurusan')
            ->withCount('siswas')
            ->orderBy('nama_kelas', 'asc')
            ->get();

        // Ambil orang tua berdasarkan kelas siswa
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
     * =========================================================
     * FORM TAMBAH ORANG TUA
     * =========================================================
     */
    public function create()
    {
        // Ambil data siswa untuk pilihan
        $siswas = Siswa::with('kelas')
            ->orderBy('nama_siswa', 'asc')
            ->get();

        return view(
            'admin.orangtua.create',
            compact('siswas')
        );
    }


    /**
     * =========================================================
     * SIMPAN ORANG TUA BARU
     * =========================================================
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
            ->with(
                'success',
                'Data orang tua berhasil ditambahkan.'
            );
    }


    /**
     * =========================================================
     * IMPORT EXCEL
     * =========================================================
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ], [
            'file.required' => 'File Excel wajib dipilih.',
            'file.mimes' => 'File harus berformat XLS atau XLSX.',
        ]);

        Excel::import(
            new OrangTuaImport,
            $request->file('file')
        );

        return redirect()
            ->route('orangtua.index')
            ->with(
                'success',
                'Data orang tua berhasil diimport.'
            );
    }


    /**
     * =========================================================
     * FORM EDIT ORANG TUA
     * =========================================================
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
     * =========================================================
     * UPDATE ORANG TUA
     * =========================================================
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
            ->with(
                'success',
                'Data orang tua berhasil diperbarui.'
            );
    }


    /**
     * =========================================================
     * HAPUS ORANG TUA
     * =========================================================
     */
    public function destroy($id)
    {
        $orangTua = OrangTua::findOrFail($id);

        $orangTua->delete();

        return redirect()
            ->route('orangtua.index')
            ->with(
                'success',
                'Data orang tua berhasil dihapus.'
            );
    }
}
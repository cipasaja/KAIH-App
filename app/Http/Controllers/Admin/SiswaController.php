<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Imports\SiswaImport;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * =========================================================
     * MENAMPILKAN DATA SISWA
     * =========================================================
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY DATA SISWA
        |--------------------------------------------------------------------------
        |
        | with('kelas') digunakan supaya data kelas ikut diambil.
        |
        */

        $query = Siswa::with('kelas');


        /*
        |--------------------------------------------------------------------------
        | FITUR PENCARIAN
        |--------------------------------------------------------------------------
        |
        | Bisa mencari berdasarkan:
        | - Nama siswa
        | - NIS
        |
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_siswa',
                    'like',
                    '%' . $search . '%'
                );

                $q->orWhere(
                    'nis',
                    'like',
                    '%' . $search . '%'
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | URUTAN DATA
        |--------------------------------------------------------------------------
        |
        | id ASC = data yang pertama kali ditambahkan
        | akan berada di No 1.
        |
        | Contoh:
        |
        | Data pertama  -> No 1
        | Data kedua    -> No 2
        | Data ketiga   -> No 3
        |
        */

        $siswas = $query
            ->orderBy('id', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.siswa.index',
            compact('siswas')
        );
    }


    /**
     * =========================================================
     * FORM TAMBAH SISWA
     * =========================================================
     */
    public function create()
    {
        $kelas = Kelas::orderBy(
            'nama_kelas',
            'asc'
        )->get();

        return view(
            'admin.siswa.create',
            compact('kelas')
        );
    }


    /**
     * =========================================================
     * SIMPAN SISWA BARU
     * =========================================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:50|unique:siswas,nis',
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS tersebut sudah terdaftar.',
            'nama_siswa.required' => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
        ]);

        Siswa::create($validated);

        return redirect()
            ->route('siswa.index')
            ->with(
                'success',
                'Data siswa berhasil ditambahkan.'
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
            new SiswaImport,
            $request->file('file')
        );

        return redirect()
            ->route('siswa.index')
            ->with(
                'success',
                'Data siswa berhasil diimport.'
            );
    }


    /**
     * =========================================================
     * EXPORT EXCEL
     * =========================================================
     */
    public function export()
    {
        return Excel::download(
            new SiswaExport,
            'data-siswa.xlsx'
        );
    }


    /**
     * =========================================================
     * FORM EDIT SISWA
     * =========================================================
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        $kelas = Kelas::orderBy(
            'nama_kelas',
            'asc'
        )->get();

        return view(
            'admin.siswa.edit',
            compact(
                'siswa',
                'kelas'
            )
        );
    }


    /**
     * =========================================================
     * UPDATE SISWA
     * =========================================================
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|max:50|unique:siswas,nis,' . $siswa->id,
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS tersebut sudah digunakan oleh siswa lain.',
            'nama_siswa.required' => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
        ]);

        $siswa->update($validated);

        return redirect()
            ->route('siswa.index')
            ->with(
                'success',
                'Data siswa berhasil diperbarui.'
            );
    }


    /**
     * =========================================================
     * HAPUS SISWA
     * =========================================================
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with(
                'success',
                'Data siswa berhasil dihapus.'
            );
    }
}
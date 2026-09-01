<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Imports\OrangTuaImport;
use Maatwebsite\Excel\Facades\Excel;

class OrangTuaController extends Controller
{
    /**
     * =========================================================
     * MENAMPILKAN DATA ORANG TUA
     * =========================================================
     *
     * Urutan berdasarkan ID terkecil ke terbesar.
     *
     * Artinya:
     * Data pertama ditambahkan = No. 1
     * Data berikutnya = No. 2
     * Data terbaru = nomor paling bawah
     */
    public function index()
    {
        $orangTuas = OrangTua::with('siswa')
            ->orderBy('id', 'asc')
            ->get();

        return view(
            'orangtua.index',
            compact('orangTuas')
        );
    }


    /**
     * =========================================================
     * FORM TAMBAH ORANG TUA
     * =========================================================
     */
    public function create()
    {
        $siswas = Siswa::orderBy(
            'nama_siswa',
            'asc'
        )->get();

        return view(
            'admin.orangtua.create',
            compact('siswas')
        );
    }


    /**
     * =========================================================
     * SIMPAN DATA ORANG TUA
     * =========================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' =>
                'required|exists:siswas,id',

            'nama_orang_tua' =>
                'required|string|max:255',

            'hubungan' =>
                'required|in:Ayah,Ibu,Wali',

            'no_hp' =>
                'nullable|string|max:30',

            'pekerjaan' =>
                'nullable|string|max:255',
        ], [
            'siswa_id.required' =>
                'Siswa wajib dipilih.',

            'siswa_id.exists' =>
                'Siswa yang dipilih tidak ditemukan.',

            'nama_orang_tua.required' =>
                'Nama orang tua wajib diisi.',

            'hubungan.required' =>
                'Hubungan wajib dipilih.',

            'hubungan.in' =>
                'Hubungan harus Ayah, Ibu, atau Wali.',
        ]);


        /**
         * -----------------------------------------------------
         * CEK DATA DUPLIKAT
         * -----------------------------------------------------
         *
         * Satu siswa tidak boleh memiliki hubungan yang sama
         * lebih dari satu.
         */
        $sudahAda = OrangTua::where(
                'siswa_id',
                $request->siswa_id
            )
            ->where(
                'hubungan',
                $request->hubungan
            )
            ->exists();


        if ($sudahAda) {

            return back()
                ->withInput()
                ->withErrors([
                    'siswa_id' =>
                        'Data ' .
                        $request->hubungan .
                        ' untuk siswa tersebut sudah ada.'
                ]);
        }


        /**
         * -----------------------------------------------------
         * SIMPAN DATA
         * -----------------------------------------------------
         */
        OrangTua::create([
            'siswa_id' =>
                $request->siswa_id,

            'nama_orang_tua' =>
                $request->nama_orang_tua,

            'hubungan' =>
                $request->hubungan,

            'no_hp' =>
                $request->no_hp,

            'pekerjaan' =>
                $request->pekerjaan,
        ]);


        return redirect()
            ->route('orangtua.index')
            ->with(
                'success',
                'Data orang tua berhasil ditambahkan.'
            );
    }


    /**
     * =========================================================
     * FORM EDIT ORANG TUA
     * =========================================================
     */
    public function edit($id)
    {
        $orangTua = OrangTua::findOrFail($id);

        $siswas = Siswa::orderBy(
            'nama_siswa',
            'asc'
        )->get();

        return view(
            'admin.orangtua.edit',
            compact(
                'orangTua',
                'siswas'
            )
        );
    }


    /**
     * =========================================================
     * UPDATE DATA ORANG TUA
     * =========================================================
     */
    public function update(
        Request $request,
        $id
    ) {
        $request->validate([
            'siswa_id' =>
                'required|exists:siswas,id',

            'nama_orang_tua' =>
                'required|string|max:255',

            'hubungan' =>
                'required|in:Ayah,Ibu,Wali',

            'no_hp' =>
                'nullable|string|max:30',

            'pekerjaan' =>
                'nullable|string|max:255',
        ], [
            'siswa_id.required' =>
                'Siswa wajib dipilih.',

            'siswa_id.exists' =>
                'Siswa yang dipilih tidak ditemukan.',

            'nama_orang_tua.required' =>
                'Nama orang tua wajib diisi.',

            'hubungan.required' =>
                'Hubungan wajib dipilih.',

            'hubungan.in' =>
                'Hubungan harus Ayah, Ibu, atau Wali.',
        ]);


        $orangTua = OrangTua::findOrFail($id);


        /**
         * -----------------------------------------------------
         * CEK DUPLIKAT SAAT UPDATE
         * -----------------------------------------------------
         */
        $sudahAda = OrangTua::where(
                'siswa_id',
                $request->siswa_id
            )
            ->where(
                'hubungan',
                $request->hubungan
            )
            ->where(
                'id',
                '!=',
                $orangTua->id
            )
            ->exists();


        if ($sudahAda) {

            return back()
                ->withInput()
                ->withErrors([
                    'siswa_id' =>
                        'Data ' .
                        $request->hubungan .
                        ' untuk siswa tersebut sudah ada.'
                ]);
        }


        /**
         * -----------------------------------------------------
         * UPDATE DATA
         * -----------------------------------------------------
         */
        $orangTua->update([
            'siswa_id' =>
                $request->siswa_id,

            'nama_orang_tua' =>
                $request->nama_orang_tua,

            'hubungan' =>
                $request->hubungan,

            'no_hp' =>
                $request->no_hp,

            'pekerjaan' =>
                $request->pekerjaan,
        ]);


        return redirect()
            ->route('orangtua.index')
            ->with(
                'success',
                'Data orang tua berhasil diperbarui.'
            );
    }


    /**
     * =========================================================
     * HAPUS DATA ORANG TUA
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


    /**
     * =========================================================
     * IMPORT EXCEL
     * =========================================================
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' =>
                'required|mimes:xlsx,xls',
        ], [
            'file.required' =>
                'File Excel wajib dipilih.',

            'file.mimes' =>
                'File harus berformat XLS atau XLSX.',
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
}
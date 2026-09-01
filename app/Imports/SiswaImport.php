<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;

class SiswaImport implements WithMultipleSheets, SkipsUnknownSheets
{
    /**
     * Daftar sheet yang akan diproses.
     *
     * Sheet lain seperti MUTASI dan XI SEMUA
     * sengaja tidak dimasukkan agar tidak menyebabkan
     * data siswa masuk tanpa kelas / duplikat.
     */
    public function sheets(): array
    {
        return [
            'DATA MBG'   => new SiswaSheetImport('DATA MBG', 4),
            
            'X 1 new'    => new SiswaSheetImport('X 1', 2),
            'X 2 new '   => new SiswaSheetImport('X 2', 2),
            'X 3 new'    => new SiswaSheetImport('X 3', 2),
            'X 4 new'    => new SiswaSheetImport('X 4', 2),
            'X 5 new'    => new SiswaSheetImport('X 5', 2),
            'X 6 new'    => new SiswaSheetImport('X 6', 2),
            'X 7 new'    => new SiswaSheetImport('X 7', 2),
            'X 8 new '   => new SiswaSheetImport('X 8', 2),

            'XI 1DY'     => new SiswaSheetImport('XI 1', 1),
            'XI 2DY'     => new SiswaSheetImport('XI 2', 1),
            'XI 3DY'     => new SiswaSheetImport('XI 3', 1),
        ];
    }

    /**
     * Aba yang tidak ada di daftar akan dilewati.
     */
    public function onUnknownSheet($sheetName)
    {
        // Sengaja dikosongkan.
        // Sheet seperti MUTASI dan XI SEMUA dilewati.
    }
}


/**
 * ============================================================
 * IMPORT PER SHEET
 * ============================================================
 */
class SiswaSheetImport implements ToCollection
{
    protected string $namaKelas;
    protected int $headerRow;

    public function __construct(string $namaKelas, int $headerRow)
    {
        $this->namaKelas = $namaKelas;
        $this->headerRow = $headerRow;
    }

    /**
     * Membaca semua data dalam sheet.
     */
    public function collection(Collection $rows)
    {
        /*
        |--------------------------------------------------------------------------
        | Cari kelas berdasarkan nama kelas
        |--------------------------------------------------------------------------
        */

        $kelas = $this->cariKelas($this->namaKelas);

        /*
        |--------------------------------------------------------------------------
        | Kalau kelas tidak ditemukan, hentikan sheet ini
        |--------------------------------------------------------------------------
        */

        if (!$kelas) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Header berada pada posisi berbeda-beda
        |--------------------------------------------------------------------------
        |
        | Excel:
        |
        | X 1 - X 8
        | Header di baris ke-2
        |
        | XI 1 - XI 3
        | Header di baris pertama
        |
        */

        $headerIndex = $this->headerRow - 1;

        if (!isset($rows[$headerIndex])) {
            return;
        }

        $header = $rows[$headerIndex]
            ->map(function ($value) {
                return $this->normalizeHeader($value);
            })
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Proses setiap baris setelah header
        |--------------------------------------------------------------------------
        */

        foreach ($rows->slice($headerIndex + 1) as $row) {

            $data = [];

            foreach ($header as $index => $column) {

                if ($column === '') {
                    continue;
                }

                $data[$column] = $row[$index] ?? null;
            }

            /*
            |--------------------------------------------------------------------------
            | Ambil nama
            |--------------------------------------------------------------------------
            */

            $nama = trim(
                (string) (
                    $data['nama_lengkap']
                    ?? $data['nama_siswa']
                    ?? ''
                )
            );

            /*
            |--------------------------------------------------------------------------
            | Ambil NIS
            |--------------------------------------------------------------------------
            */

            $nis = $this->bersihkanAngka(
                $data['nis'] ?? null
            );

            /*
            |--------------------------------------------------------------------------
            | Ambil jenis kelamin
            |--------------------------------------------------------------------------
            */

            $jk = strtoupper(
                trim(
                    (string) (
                        $data['jk']
                        ?? $data['jenis_kelamin']
                        ?? ''
                    )
                )
            );

            /*
            |--------------------------------------------------------------------------
            | Lewati baris kosong
            |--------------------------------------------------------------------------
            */

            if ($nama === '' && $nis === '') {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Validasi nama + NIS
            |--------------------------------------------------------------------------
            */

            if ($nama === '' || $nis === '') {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Normalisasi jenis kelamin
            |--------------------------------------------------------------------------
            */

            $jk = $this->normalisasiJenisKelamin($jk);

            if (!$jk) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | CEK NIS
            |--------------------------------------------------------------------------
            |
            | Kalau sudah ada:
            | - jangan membuat data baru
            | - tetapi kalau data lama belum punya kelas,
            |   kita isi kelasnya.
            |
            */

            $siswaLama = Siswa::where('nis', $nis)->first();

            if ($siswaLama) {

                /*
                | Kalau kelas siswa lama masih kosong,
                | isi berdasarkan sheet.
                */
                if (!$siswaLama->kelas_id) {
                    $siswaLama->update([
                        'kelas_id' => $kelas->id,
                    ]);
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | BUAT DATA SISWA BARU
            |--------------------------------------------------------------------------
            */

            Siswa::create([
                'nis' => $nis,
                'nama_siswa' => $nama,
                'jenis_kelamin' => $jk,
                'kelas_id' => $kelas->id,
            ]);
        }
    }


    /**
     * ============================================================
     * CARI KELAS
     * ============================================================
     */
    private function cariKelas(string $namaKelas)
    {
        /*
        |--------------------------------------------------------------------------
        | Bersihkan nama kelas
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | X 1
        | X1
        | X  1
        |
        | dianggap sama.
        |
        */

        $target = $this->normalisasiKelas($namaKelas);

        /*
        |--------------------------------------------------------------------------
        | Ambil semua kelas
        |--------------------------------------------------------------------------
        */

        $semuaKelas = Kelas::all();

        /*
        |--------------------------------------------------------------------------
        | Cocokkan satu per satu
        |--------------------------------------------------------------------------
        */

        foreach ($semuaKelas as $kelas) {

            $namaDatabase = $this->normalisasiKelas(
                $kelas->nama_kelas
            );

            if ($namaDatabase === $target) {
                return $kelas;
            }
        }

        return null;
    }


    /**
     * ============================================================
     * NORMALISASI NAMA KELAS
     * ============================================================
     */
    private function normalisasiKelas($nama)
    {
        $nama = strtoupper(
            trim(
                (string) $nama
            )
        );

        /*
        | Hapus semua spasi.
        |
        | X 1  -> X1
        | X1   -> X1
        | XI 1 -> XI1
        | XI1  -> XI1
        */

        $nama = preg_replace('/\s+/', '', $nama);

        return $nama;
    }


    /**
     * ============================================================
     * NORMALISASI HEADER
     * ============================================================
     */
    private function normalizeHeader($header)
    {
        if ($header === null) {
            return '';
        }

        $header = trim(
            strtolower(
                (string) $header
            )
        );

        /*
        | Hapus karakter aneh.
        */

        $header = preg_replace(
            '/[^a-z0-9]+/',
            '_',
            $header
        );

        $header = trim(
            $header,
            '_'
        );

        return $header;
    }


    /**
     * ============================================================
     * BERSIHKAN NIS
     * ============================================================
     */
    private function bersihkanAngka($value)
    {
        if ($value === null) {
            return '';
        }

        /*
        | Kalau Excel membaca NIS sebagai angka:
        |
        | 6737.0 -> 6737
        */

        if (is_numeric($value)) {
            return (string) ((int) $value);
        }

        return trim(
            (string) $value
        );
    }


    /**
     * ============================================================
     * NORMALISASI JENIS KELAMIN
     * ============================================================
     */
    private function normalisasiJenisKelamin($jk)
    {
        $jk = strtoupper(
            trim(
                (string) $jk
            )
        );

        /*
        | LAKI-LAKI
        */

        if (
            in_array($jk, [
                'L',
                'LAKI-LAKI',
                'LAKI LAKI',
                'LAKI',
                'PRIA',
            ])
        ) {
            return 'L';
        }

        /*
        | PEREMPUAN
        */

        if (
            in_array($jk, [
                'P',
                'PEREMPUAN',
                'WANITA',
            ])
        ) {
            return 'P';
        }

        return null;
    }
}
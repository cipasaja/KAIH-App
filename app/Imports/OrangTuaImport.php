<?php

namespace App\Imports;

use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;

class OrangTuaImport implements WithMultipleSheets, SkipsUnknownSheets
{
    /**
     * =========================================================
     * DAFTAR SHEET YANG AKAN DIPROSES
     * =========================================================
     */
    public function sheets(): array
    {
        return [
            'DATA MBG'   => new OrangTuaSheetImport(4),

            'X 1 new'    => new OrangTuaSheetImport(2),
            'X 2 new '   => new OrangTuaSheetImport(2),
            'X 3 new'    => new OrangTuaSheetImport(2),
            'X 4 new'    => new OrangTuaSheetImport(2),
            'X 5 new'    => new OrangTuaSheetImport(2),
            'X 6 new'    => new OrangTuaSheetImport(2),
            'X 7 new'    => new OrangTuaSheetImport(2),
            'X 8 new '   => new OrangTuaSheetImport(2),

            'XI 1DY'     => new OrangTuaSheetImport(1),
            'XI 2DY'     => new OrangTuaSheetImport(1),
            'XI 3DY'     => new OrangTuaSheetImport(1),
        ];
    }

    /**
     * Sheet yang tidak terdaftar akan dilewati.
     */
    public function onUnknownSheet($sheetName)
    {
        // Sengaja dikosongkan.
    }
}


/**
 * ============================================================
 * IMPORT DATA PER SHEET
 * ============================================================
 */
class OrangTuaSheetImport implements ToCollection
{
    protected int $headerRow;

    public function __construct(int $headerRow)
    {
        $this->headerRow = $headerRow;
    }


    /**
     * ============================================================
     * PROSES DATA SHEET
     * ============================================================
     */
    public function collection(Collection $rows)
    {
        /*
        |--------------------------------------------------------------------------
        | POSISI HEADER
        |--------------------------------------------------------------------------
        */

        $headerIndex = $this->headerRow - 1;

        if (!isset($rows[$headerIndex])) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI HEADER
        |--------------------------------------------------------------------------
        */

        $header = $rows[$headerIndex]
            ->map(function ($value) {
                return $this->normalizeHeader($value);
            })
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | PROSES DATA SETELAH HEADER
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
            | AMBIL NIS
            |--------------------------------------------------------------------------
            */

            $nis = $this->bersihkanAngka(
                $data['nis'] ?? null
            );


            /*
            |--------------------------------------------------------------------------
            | LEWATI BARIS KOSONG
            |--------------------------------------------------------------------------
            */

            if ($nis === '') {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | CARI SISWA
            |--------------------------------------------------------------------------
            */

            $siswa = Siswa::where('nis', $nis)->first();


            /*
            |--------------------------------------------------------------------------
            | JIKA SISWA TIDAK DITEMUKAN
            |--------------------------------------------------------------------------
            */

            if (!$siswa) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | DATA AYAH
            |--------------------------------------------------------------------------
            */

            $namaAyah = $this->bersihkanString(
                $data['nama_ayah'] ?? null
            );

            $pekerjaanAyah = $this->bersihkanString(
                $data['pekerjaan_ayah'] ?? null
            );


            if ($namaAyah !== null) {

                OrangTua::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'hubungan' => 'Ayah',
                    ],
                    [
                        'nama_orang_tua' => $namaAyah,
                        'pekerjaan' => $pekerjaanAyah,
                        'no_hp' => null,
                    ]
                );
            }


            /*
            |--------------------------------------------------------------------------
            | DATA IBU
            |--------------------------------------------------------------------------
            */

            $namaIbu = $this->bersihkanString(
                $data['nama_ibu'] ?? null
            );

            $pekerjaanIbu = $this->bersihkanString(
                $data['pekerjaan_ibu'] ?? null
            );


            if ($namaIbu !== null) {

                OrangTua::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'hubungan' => 'Ibu',
                    ],
                    [
                        'nama_orang_tua' => $namaIbu,
                        'pekerjaan' => $pekerjaanIbu,
                        'no_hp' => null,
                    ]
                );
            }
        }
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

        $header = preg_replace(
            '/[^a-z0-9]+/',
            '_',
            $header
        );

        return trim(
            $header,
            '_'
        );
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

        if (is_numeric($value)) {
            return (string) ((int) $value);
        }

        return trim(
            (string) $value
        );
    }


    /**
     * ============================================================
     * BERSIHKAN STRING
     * ============================================================
     */
    private function bersihkanString($value)
    {
        if ($value === null) {
            return null;
        }

        $value = trim(
            (string) $value
        );

        return $value === ''
            ? null
            : $value;
    }
}
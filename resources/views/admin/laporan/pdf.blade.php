<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Angket Harian Siswa
    </title>


    <style>

        @page {
            size: A4 landscape;
            margin: 15px;
        }


        * {
            box-sizing: border-box;
        }


        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #222;
            margin: 0;
            padding: 0;
        }


        /* =====================================================
           HEADER
        ====================================================== */

        .header {
            text-align: center;
            margin-bottom: 15px;
        }


        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }


        .header p {
            margin: 4px 0 0;
            font-size: 9px;
            color: #555;
        }


        /* =====================================================
           FILTER
        ====================================================== */

        .filter {
            margin-bottom: 12px;
        }


        .filter table {
            width: 100%;
            border-collapse: collapse;
        }


        .filter td {
            border: none;
            padding: 2px;
            font-size: 8px;
        }


        .filter-label {
            width: 100px;
            font-weight: bold;
        }


        /* =====================================================
           TABLE
        ====================================================== */

        .report-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }


        .report-table th {
            background: #eeeeee;
            border: 1px solid #777;
            padding: 5px 3px;
            text-align: center;
            font-size: 7px;
            font-weight: bold;
        }


        .report-table td {
            border: 1px solid #999;
            padding: 4px 3px;
            font-size: 7px;
            word-wrap: break-word;
        }


        .center {
            text-align: center;
        }


        /* =====================================================
           LEBAR KOLOM
        ====================================================== */

        .col-no {
            width: 25px;
        }


        .col-tanggal {
            width: 65px;
        }


        .col-siswa {
            width: 80px;
        }


        .col-nis {
            width: 50px;
        }


        .col-bangun {
            width: 65px;
        }


        .col-sholat {
            width: 50px;
        }


        .col-belajar {
            width: 50px;
        }


        .col-kegiatan {
            width: 130px;
        }


        .col-tidur {
            width: 60px;
        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .footer {
            margin-top: 12px;
            font-size: 8px;
        }


        .footer p {
            margin: 2px 0;
        }


    </style>

</head>


<body>


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="header">

        <h1>
            LAPORAN ANGKET HARIAN SISWA
        </h1>

        <p>
            KAIH App - Sistem Akademik
        </p>

    </div>


    {{-- =====================================================
         FILTER
    ====================================================== --}}

    <div class="filter">

        <table>

            <tr>

                <td class="filter-label">
                    Tanggal Mulai
                </td>

                <td>
                    :
                    {{ $tanggalMulai ?: 'Semua tanggal' }}
                </td>

            </tr>


            <tr>

                <td class="filter-label">
                    Tanggal Selesai
                </td>

                <td>
                    :
                    {{ $tanggalSelesai ?: 'Semua tanggal' }}
                </td>

            </tr>


            <tr>

                <td class="filter-label">
                    Siswa
                </td>

                <td>
                    :

                    @if($siswaId)

                        {{ optional(
                            $angket->first()?->siswa
                        )->nama_siswa ?? 'Siswa terpilih' }}

                    @else

                        Semua siswa

                    @endif

                </td>

            </tr>

        </table>

    </div>


    {{-- =====================================================
         TABEL
    ====================================================== --}}

    <table class="report-table">

        <thead>

            <tr>

                <th class="col-no">
                    No
                </th>

                <th class="col-tanggal">
                    Tanggal
                </th>

                <th class="col-siswa">
                    Siswa
                </th>

                <th class="col-nis">
                    NIS
                </th>

                <th class="col-bangun">
                    Bangun
                </th>

                <th class="col-sholat">
                    Subuh
                </th>

                <th class="col-sholat">
                    Dzuhur
                </th>

                <th class="col-sholat">
                    Ashar
                </th>

                <th class="col-sholat">
                    Magrib
                </th>

                <th class="col-sholat">
                    Isya
                </th>

                <th class="col-belajar">
                    Belajar
                </th>

                <th class="col-kegiatan">
                    Kegiatan Membantu
                </th>

                <th class="col-tidur">
                    Tidur
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($angket as $item)

                <tr>

                    <td class="center">
                        {{ $loop->iteration }}
                    </td>


                    <td class="center">

                        {{ \Carbon\Carbon::parse(
                            $item->tanggal
                        )->format('d/m/Y') }}

                    </td>


                    <td>

                        {{ $item->siswa->nama_siswa ?? '-' }}

                    </td>


                    <td class="center">

                        {{ $item->siswa->nis ?? '-' }}

                    </td>


                    <td class="center">

                        {{ $item->bangun_pagi ?? '-' }}

                    </td>


                    <td class="center">

                        {{ $item->sholat_subuh ? 'Ya' : 'Tidak' }}

                    </td>


                    <td class="center">

                        {{ $item->sholat_dzuhur ? 'Ya' : 'Tidak' }}

                    </td>


                    <td class="center">

                        {{ $item->sholat_ashar ? 'Ya' : 'Tidak' }}

                    </td>


                    <td class="center">

                        {{ $item->sholat_magrib ? 'Ya' : 'Tidak' }}

                    </td>


                    <td class="center">

                        {{ $item->sholat_isya ? 'Ya' : 'Tidak' }}

                    </td>


                    <td class="center">

                        {{ $item->belajar ? 'Ya' : 'Tidak' }}

                    </td>


                    <td>

                        {{ $item->kegiatan_membantu ?? '-' }}

                    </td>


                    <td class="center">

                        {{ $item->tidur_malam ?? '-' }}

                    </td>

                </tr>


            @empty

                <tr>

                    <td
                        colspan="13"
                        class="center"
                    >

                        Tidak ada data angket.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="footer">

        <p>

            <strong>
                Total Data:
            </strong>

            {{ $totalAngket }} angket

        </p>


        <p>

            <strong>
                Total Anak Belajar:
            </strong>

            {{ $totalBelajar }} angket

        </p>


        <p>

            <strong>
                Total Sholat:
            </strong>

            {{ $totalSholat }}

        </p>


        <p>

            Dicetak pada:

            {{ now()->format('d/m/Y H:i') }}

        </p>

    </div>


</body>

</html>
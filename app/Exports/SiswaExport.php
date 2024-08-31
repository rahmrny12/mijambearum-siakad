<?php

namespace App\Exports;

use App\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SiswaExport implements FromCollection, WithColumnFormatting, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $siswa = Siswa::join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->select(
                'siswa.nama_siswa',
                'siswa.jk',
                'siswa.tmp_lahir',
                'siswa.tgl_lahir',
                'siswa.rfid',
                'siswa.no_induk',
                'siswa.nis',
                'siswa.no_telp',
                'kelas.nama_kelas'
            )->get();

        return $siswa;
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function map($siswa): array
    {
        return [
            $siswa->nama_siswa,
            $siswa->jk,
            $siswa->tmp_lahir,
            $siswa->tgl_lahir,
            $siswa->rfid,
            $siswa->no_induk . ' ',
            $siswa->nis . ' ',
            $siswa->no_telp . ' ',
            $siswa->nama_kelas,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'RFID',
            'NIS',
            'NISN',
            'No Telepon',
            'Tingkat - Rombel',
        ];
    }
}

<?php

namespace App\Exports;

use App\AbsensiKehadiran;
use App\AbsensiKehadiranGuru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiGuruExport implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $absensi_kehadiran = AbsensiKehadiranGuru
        ::select('absen_kehadiran_guru.tanggal', 'absen_kehadiran_guru.jam_masuk', 'absen_kehadiran_guru.jam_pulang', 'absen_kehadiran_guru.status_masuk', 'guru.nama_guru', 'guru.nip')->leftJoin('guru', 'guru.id', '=', 'absen_kehadiran_guru.id_guru')->get();
        return $absensi_kehadiran;
    }
    
    public function headings(): array
    {
        return [
            'Tanggal',
            'Jam Masuk',
            'Jam Pulang',
            'Status Masuk',
            'Nama Guru',
            'NIP',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT,
        ];
    }
}

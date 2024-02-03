<?php

namespace App\Exports;

use App\AbsensiKehadiran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $absensi_kehadiran = AbsensiKehadiran::select('absen_kehadiran_siswa.tanggal', 'absen_kehadiran_siswa.jam_masuk', 'absen_kehadiran_siswa.jam_pulang', 'absen_kehadiran_siswa.status_masuk', 'kelas.nama_kelas', 'siswa.nama_siswa', 'siswa.no_induk', 'siswa.nis')->leftJoin('siswa', 'siswa.id', '=', 'absen_kehadiran_siswa.id_siswa')
        ->leftJoin('kelas', 'kelas.id', '=', 'siswa.kelas_id')
        ->get();
        return $absensi_kehadiran;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jam Masuk',
            'Jam Pulang',
            'Status Masuk',
            'Nama Kelas',
            'Nama Siswa',
            'No Induk',
            'NIS',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
        ];
    }
}

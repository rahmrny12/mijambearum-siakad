<?php

namespace App\Imports;

use App\Siswa;
use App\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $kelas = Kelas::where('nama_kelas', $row[8])->first();
        if ($row[2] == 'L') {
            $foto = 'uploads/siswa/52471919042020_male.jpg';
        } else {
            $foto = 'uploads/siswa/50271431012020_female.jpg';
        }

        $parsed_date = date_parse_from_format('d-m-Y', $row[3]);
        $tgl_lahir = date("Y-m-d", mktime(0, 0, 0, $parsed_date['month'], $parsed_date['day'], $parsed_date['year']));
        
        if ($kelas != null) {
            return new Siswa([
                'nama_siswa' => $row[0],
                'jk' => ($row[1] == 'Laki-laki' ? 'L' : $row[1] == 'Perempuan') ? 'P' : $row[1],
                'tmp_lahir' => $row[2],
                'tgl_lahir' => $tgl_lahir,
                'rfid' => $row[4],
                'no_induk' => $row[5],
                'nis' => $row[6],
                'foto' => $foto,
                'no_telp' => $row[6],
                'kelas_id' => $kelas->id,
            ]);
        }
    }
}
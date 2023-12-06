<?php

namespace App\Imports;

use App\Guru;
use App\Mapel;
use Maatwebsite\Excel\Concerns\ToModel;

class GuruImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[2] == 'L') {
            $foto = 'uploads/guru/27231912072020_male.jpg';
        } else {
            $foto = 'uploads/guru/50271431012020_female.jpg';
        }

        return new Guru([
            'nama_guru' => $row[0],
            'nip' => $row[1],
            'jk' => $row[2],
            'tmp_lahir' => $row[3],
            'rfid' => $row[4],
            'foto' => $foto,
        ]);
    }
}

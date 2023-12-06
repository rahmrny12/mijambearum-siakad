<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsensiKehadiran extends Model
{
    protected $guarded = [];
    protected $with = ['siswa'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id')->withDefault();
    }

    protected $table = 'absen_kehadiran_siswa';
}

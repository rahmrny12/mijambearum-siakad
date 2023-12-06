<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsensiKehadiranGuru extends Model
{
    protected $guarded = [];
    protected $with = ['guru'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id')->withDefault();
    }

    protected $table = 'absen_kehadiran_guru';
}

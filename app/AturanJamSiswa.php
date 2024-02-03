<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AturanJamSiswa extends Model
{
    use SoftDeletes;
    protected $guarded = [];
}

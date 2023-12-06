<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAturanJamToAbsensiKehadiran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absensi_kehadiran', function (Blueprint $table) {
            $table->string('aturan_jam_siswa_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absensi_kehadiran', function (Blueprint $table) {
            $table->dropColumn('aturan_jam_siswa_id');
        });
    }
}

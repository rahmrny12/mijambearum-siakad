<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiKehadiransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen_kehadiran_siswa', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('id_siswa');
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->enum('status_masuk', ['Tepat Waktu', 'Terlambat'])->nullable();
            $table->date('tanggal');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('absen_kehadiran_siswa');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleMenuAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('role_menu_access')) {
            Schema::create('role_menu_access', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('role_id');
                $table->integer('menu_id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('role_menu_access')) {
            Schema::dropIfExists('role_menu_access');
        }
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalLatihansTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('jadwal_latihans')) {
            Schema::create('jadwal_latihans', function (Blueprint $table) {
                $table->id();
                $table->string('kegiatan');
                $table->date('tanggal');
                $table->time('waktu_mulai');
                $table->time('waktu_selesai');
                $table->string('tempat');
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_latihans');
    }
}
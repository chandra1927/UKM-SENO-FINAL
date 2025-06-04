<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalLatihanTableV2 extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('jadwal_latihan')) {
            Schema::create('jadwal_latihan', function (Blueprint $table) {
                $table->id();
                $table->string('kegiatan');
                $table->date('tanggal');
                $table->string('waktu_mulai')->nullable();
                $table->string('waktu_selesai')->nullable();
                $table->string('tempat')->nullable();
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_latihan');
    }
}
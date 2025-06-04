<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalEventTableV2 extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('jadwal_event')) {
            Schema::create('jadwal_event', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                $table->date('tanggal');
                $table->string('waktu')->nullable();
                $table->string('tempat')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_event');
    }
}
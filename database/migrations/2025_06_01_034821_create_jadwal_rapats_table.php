<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalRapatTableV2 extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('jadwal_rapat')) {
            Schema::create('jadwal_rapat', function (Blueprint $table) {
                $table->id();
                $table->string('agenda');
                $table->date('tanggal');
                $table->string('waktu')->nullable();
                $table->string('tempat')->nullable();
                $table->text('notulen')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_rapat');
    }
}
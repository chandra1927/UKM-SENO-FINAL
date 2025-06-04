<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundlesTableV2 extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bundles')) {
            Schema::create('bundles', function (Blueprint $table) {
                $table->id();
                $table->string('nama_paket');
                $table->json('isi_paket'); // Menyimpan daftar musisi/anggota sebagai JSON
                $table->text('deskripsi')->nullable();
                $table->decimal('harga', 10, 2); // Harga dengan 2 desimal
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bundles');
    }
}
<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class CreateBiodatasTable extends Migration
   {
       public function up()
       {
           Schema::create('biodatas', function (Blueprint $table) {
               $table->id();
               $table->foreignId('user_id')->constrained()->onDelete('cascade');
               $table->string('nama_lengkap');
               $table->string('nim', 50)->unique();
               $table->string('divisi', 100);
               $table->string('angkatan', 10);
               $table->string('posisi', 100);
               $table->timestamps();
           });
       }

       public function down()
       {
           Schema::dropIfExists('biodatas');
       }
   }
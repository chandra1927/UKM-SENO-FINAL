<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Customer yang memesan
            $table->unsignedBigInteger('bundle_id'); // Bundle yang dipesan
            $table->decimal('total_harga', 10, 2); // Total harga
            $table->string('status')->default('pending'); // Status: pending, success, failed, cancelled
            $table->string('midtrans_order_id')->nullable(); // Order ID dari Midtrans
            $table->string('midtrans_payment_url')->nullable(); // URL pembayaran dari Midtrans
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bundle_id')->references('id')->on('bundles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
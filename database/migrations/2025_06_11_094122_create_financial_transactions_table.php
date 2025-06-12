<?php

use Illuminate\Database\Migrations;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schem;

class CreateFinancialTransactions extends Migration
{
    public function up()
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('description');
            $table->enum('type', ['pemasukan', 'pengeluaran']);
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_transactions');
    }
}
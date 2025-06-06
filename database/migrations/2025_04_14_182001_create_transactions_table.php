<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->enum('status', ['pending', 'paid', 'rejected'])->default('pending');
        $table->string('payment_proof')->nullable();
        $table->foreignId('approved_by')->nullable()->constrained('users');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

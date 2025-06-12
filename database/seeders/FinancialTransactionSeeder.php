<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialTransaction;
use App\Models\User;

class FinancialTransactionSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('role', 'keuangan')->first();

        FinancialTransaction::create([
            'user_id' => $user->id,
            'date' => '2025-06-01',
            'description' => 'Donasi Acara',
            'type' => 'pemasukan',
            'amount' => 1000000,
        ]);

        FinancialTransaction::create([
            'user_id' => $user->id,
            'date' => '2025-06-02',
            'description' => 'Pembelian Peralatan',
            'type' => 'pengeluaran',
            'amount' => 500000,
        ]);
    }
}
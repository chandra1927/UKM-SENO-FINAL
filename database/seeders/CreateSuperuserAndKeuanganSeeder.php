<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateSuperuserAndKeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat akun Superuser
        User::create([
            'name' => 'Superuser Name',
            'email' => 'superuser@chandra.com',
            'password' => bcrypt('password123'),
            'role' => 'superuser',
            'status' => 'approved',
        ]);

        // Membuat akun Keuangan
        User::create([
            'name' => 'Keuangan Name',
            'email' => 'keuangan@chandra.com',
            'password' => bcrypt('password123'),
            'role' => 'keuangan',
            'status' => 'approved',
        ]);
    }
}

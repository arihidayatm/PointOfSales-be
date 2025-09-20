<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@pos.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'), // ganti sesuai kebutuhan
            'roles' => 'admin',
        ]);

        // Kasir
        User::create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@pos.com',
            'phone' => '089876543210',
            'password' => Hash::make('12345678'), // ganti sesuai kebutuhan
            'roles' => 'kasir',
        ]);
    }
}

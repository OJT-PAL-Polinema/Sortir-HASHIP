<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- Import model User
use Illuminate\Support\Facades\Hash; // <-- Import Hash untuk enkripsi password

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Buat user baru
        User::create([
            'username' => 'admin',
            // PENTING: Selalu hash password, jangan simpan sebagai teks biasa!
            'password' => Hash::make('admin'), 
        ]);

    }
}
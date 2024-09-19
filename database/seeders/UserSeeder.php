<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'John Doe', // Pastikan kolom ini diisi
            'username' => 'example',
            'email' => 'example@example.com', // Tambahkan kolom email jika diperlukan
            'password' => Hash::make('password'),
        ]);
    }
}

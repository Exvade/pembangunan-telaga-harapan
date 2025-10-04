<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class BaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@telaga.id'], [
            'name' => 'Site Admin',
            'password' => Hash::make('pembangunanmantap24434'), // ganti di produksi
            'role' => 'admin',
        ]);
    }
}

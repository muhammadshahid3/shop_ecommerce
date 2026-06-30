<?php

namespace Database\Seeders;

use App\Models\Adminlogin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Adminlogin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'username' => 'admin',
                'password' => Hash::make('591139'),
                'phone_number' => '12345678910',
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Adminlogin;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Adminlogin::create([
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('591139'),
                'phone_number'=> '12345678910'
            ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminData = [
            [
                'name' => 'Admin 1',
                'username' => 'admin1',
                'email' => 'admin1@example.com',
                'password' => Hash::make('password'),

            ],
            [
                'name' => 'Admin 2',
                'username' => 'admin2',
                'email' => 'admin2@example.com',
                'password' => Hash::make('password'),
              
            ],
    
        ];

        foreach ($adminData as $admin) {
            User::create($admin);
        }
    }
}

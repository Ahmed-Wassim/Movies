<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        $superAdmin = User::create([
            'name' => 'Ahmed Wassim',
            'email' => 'ahmedwassim317@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $superAdmin->assignRole('super_admin');

        $Admin = User::create([
            'name' => 'Admin',
            'email' => 'Admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $Admin->assignRole('admin');

        $User = User::create([
            'name' => 'User',
            'email' => 'User@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $User->assignRole('user');
    }
}
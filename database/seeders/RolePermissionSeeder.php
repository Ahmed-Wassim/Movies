<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo([
            'create genres',
            'read genres',
            'update genres',
            'delete genres',
            'create movies',
            'read movies',
            'update movies',
            'delete movies',
        ]);

        $userRole = Role::where('name', 'user')->first();
        $userRole->givePermissionTo([
            'read movies',
            'read genres',
        ]);
    }
}

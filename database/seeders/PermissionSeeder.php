<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->truncate();

        // policies to users
        Permission::firstOrCreate([
            'name' => 'assign roles to users',
        ]);

        Permission::firstOrCreate([
            'name' => 'update roles to users',
        ]);

        Permission::firstOrCreate([
            'name' => 'delete roles from users',
        ]);

        // permissions

        Permission::firstOrCreate([
            'name' => 'create permission',
        ]);

        Permission::firstOrCreate([
            'name' => 'read permission',
        ]);

        Permission::firstOrCreate([
            'name' => 'update permission',
        ]);

        Permission::firstOrCreate([
            'name' => 'delete permission',
        ]);


        // roles

        Permission::firstOrCreate([
            'name' => 'create roles',
        ]);

        Permission::firstOrCreate([
            'name' => 'read roles',
        ]);

        Permission::firstOrCreate([
            'name' => 'update roles',
        ]);

        Permission::firstOrCreate([
            'name' => 'delete roles',
        ]);

        // genres

        Permission::firstOrCreate([
            'name' => 'create genres',
        ]);

        Permission::firstOrCreate([
            'name' => 'read genres',
        ]);

        Permission::firstOrCreate([
            'name' => 'update genres',
        ]);

        Permission::firstOrCreate([
            'name' => 'delete genres',
        ]);

        // movies

        Permission::firstOrCreate([
            'name' => 'create movies',
        ]);

        Permission::firstOrCreate([
            'name' => 'read movies',
        ]);

        Permission::firstOrCreate([
            'name' => 'update movies',
        ]);

        Permission::firstOrCreate([
            'name' => 'delete movies',
        ]);
    }
}

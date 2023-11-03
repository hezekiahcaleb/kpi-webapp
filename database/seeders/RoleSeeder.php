<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role_name' => 'ADMIN',
            'parent_id' => NULL
        ]);

        DB::table('roles')->insert([
            'role_name' => 'Owner',
            'parent_id' => NULL
        ]);

        DB::table('roles')->insert([
            'role_name' => 'Manager',
            'parent_id' => 2
        ]);

        DB::table('roles')->insert([
            'role_name' => 'Cashier',
            'parent_id' => 3
        ]);

        DB::table('roles')->insert([
            'role_name' => 'Clerk',
            'parent_id' => 3
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pw1 = 'admin';
        $pw1 = bcrypt($pw1);

        $pw2 = 'password';
        $pw2 = bcrypt($pw2);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role_id' => 2,
            'password' => $pw1
        ]);

        DB::table('users')->insert([
            'name' => 'John Owner',
            'email' => 'johnowner@gmail.com',
            'role_id' => 3,
            'password' => $pw2
        ]);

        DB::table('users')->insert([
            'name' => 'Lily Manager',
            'email' => 'lilymanager@gmail.com',
            'role_id' => 4,
            'password' => $pw2
        ]);

        DB::table('users')->insert([
            'name' => 'Kyla Cashier',
            'email' => 'kylacashier@gmail.com',
            'role_id' => 5,
            'password' => $pw2
        ]);

        DB::table('users')->insert([
            'name' => 'Dillan Clerk',
            'email' => 'dillanclerk@gmail.com',
            'role_id' => 6,
            'password' => $pw2
        ]);
    }
}

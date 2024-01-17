<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_mappings')->insert([
            'form_id' => 1,
            'role_id' => 4
        ]);

        DB::table('form_mappings')->insert([
            'form_id' => 2,
            'role_id' => 5
        ]);

        DB::table('form_mappings')->insert([
            'form_id' => 3,
            'role_id' => 6
        ]);

        DB::table('form_mappings')->insert([
            'form_id' => 4,
            'role_id' => 5
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_details')->insert([
            'form_id' => 1,
            'indicator_name' => 'Absensi',
            'description' => 'lorem ipsum',
            'target' => 20,
            'weight' => 30,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 1,
            'indicator_name' => 'Closing transaksi',
            'description' => 'lorem ipsum',
            'target' => 100,
            'weight' => 40,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 1,
            'indicator_name' => 'Akuisisi pelanggan baru',
            'description' => 'lorem ipsum',
            'target' => 20,
            'weight' => 30,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 2,
            'indicator_name' => 'Absensi',
            'description' => 'lorem ipsum',
            'target' => 20,
            'weight' => 30,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 2,
            'indicator_name' => 'Closing transaksi',
            'description' => 'lorem ipsum',
            'target' => 100,
            'weight' => 40,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 2,
            'indicator_name' => 'Akuisisi pelanggan baru',
            'description' => 'lorem ipsum',
            'target' => 20,
            'weight' => 30,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 3,
            'indicator_name' => 'Absensi',
            'description' => 'lorem ipsum',
            'target' => 20,
            'weight' => 30,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 3,
            'indicator_name' => 'Closing transaksi',
            'description' => 'lorem ipsum',
            'target' => 100,
            'weight' => 40,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 3,
            'indicator_name' => 'Akuisisi pelanggan baru',
            'description' => 'lorem ipsum',
            'target' => 20,
            'weight' => 30,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 4,
            'indicator_name' => 'Absensi',
            'description' => 'lorem ipsum',
            'target' => 20,
            'weight' => 30,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 4,
            'indicator_name' => 'Closing transaksi',
            'description' => 'lorem ipsum',
            'target' => 100,
            'weight' => 40,
            'higher_better' => 1
        ]);

        DB::table('form_details')->insert([
            'form_id' => 4,
            'indicator_name' => 'Akuisisi pelanggan baru',
            'description' => 'lorem ipsum',
            'target' => 20,
            'weight' => 30,
            'higher_better' => 1
        ]);
    }
}

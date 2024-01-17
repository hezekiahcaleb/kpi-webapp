<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forms')->insert([
            'form_name' => 'Manager 2023',
            'form_description' => 'KPI Form for Managers in 2023 period.',
            'from' => '2023-01-01',
            'to' => '2023-12-01'
        ]);

        DB::table('forms')->insert([
            'form_name' => 'Cashier 2023',
            'form_description' => 'KPI Form for Cashiers in 2023 period.',
            'from' => '2023-01-01',
            'to' => '2023-12-01'
        ]);

        DB::table('forms')->insert([
            'form_name' => 'Clerk 2023',
            'form_description' => 'KPI Form for Clerks in 2023 period.',
            'from' => '2023-01-01',
            'to' => '2023-12-01'
        ]);

        DB::table('forms')->insert([
            'form_name' => 'Cashier 2024',
            'form_description' => 'KPI Form for Cashiers in 2024 period.',
            'from' => '2024-01-01',
            'to' => '2024-12-01'
        ]);
    }
}

<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_tables.products')->insert([
            [
                'name' => 'Product 1',
                'code' => 'P001',
                'description' => 'Product 1 description',
                'selling_price' => 10000,
                'created_at' => now(),
            ],
            [
                'name' => 'Product 2',
                'code' => 'P002',
                'description' => 'Product 2 description',
                'selling_price' => 20000,
                'created_at' => now(),
            ],
            [
                'name' => 'Product 3',
                'code' => 'P003',
                'description' => 'Product 3 description',
                'selling_price' => 30000,
                'created_at' => now(),
            ],
        ]);
    }
}

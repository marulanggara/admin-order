<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_tables.customers')->insert([
            [
                'no_customer' => 'C001',
                'name' => 'Joko',
                'email' => 'joko@joko',
                'phone' => '08123456789',
                'address' => 'Jl. Jalan',
                'created_at' => now(),
            ],
            [
                'no_customer' => 'C002',
                'name' => 'Dedi',
                'email' => 'dedi@dedi',
                'phone' => '08123456789',
                'address' => 'Jl. Jalan',
                'created_at' => now(),
            ],
            [
                'no_customer' => 'C003',
                'name' => 'Budi',
                'email' => 'budi@budi',
                'phone' => '08123456789',
                'address' => 'Jl. Jalan',
                'created_at' => now(),
            ],
            [
                'no_customer' => 'C004',
                'name' => 'Siti',
                'email' => 'siti@siti',
                'phone' => '08123456789',
                'address' => 'Jl. Jalan',
                'created_at' => now(),
            ],
            [
                'no_customer' => 'C005',
                'name' => 'Rahayu',
                'email' => 'rahayu@rahayu',
                'phone' => '08123456789',
                'address' => 'Jl. Jalan',
                'created_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $countries = [
            [
                'name'        => 'India',
                'code'        => 'IN',
                'short_name'  => 'IND',
                'is_active'   => 1,
                'is_deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name'        => 'United States',
                'code'        => 'US',
                'short_name'  => 'USA',
                'is_active'   => 1,
                'is_deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name'        => 'United Kingdom',
                'code'        => 'GB',
                'short_name'  => 'UK',
                'is_active'   => 1,
                'is_deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name'        => 'Australia',
                'code'        => 'AU',
                'short_name'  => 'AUS',
                'is_active'   => 1,
                'is_deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        DB::table('countries')->insert($countries);
    }
}

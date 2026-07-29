<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            ['serial_no' => 1, 'usa_uk' => 'XS',  'eu' => '44', 'japan' => 'S',  'korea' => '85',  'chest_cm' => '81-86',  'chest_inches' => '32-34'],
            ['serial_no' => 2, 'usa_uk' => 'S',   'eu' => '46', 'japan' => 'M',  'korea' => '90',  'chest_cm' => '86-91',  'chest_inches' => '34-36'],
            ['serial_no' => 3, 'usa_uk' => 'M',   'eu' => '48', 'japan' => 'L',  'korea' => '95',  'chest_cm' => '91-96',  'chest_inches' => '36-38'],
            ['serial_no' => 4, 'usa_uk' => 'L',   'eu' => '50', 'japan' => 'LL', 'korea' => '100', 'chest_cm' => '96-101', 'chest_inches' => '38-40'],
            ['serial_no' => 5, 'usa_uk' => 'XL',  'eu' => '52', 'japan' => '3L', 'korea' => '105', 'chest_cm' => '101-106', 'chest_inches' => '40-42'],
            ['serial_no' => 6, 'usa_uk' => 'XXL', 'eu' => '54', 'japan' => '4L', 'korea' => '110', 'chest_cm' => '106-111', 'chest_inches' => '42-44'],
        ];

        foreach ($sizes as $size) {
            \App\Models\SizeChart::create($size);
        }
    }
}

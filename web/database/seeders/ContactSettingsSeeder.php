<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contact_settings')->updateOrInsert(
            ['id' => 1],
            [
                'store_address' => "452 15h Street, Office 741, Ohio,\nDe 47754, USA",
                'email_address' => "info@saaluvesa.com",
                'phone_number'  => "+91 9655482775",
                'updated_at'    => now(),
                'created_at'    => now(),
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ReligionSeeder extends Seeder
{
    public function run()
    {
        $religions = [
            'Hindu',
            'Muslim',
            'Christian',
            'Sikh',
            'Parsi',
            'Jain',
            'Buddhist',
            'Jewish',
            'No Religion',
            'Spiritual',
            ];

        foreach ($religions as $religion) {
            DB::table('religions')->insert([
                'name' => $religion,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

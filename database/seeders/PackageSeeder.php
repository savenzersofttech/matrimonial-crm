<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            'Exclusive 1 month'   => 30,
            'Exclusive 3 month'   => 90,
            'Exclusive 6 month'   => 180,
            'Elite 3 months'      => 90,
            'Exclushiv 45 days'   => 45,
            '1 year Exclusive'    => 365,
            'Open duration'       => 0,
            'Exclusive'           => 30,
        ];

        foreach ($plans as $name => $days) {
            Package::create([
                'name'          => $name,
                'slug'          => Str::slug($name),
                'duration_days' => $days,
                'price'         => $days * 10, 
                'type'          => str_contains(strtolower($name), 'elite') ? 'elite' : 'exclusive',
            ]);
        }
    }
}



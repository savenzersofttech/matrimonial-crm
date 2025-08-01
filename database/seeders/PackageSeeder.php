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
            ['name' => 'Exclusive 1 Month',   'days' => 30],
            ['name' => 'Exclusive 3 Month',   'days' => 90],
            ['name' => 'Exclusive 6 Month',   'days' => 180],
            ['name' => 'Elite 3 Months',      'days' => 90],
            ['name' => 'Exclushiv 45 Days',   'days' => 45],
            ['name' => '1 Year Exclusive',    'days' => 365],
            ['name' => 'Open Duration',       'days' => 0],
            ['name' => 'Exclusive',           'days' => 30],
        ];

        foreach ($plans as $plan) {
            // INR version
            Package::create([
                'name'           => $plan['name'] . ' (INR)',
                'slug'           => Str::slug($plan['name'] . '-inr'),
                'duration_days'  => $plan['days'],
                'price'          => $plan['days'] * 10,
                'currency'       => 'INR',
                'type'           => str_contains(strtolower($plan['name']), 'elite') ? 'elite' : 'exclusive',
            ]);

            // USD version
            Package::create([
                'name'           => $plan['name'] . ' (USD)',
                'slug'           => Str::slug($plan['name'] . '-usd'),
                'duration_days'  => $plan['days'],
                'price'          => round($plan['days'] * 0.15),
                'currency'       => 'USD',
                'type'           => str_contains(strtolower($plan['name']), 'elite') ? 'elite' : 'exclusive',
            ]);
        }
    }
}

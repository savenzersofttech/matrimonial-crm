<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $services = Role::create(['name' => 'services']);
        $sales = Role::create(['name' => 'sales']);

        // Services Permissions
        $servicesPermissions = [
            'welcome-call' => ['list', 'view', 'edit', 'delete'],
            'ongoing' => ['list', 'view', 'edit', 'delete'],
            'profile-reports' => ['list', 'view', 'edit', 'delete'],
            'payments' => ['list', 'view', 'edit', 'delete'],
        ];

        // Sales Permissions
        $salesPermissions = [
            'leads' => ['list', 'view', 'edit', 'delete'],
            'sales-tracking' => ['list', 'view', 'edit', 'delete'],
            'target' => ['list', 'view', 'edit', 'delete'],
            'tasks' => ['list', 'view', 'edit', 'delete'],
            'followup' => ['list', 'view', 'edit', 'delete'],
            'sales-report' => ['list', 'view', 'edit', 'delete'],
        ];

        // Create Permissions
        foreach ($servicesPermissions as $section => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "$action.$section"]);
            }
        }
        foreach ($salesPermissions as $section => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "$action.$section"]);
            }
        }

        // Assign Permissions to Roles
        $allServicesPermissions = array_merge(...array_map(
            fn($section, $actions) => array_map(fn($action) => "$action.$section", $actions),
            array_keys($servicesPermissions),
            array_values($servicesPermissions)
        ));

        $allSalesPermissions = array_merge(...array_map(
            fn($section, $actions) => array_map(fn($action) => "$action.$section", $actions),
            array_keys($salesPermissions),
            array_values($salesPermissions)
        ));

        $superAdmin->givePermissionTo(array_merge($allServicesPermissions, $allSalesPermissions));
        $admin->givePermissionTo(array_merge($allServicesPermissions, $allSalesPermissions));
        $services->givePermissionTo($allServicesPermissions);
        $sales->givePermissionTo($allSalesPermissions);

        // Create Super Admin User
        $superAdminUser = User::firstOrCreate(
            ['email' => 'super@cc.cc'],
            [
                'role' => 'super-admin',
                'name' => 'Super Admin',
                'password' => Hash::make('super@cc.cc'), 
            ]
        );

        // Assign Role to User
        $superAdminUser->assignRole('super-admin');

        // Create Services Role User
$servicesUser = User::firstOrCreate(
    ['email' => 'services@cc.cc'],
    [
        'role' => 'services',
        'name' => 'Service Executive',
        'password' => Hash::make('services@cc.cc'),
    ]
);
$servicesUser->assignRole('services');

// Create Sales Role User
$salesUser = User::firstOrCreate(
    ['email' => 'sales@cc.cc'],
    [
        'role' => 'sales',
        'name' => 'Sales Executive',
        'password' => Hash::make('sales@cc.cc'),
    ]
);
$salesUser->assignRole('sales');

    }
}
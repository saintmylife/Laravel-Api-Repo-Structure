<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $organizer = Role::where('name', 'organizer')->first();
        $endUser = Role::where('name', 'enduser')->first();
        $customer = Role::where('name', 'customer')->first();
        $permissions = config('app-config.permissions');

        foreach ($permissions as $permission) {
            $create = Permission::create(['name' => $permission]);
            $organizer->givePermissionTo($create);
            $endUser->givePermissionTo($create);
        }

        $customer->givePermissionTo(
            'events-read',
            'guests-create',
            'guests-read',
            'guests-update',
            'guests-delete',
            'guests-import',
            'guests-export',
        );
    }
}

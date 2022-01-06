<?php

namespace Database\Seeders;

use App\Modules\User\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
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

        Role::create([
            'name' => config('app.super_admin_role_name')
        ]);

        $user = User::find(1);
        $user->assignRole(1);
    }
}

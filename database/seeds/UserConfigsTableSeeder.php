<?php

use Illuminate\Database\Seeder;
use App\Modules\User\User;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserConfigsTableSeeder extends Seeder
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

        // create superadmin role
        // gets all permissions via Gate::before rule;
        $su = Role::create(['name' => 'super-admin']);
        // create superadmin user
        $admin = User::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('secret')
        ]);
        $admin->assignRole($su);
        $admin->markEmailAsVerified();
        // create permission
        // $permissions = [
        //     'CRUD Consumers',
        //     'CRUD Events',
        //     'CRUD Guests',
        //     'Consumers'
        // ];
        // foreach ($permissions as $permission) {
        //     Permission::create(['name' => $permission]);
        // }

        // create roles and assign existing permissions
        // Role::create(['name' => 'corporate'])->givePermissionTo('CRUD Events', 'CRUD Guests', 'CRUD Consumers');
        // Role::create(['name' => 'personal'])->givePermissionTo('CRUD Events', 'CRUD Guests');
        // Role::create(['name' => 'consumer'])->givePermissionTo('Consumers');
    }
}

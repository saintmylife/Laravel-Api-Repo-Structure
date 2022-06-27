<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::factory()->create([
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'name' => 'Mr. Admin',
            'password' => bcrypt('secret'),
            'address' => null,
            'phone' => 628123456789
        ]);
        $superAdmin->markEmailAsVerified();
        $role = Role::where('name', config('app-config.super_admin_role_name'))->first();
        $superAdmin->assignRole($role);
    }
}

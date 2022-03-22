<?php

namespace Database\Seeders;

use App\Modules\Role\Repository\RoleRepoInterface;
use App\Modules\User\Repository\UserRepoInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(RoleRepoInterface $repo, UserRepoInterface $userRepo)
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $repo->create([
            'name' => config('app-auth.super_admin_role_name')
        ]);

        $userRepo->find(1)->assignRole(1);
    }
}

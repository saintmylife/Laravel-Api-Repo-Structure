<?php

namespace Database\Seeders;

use App\Modules\Permission\Repository\PermissionRepoInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(PermissionRepoInterface $repo)
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $permissions = [
            'user-access'
        ];

        foreach ($permissions as $permission) {
            $repo->create(['name' => $permission]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Modules\User\Repository\UserRepoInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(UserRepoInterface $repo)
    {
        $repo->create([
            'email' => 'admin@admin.com',
            'name' => 'Mr. Admin',
            'password' => bcrypt('secret'),
        ])->markEmailAsVerified();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@admin.com',
            'name' => 'Mr. Admin',
            'password' => bcrypt('secret'),
        ])->markEmailAsVerified();
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'username' => 'super.admin',
            'email' => 'super.admin@larastart.com',
            'date_of_birth' => '1988-03-09',
            'country' => 'GB',
            'email_verified_at' => now(),
            'password' => 'password',
        ]);
        $superAdmin->assignRole('Super Admin');

        $awesomeAdmin = User::create([
            'name' => 'Awesome Admin',
            'username' => 'awesome.admin',
            'email' => 'awesome.admin@larastart.com',
            'date_of_birth' => '1988-10-25',
            'country' => 'GB',
            'email_verified_at' => now(),
            'password' => 'password',
        ]);
        $awesomeAdmin->assignRole('Admin');

        User::factory(200)->create()->each(function (User $user) {
            $user->assignRole('User');
        });
    }
}

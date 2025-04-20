<?php

namespace Database\Seeders;

use App\Models\Post;
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
            'name' => 'Michael King',
            'username' => 'michael.king',
            'email' => 'michael.king@larastart.com',
            'date_of_birth' => '1988-03-09',
            'country' => 'UKG',
            'email_verified_at' => now(),
            'password' => 'password',
        ]);
        $superAdmin->assignRole('Super Admin');

        $awesomeAdmin = User::create([
            'name' => 'Rachael Johnson',
            'username' => 'rachael.johnson',
            'email' => 'rachael.johnson@larastart.com',
            'date_of_birth' => '1988-10-25',
            'country' => 'UKG',
            'email_verified_at' => now(),
            'password' => 'password',
        ]);
        $awesomeAdmin->assignRole('Admin');

        User::factory(200)->create()->each(function (User $user) {
            $user->assignRole('User');

            Post::factory(rand(0, 10))->create([
                'user_id' => $user->id
            ]);        
        });
    }
}

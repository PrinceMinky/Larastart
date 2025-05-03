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

        $adminPosts = Post::factory(2)->create(['user_id' => $awesomeAdmin->id]);
        $superAdminPosts = Post::factory(2)->create(['user_id' => $superAdmin->id]);
    
        User::factory(200)->create()->each(function (User $user) {
            $user->assignRole('User');
    
            Post::factory(rand(0, 10))->create([
                'user_id' => $user->id
            ])->each(function ($post) {
                $users = User::inRandomOrder()->take(rand(1, 5))->get(); 

                foreach ($users as $likingUser) {
                    $likingUser->likedPosts()->attach($post->id);
                }
            });
    
            $potentialFollowers = User::where('id', '!=', $user->id)
                                      ->inRandomOrder()
                                      ->limit(rand(6, 20))
                                      ->get();
    
            foreach ($potentialFollowers as $follower) {
                $user->following()->syncWithoutDetaching([$follower->id => ['status' => 'accepted']]);
                $follower->following()->syncWithoutDetaching([$user->id => ['status' => 'accepted']]);
            }
        });
    
        $mutualFollowers = User::inRandomOrder()->limit(6)->get();
        
        foreach ($mutualFollowers as $mutualUser) {
            $superAdmin->following()->syncWithoutDetaching([$mutualUser->id => ['status' => 'accepted']]);
            $mutualUser->following()->syncWithoutDetaching([$superAdmin->id => ['status' => 'accepted']]);
    
            $awesomeAdmin->following()->syncWithoutDetaching([$mutualUser->id => ['status' => 'accepted']]);
            $mutualUser->following()->syncWithoutDetaching([$awesomeAdmin->id => ['status' => 'accepted']]);
        }
    
        $likingUsers = User::inRandomOrder()->limit(rand(10, 50))->get();
        
        foreach ($likingUsers as $user) {
            foreach ($adminPosts as $post) {
                $user->likedPosts()->attach($post->id);
            }
            foreach ($superAdminPosts as $post) {
                $user->likedPosts()->attach($post->id);
            }
        }

        
        $followRequesters = User::where('id', '!=', $superAdmin->id)
            ->inRandomOrder()
            ->limit(rand(12, 25))
            ->get();

        foreach ($followRequesters as $requester) {
            $requester->following()->syncWithoutDetaching([$superAdmin->id => ['status' => 'pending']]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Notifications\LikedPost;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserFollowed;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public bool $simpleSeed = false;
    
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
            'is_private' => 1,
        ]);
        $superAdmin->assignRole('Super Admin');
    
        $awesomeAdmin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@larastart.com',
            'date_of_birth' => '1988-10-25',
            'country' => 'GB',
            'email_verified_at' => now(),
            'password' => 'password',
        ]);
        $awesomeAdmin->assignRole('Admin');

        if(! $this->simpleSeed)
        {
            $adminPosts = Post::factory(2)->create(['user_id' => $awesomeAdmin->id]);
            $superAdminPosts = Post::factory(2)->create(['user_id' => $superAdmin->id]);
        
            User::factory(200)->create()->each(function (User $user) {
                $role = (mt_rand(1, 100) <= 10) ? 'Admin' : 'User';
                $user->assignRole($role);
        
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
                    $post->user->notify(new LikedPost($user, $post));
                }
                foreach ($superAdminPosts as $post) {
                    $user->likedPosts()->attach($post->id);
                    $post->user->notify(new LikedPost($user, $post));
                }
            }
              
            $followRequesters = User::where('id', '!=', $superAdmin->id)
                ->inRandomOrder()
                ->limit(rand(12, 25))
                ->get();
    
            foreach ($followRequesters as $requester) {
                $requester->following()->syncWithoutDetaching([$superAdmin->id => ['status' => 'pending']]);
                $superAdmin->notify(new UserFollowed($requester, 'pending'));
            }
        }
    }
}

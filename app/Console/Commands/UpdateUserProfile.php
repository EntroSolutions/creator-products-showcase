<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserProfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the admin user profile with sample data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::first();
        
        if (!$user) {
            $this->error('No user found in the database.');
            return 1;
        }
        
        $user->specialty = 'Full Stack Developer';
        $user->bio = 'Passionate about building innovative web applications with a focus on user experience and performance. I love creating elegant solutions to complex problems.';
        $user->twitter = 'https://twitter.com/adminuser';
        $user->github = 'https://github.com/adminuser';
        $user->website = 'https://example.com';
        $user->save();
        
        $this->info('User profile updated successfully!');
        return 0;
    }
} 
<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateFilamentUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-filament-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user who can access the Filament admin panel';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->ask('Name?');
        $email = $this->askValidEmail('Email?');
        $password = $this->askValidPassword('Password?');
        $bio = $this->ask('Bio (optional)?');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'bio' => $bio,
            // profile_picture_path can be added/updated via Filament later
        ]);

        // Optionally, make the first user the default creator if needed
        // For simplicity, we assume one creator for now

        $this->info("Filament user {$user->name} created successfully.");

        return self::SUCCESS;
    }

    /**
     * Prompt for a valid email.
     */
    private function askValidEmail(string $question): string
    {
        do {
            $email = $this->ask($question);
            $validator = Validator::make(['email' => $email], ['email' => ['required', 'email', 'unique:users,email']]);
            if ($validator->fails()) {
                $this->error($validator->errors()->first('email'));
                $email = null;
            }
        } while ($email === null);

        return $email;
    }

    /**
     * Prompt for a valid password.
     */
    private function askValidPassword(string $question): string
    {
        do {
            $password = $this->secret($question);
            $confirmPassword = $this->secret('Confirm Password?');

            if ($password !== $confirmPassword) {
                $this->error('Passwords do not match.');
                $password = null;
                continue;
            }

            $validator = Validator::make(['password' => $password], ['password' => ['required', Password::defaults()]]);
            if ($validator->fails()) {
                $this->error($validator->errors()->first('password'));
                $password = null;
            }
        } while ($password === null);

        return $password;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user {email} {password} {--role=user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user with a specific role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $roleName = $this->option('role');

        if (!in_array($roleName, ['user', 'admin'])) {
            $this.error('Invalid role. Please use "user" or "admin".');
            return 1;
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => ucfirst($roleName) . ' User',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        $user->syncRoles([$roleName]);

        $this->info("User {$user->email} created/updated successfully with the role of {$roleName}.");
        
        return 0;
    }
}

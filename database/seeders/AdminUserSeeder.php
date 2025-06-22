<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Garante que a role 'admin' exista
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Cria ou encontra o usuário administrador
        $adminUser = User::firstOrCreate(
            ['email' => 'ale@gmail.com'],
            [
                'name' => 'Alexandre Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Atribui a role 'admin' ao usuário
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }
    }
} 
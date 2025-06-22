<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa a tabela de usuários
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // Cria o usuário Administrador
        $admin = User::updateOrCreate(
            ['email' => 'contato.growandbuild@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Cria o usuário comum
        $user = User::updateOrCreate(
            ['email' => 'alexandrepessoalrodrigues@gmail.com'],
            [
                'name' => 'Usuário',
                'password' => Hash::make('password'),
            ]
        );
        
        if (!$user->hasRole('user')) {
            $user->assignRole('user');
        }
    }
}

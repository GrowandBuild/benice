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
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'contato.growandbuild@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Cria o usuário comum
        $user = User::create([
            'name' => 'Usuário',
            'email' => 'alexandrepessoalrodrigues@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');
    }
}

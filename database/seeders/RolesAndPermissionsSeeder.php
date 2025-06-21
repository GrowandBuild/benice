<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Desativa a checagem de chaves estrangeiras
        Schema::disableForeignKeyConstraints();

        // Limpa as tabelas
        Role::truncate();
        Permission::truncate();
        
        // Limpa a tabela pivot
        \DB::table('role_has_permissions')->truncate();
        \DB::table('model_has_roles')->truncate();
        \DB::table('model_has_permissions')->truncate();
        
        // Reativa a checagem de chaves estrangeiras
        Schema::enableForeignKeyConstraints();

        // Reseta o cache de roles e permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Cria a permissão para acessar o dashboard
        Permission::create(['name' => 'access dashboard']);

        // Cria a role 'admin' e dá a permissão a ela
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('access dashboard');

        // Cria a role 'user'
        Role::create(['name' => 'user']);
    }
}

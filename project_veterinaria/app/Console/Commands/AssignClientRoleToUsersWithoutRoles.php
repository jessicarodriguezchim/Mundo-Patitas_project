<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AssignClientRoleToUsersWithoutRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:assign-client-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asigna el rol "client" a todos los usuarios que no tengan ningún rol asignado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Buscando usuarios sin roles asignados...');

        // Obtener todos los usuarios que no tienen roles
        $usersWithoutRoles = User::doesntHave('roles')->get();

        if ($usersWithoutRoles->isEmpty()) {
            $this->info('No se encontraron usuarios sin roles asignados.');
            return Command::SUCCESS;
        }

        $this->info("Se encontraron {$usersWithoutRoles->count()} usuario(s) sin roles asignados.");

        $bar = $this->output->createProgressBar($usersWithoutRoles->count());
        $bar->start();

        foreach ($usersWithoutRoles as $user) {
            $user->assignRole('client');
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('✓ Se asignó el rol "client" a todos los usuarios sin roles.');

        return Command::SUCCESS;
    }
}

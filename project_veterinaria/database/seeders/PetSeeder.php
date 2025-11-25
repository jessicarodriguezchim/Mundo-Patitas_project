<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios clientes
        $clients = User::role('client')->get();

        if ($clients->isEmpty()) {
            $this->command->warn('No hay usuarios clientes. Ejecuta UserSeeder primero.');
            return;
        }

        // Crear mascotas para cada cliente
        foreach ($clients as $client) {
            // Crear 1-3 mascotas por cliente
            $petCount = rand(1, 3);
            
            Pet::factory($petCount)->create([
                'owner_id' => $client->id,
            ]);
        }

        $this->command->info('Mascotas creadas exitosamente.');
    }
}

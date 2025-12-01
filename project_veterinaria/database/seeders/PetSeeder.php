<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder: PetSeeder
 * 
 * Este seeder crea mascotas de prueba asociadas a los usuarios con rol 'client'.
 * Cada cliente recibe entre 1 y 3 mascotas aleatorias.
 * 
 * Dependencias:
 * - Requiere que RoleSeeder y UserSeeder se hayan ejecutado primero
 * - Solo crea mascotas para usuarios con rol 'client'
 * 
 * Uso: Se ejecuta automáticamente con php artisan db:seed
 */
class PetSeeder extends Seeder
{
    /**
     * Ejecutar el seeder
     * 
     * Obtiene todos los usuarios con rol 'client' y crea mascotas
     * aleatorias para cada uno. Si no hay clientes, muestra una advertencia.
     */
    public function run(): void
    {
        // Obtener todos los usuarios que tienen el rol 'client'
        // role('client') es un scope de Spatie Permission que filtra por rol
        $clients = User::role('client')->get();

        // Verificar que existan clientes antes de crear mascotas
        // Esto previene errores si el seeder se ejecuta antes que UserSeeder
        if ($clients->isEmpty()) {
            // Mostrar advertencia en la consola
            $this->command->warn('No hay usuarios clientes. Ejecuta UserSeeder primero.');
            return;  // Salir del método sin crear mascotas
        }

        // Iterar sobre cada cliente y crear mascotas para él
        foreach ($clients as $client) {
            // Determinar cuántas mascotas crear para este cliente (aleatorio entre 1 y 3)
            // Esto hace que el seeder sea más realista (algunos clientes tienen más mascotas que otros)
            $petCount = rand(1, 3);
            
            // Crear las mascotas usando el factory
            // create(['owner_id' => $client->id]) sobreescribe el owner_id predeterminado
            // para asegurar que las mascotas pertenezcan a este cliente específico
            Pet::factory($petCount)->create([
                'owner_id' => $client->id,  // Asignar todas las mascotas a este cliente
            ]);
        }

        // Mostrar mensaje de éxito en la consola
        $this->command->info('Mascotas creadas exitosamente.');
    }
}

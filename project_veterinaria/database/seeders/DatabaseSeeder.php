<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder Principal: DatabaseSeeder
 * 
 * Este es el seeder principal que coordina la ejecución de todos los demás seeders.
 * Define el orden en que se deben ejecutar los seeders para evitar errores
 * de dependencias (ej: no puedes crear usuarios con roles si los roles no existen).
 * 
 * Uso:
 * php artisan db:seed                    → Ejecuta este seeder (y todos los que llama)
 * php artisan migrate:fresh --seed       → Reinicia la BD y ejecuta seeders
 * php artisan db:seed --class=RoleSeeder → Ejecuta solo un seeder específico
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Ejecutar el seeding de la base de datos
     * 
     * Este método se ejecuta cuando corres php artisan db:seed.
     * Llama a todos los seeders en el orden correcto para evitar errores.
     * 
     * Orden importante:
     * 1. Roles primero (necesarios para asignar a usuarios)
     * 2. Usuarios segundo (necesarios para asociar mascotas)
     * 3. Mascotas último (dependen de usuarios existentes)
     */
    public function run(): void
    {
        // Llamar a los seeders en el orden correcto
        // call() ejecuta cada seeder en secuencia
        $this->call([
            RoleSeeder::class,    // 1. Primero crear los roles (admin, staff, client)
            UserSeeder::class,    // 2. Luego crear los usuarios y asignarles roles
            PetSeeder::class,     // 3. Finalmente crear las mascotas asociadas a los clientes
        ]);
    }
}

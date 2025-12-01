<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder: UserSeeder
 * 
 * Este seeder crea usuarios de prueba en el sistema con diferentes roles.
 * Es útil para desarrollo y testing, proporcionando cuentas listas para usar.
 * 
 * Usuarios creados:
 * - 1 Administrador
 * - 2 Personal (staff)
 * - 2 Clientes activos
 * - 1 Cliente inactivo (para pruebas de desactivación)
 * 
 * Todas las contraseñas son: 'password'
 * 
 * Uso: Se ejecuta automáticamente con php artisan db:seed
 */
class UserSeeder extends Seeder
{
    /**
     * Ejecutar el seeder
     * 
     * Crea los usuarios de prueba con sus respectivos roles asignados.
     * Cada usuario tiene datos de ejemplo para facilitar las pruebas.
     */
    public function run(): void
    {
        /**
         * Usuario Administrador
         * 
         * Tiene acceso completo al sistema y puede gestionar usuarios,
         * roles, y todas las funcionalidades administrativas.
         */
        $admin = User::factory()->create([
            'name' => 'Jessica Rodriguez',
            'email' => 'admin@mundopatitas.com',
            'password' => Hash::make('password'),  // Contraseña: 'password'
            'id_number' => '123456789',
            'phone' => '5555555555',
            'address' => 'Calle 123, Colonia 456',
            'is_active' => true,
        ]);
        // Asignar rol de administrador usando el método de Spatie Permission
        $admin->assignRole('admin');

        /**
         * Usuarios Staff (Personal de la clínica)
         * 
         * Pueden gestionar mascotas pero no usuarios ni roles.
         * Útiles para el personal que trabaja en la clínica.
         */
        $staff1 = User::factory()->create([
            'name' => 'Carlos Méndez',
            'email' => 'staff1@mundopatitas.com',
            'password' => Hash::make('password'),
            'id_number' => '987654321',
            'phone' => '5555555556',
            'address' => 'Avenida Principal 789',
            'is_active' => true,
        ]);
        $staff1->assignRole('staff');

        $staff2 = User::factory()->create([
            'name' => 'María González',
            'email' => 'staff2@mundopatitas.com',
            'password' => Hash::make('password'),
            'id_number' => '456789123',
            'phone' => '5555555557',
            'address' => 'Boulevard Norte 321',
            'is_active' => true,
        ]);
        $staff2->assignRole('staff');

        /**
         * Usuarios Clientes (Dueños de mascotas)
         * 
         * Pueden ver sus propias mascotas y su perfil.
         * No tienen acceso al panel administrativo.
         */
        $client1 = User::factory()->create([
            'name' => 'Juan Pérez',
            'email' => 'client1@mundopatitas.com',
            'password' => Hash::make('password'),
            'id_number' => '111222333',
            'phone' => '5555555558',
            'address' => 'Calle Sur 456',
            'is_active' => true,
        ]);
        $client1->assignRole('client');

        $client2 = User::factory()->create([
            'name' => 'Ana López',
            'email' => 'client2@mundopatitas.com',
            'password' => Hash::make('password'),
            'id_number' => '444555666',
            'phone' => '5555555559',
            'address' => 'Avenida Este 789',
            'is_active' => true,
        ]);
        $client2->assignRole('client');

        /**
         * Usuario Cliente Inactivo (para pruebas)
         * 
         * Este usuario está marcado como inactivo (is_active = false).
         * Útil para probar la funcionalidad de desactivación de usuarios
         * y verificar que los usuarios inactivos no puedan iniciar sesión
         * (si implementas esa validación).
         */
        $clientInactive = User::factory()->create([
            'name' => 'Pedro Martínez',
            'email' => 'client.inactive@mundopatitas.com',
            'password' => Hash::make('password'),
            'id_number' => '777888999',
            'phone' => '5555555560',
            'address' => 'Calle Oeste 123',
            'is_active' => false,  // Usuario inactivo
        ]);
        $clientInactive->assignRole('client');
    }
}

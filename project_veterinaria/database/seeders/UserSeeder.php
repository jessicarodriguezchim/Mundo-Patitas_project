<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Admin
        $admin = User::factory()->create([
            'name' => 'Jessica Rodriguez',
            'email' => 'admin@mundopatitas.com',
            'password' => Hash::make('password'),
            'id_number' => '123456789',
            'phone' => '5555555555',
            'address' => 'Calle 123, Colonia 456',
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Usuario Staff (Empleado)
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

        // Usuarios Clientes
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

        // Usuario cliente inactivo (para pruebas)
        $clientInactive = User::factory()->create([
            'name' => 'Pedro Martínez',
            'email' => 'client.inactive@mundopatitas.com',
            'password' => Hash::make('password'),
            'id_number' => '777888999',
            'phone' => '5555555560',
            'address' => 'Calle Oeste 123',
            'is_active' => false,
        ]);
        $clientInactive->assignRole('client');
    }
}

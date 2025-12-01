<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

/**
 * Seeder: RoleSeeder
 * 
 * Este seeder crea los roles del sistema en la base de datos.
 * Los roles definen los diferentes tipos de usuarios y sus permisos.
 * 
 * Roles creados:
 * - admin: Administrador con acceso completo al sistema
 * - staff: Personal de la clínica, puede gestionar mascotas
 * - client: Cliente/Dueño de mascotas, acceso limitado
 * 
 * Uso: Se ejecuta automáticamente con php artisan db:seed
 */
class RoleSeeder extends Seeder
{
    /**
     * Ejecutar el seeder
     * 
     * Crea los roles en la base de datos si no existen.
     * Utiliza firstOrCreate() para evitar duplicados si se ejecuta múltiples veces.
     */
    public function run(): void
    {
        // Definir los roles del sistema
        // Estos roles se usarán con Spatie Permission para control de acceso
        $roles = [
            'admin',    // Administrador del sistema
            'staff',    // Personal de la clínica veterinaria
            'client'    // Cliente/Dueño de mascotas
        ];
        
        // Crear cada rol en la base de datos
        foreach($roles as $role){
            // firstOrCreate() busca si el rol ya existe, si no existe lo crea
            // Esto evita errores si el seeder se ejecuta múltiples veces
            Role::firstOrCreate([
                'name' => $role,           // Nombre del rol
                'guard_name' => 'web'      // Guard de autenticación (web para aplicaciones web)
            ]);
        }
    }
}
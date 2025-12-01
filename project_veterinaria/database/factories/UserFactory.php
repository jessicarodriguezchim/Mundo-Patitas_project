<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * Factory: UserFactory
 * 
 * Este factory se utiliza para generar usuarios de prueba de forma automática.
 * Es útil para crear datos de prueba, seeders, y testing.
 * 
 * Uso:
 * User::factory()->create()                    → Crea un usuario con datos aleatorios
 * User::factory()->count(10)->create()         → Crea 10 usuarios
 * User::factory()->unverified()->create()      → Crea un usuario sin email verificado
 * 
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Contraseña estática compartida entre todas las instancias del factory
     * 
     * Se genera una vez y se reutiliza para todas las instancias,
     * mejorando el rendimiento al evitar generar múltiples hashes.
     */
    protected static ?string $password;

    /**
     * Define el estado por defecto del modelo
     * 
     * Este método devuelve un array con los valores predeterminados
     * que se usarán al crear un usuario. Laravel genera datos aleatorios
     * usando Faker para campos como nombre, email, etc.
     * 
     * @return array<string, mixed> Array con los atributos predeterminados del usuario
     */
    public function definition(): array
    {
        return [
            // Genera un nombre aleatorio usando Faker (ej: "Juan Pérez", "María García")
            'name' => fake()->name(),
            
            // Genera un email único y seguro (ej: "juan.perez@example.com")
            // unique() asegura que no se repita
            // safeEmail() genera un email válido
            'email' => fake()->unique()->safeEmail(),
            
            // Marca el email como verificado con la fecha/hora actual
            // Si quieres usuarios sin verificar, usa ->unverified()
            'email_verified_at' => now(),
            
            // Contraseña por defecto: 'password' (encriptada)
            // ??= significa: si $password es null, asigna el valor y úsalo
            // Esto genera el hash solo una vez para mejor rendimiento
            'password' => static::$password ??= Hash::make('password'),
            
            // Autenticación de dos factores (2FA) - no configurada por defecto
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            
            // Token para "recordar sesión" - string aleatorio de 10 caracteres
            'remember_token' => Str::random(10),
            
            // Ruta de la foto de perfil - null por defecto
            'profile_photo_path' => null,
            
            // ID del equipo actual (Laravel Jetstream Teams) - null por defecto
            'current_team_id' => null,
            
            // Número de identificación aleatorio único (10 dígitos)
            'id_number' => fake()->unique()->numerify('##########'),
            
            // Número de teléfono aleatorio
            'phone' => fake()->phoneNumber(),
            
            // Dirección aleatoria generada por Faker
            'address' => fake()->address(),
            
            // Usuario activo por defecto (true)
            'is_active' => true,
        ];
    }

    /**
     * Estado: Usuario con email no verificado
     * 
     * Modifica el factory para crear usuarios cuyo email no está verificado.
     * Útil para probar flujos de verificación de email.
     * 
     * Uso: User::factory()->unverified()->create()
     * 
     * @return static Factory modificado con email no verificado
     */
    public function unverified(): static
    {
        // state() permite modificar los atributos por defecto
        // Establece email_verified_at como null
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Estado: Usuario con equipo personal
     * 
     * Crea un usuario junto con su equipo personal (funcionalidad de Jetstream Teams).
     * Solo funciona si la aplicación tiene habilitadas las funcionalidades de equipos.
     * 
     * Uso: User::factory()->withPersonalTeam()->create()
     * 
     * @param callable|null $callback Función opcional para personalizar el equipo
     * @return static Factory modificado con equipo personal
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        // Verificar si Jetstream tiene habilitadas las funcionalidades de equipos
        if (! Features::hasTeamFeatures()) {
            // Si no tiene equipos habilitados, retornar el factory sin modificar
            return $this->state([]);
        }

        // Crear un equipo asociado al usuario usando has()
        // has() crea una relación cuando se crea el modelo principal
        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',  // Nombre del equipo basado en el nombre del usuario
                    'user_id' => $user->id,             // ID del dueño del equipo
                    'personal_team' => true,            // Marca como equipo personal
                ])
                ->when(is_callable($callback), $callback),  // Aplica callback si se proporciona
            'ownedTeams'  // Nombre de la relación en el modelo User
        );
    }
}

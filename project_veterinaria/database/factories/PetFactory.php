<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory: PetFactory
 * 
 * Este factory se utiliza para generar mascotas de prueba de forma automática.
 * Genera datos realistas incluyendo especies, razas específicas por especie,
 * y asigna un dueño aleatorio o crea uno nuevo.
 * 
 * Uso:
 * Pet::factory()->create()                      → Crea una mascota con datos aleatorios
 * Pet::factory()->count(5)->create()            → Crea 5 mascotas
 * Pet::factory()->create(['owner_id' => 1])     → Crea mascota para usuario específico
 * 
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo
     * 
     * Genera datos aleatorios realistas para una mascota, incluyendo:
     * - Nombre de mascota
     * - Especie aleatoria
     * - Raza específica según la especie seleccionada
     * - Edad aleatoria entre 0 y 15 años
     * - Dueño (crea uno nuevo o usa uno existente)
     * - Notas opcionales
     * 
     * @return array<string, mixed> Array con los atributos predeterminados de la mascota
     */
    public function definition(): array
    {
        // Lista de especies disponibles para las mascotas
        $species = ['Perro', 'Gato', 'Conejo', 'Hamster', 'Pájaro', 'Tortuga'];
        
        // Razas específicas para perros
        $dogBreeds = ['Labrador', 'Golden Retriever', 'Bulldog', 'Pastor Alemán', 'Beagle'];
        
        // Razas específicas para gatos
        $catBreeds = ['Persa', 'Siames', 'Maine Coon', 'British Shorthair', 'Ragdoll'];
        
        // Seleccionar una especie aleatoria
        $selectedSpecies = fake()->randomElement($species);
        
        // Inicializar la raza como null (opcional)
        $breed = null;
        
        // Asignar una raza específica solo si es Perro o Gato
        // Para otras especies (Conejo, Hamster, etc.) la raza queda como null
        if ($selectedSpecies === 'Perro') {
            $breed = fake()->randomElement($dogBreeds);
        } elseif ($selectedSpecies === 'Gato') {
            $breed = fake()->randomElement($catBreeds);
        }
        
        return [
            // Nombre aleatorio de mascota (usando firstName() para nombres de mascotas)
            'name' => fake()->firstName(),
            
            // Especie seleccionada aleatoriamente
            'species' => $selectedSpecies,
            
            // Raza (null para especies sin razas definidas, o raza específica para perros/gatos)
            'breed' => $breed,
            
            // Edad aleatoria entre 0 y 15 años
            'age' => fake()->numberBetween(0, 15),
            
            // Dueño de la mascota
            // User::factory() crea un nuevo usuario si no se especifica uno
            // Si quieres asignar a un usuario existente, pásalo: ['owner_id' => $userId]
            'owner_id' => User::factory(),
            
            // Notas opcionales (fake()->optional() a veces retorna null, a veces una oración)
            // Útil para simular mascotas con y sin notas adicionales
            'notes' => fake()->optional()->sentence(),
        ];
    }
}

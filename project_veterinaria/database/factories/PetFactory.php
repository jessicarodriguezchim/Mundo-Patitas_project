<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $species = ['Perro', 'Gato', 'Conejo', 'Hamster', 'Pájaro', 'Tortuga'];
        $dogBreeds = ['Labrador', 'Golden Retriever', 'Bulldog', 'Pastor Alemán', 'Beagle'];
        $catBreeds = ['Persa', 'Siames', 'Maine Coon', 'British Shorthair', 'Ragdoll'];
        
        $selectedSpecies = fake()->randomElement($species);
        $breed = null;
        
        if ($selectedSpecies === 'Perro') {
            $breed = fake()->randomElement($dogBreeds);
        } elseif ($selectedSpecies === 'Gato') {
            $breed = fake()->randomElement($catBreeds);
        }
        
        return [
            'name' => fake()->firstName(),
            'species' => $selectedSpecies,
            'breed' => $breed,
            'age' => fake()->numberBetween(0, 15),
            'owner_id' => User::factory(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Contributor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contributor>
 */
class ContributorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Contributor>
     */
    protected $model = Contributor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'affiliation' => fake()->company(),
            'phone_number' => fake()->numerify('08##########'),
            'address' => fake()->address(),
        ];
    }
}

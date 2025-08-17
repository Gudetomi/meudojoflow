<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Responsavel>
 */
class ResponsavelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_responsavel' => $this->faker->name('male'), // Gera um nome de responsável
            'cpf_responsavel' => $this->faker->unique()->numerify('###########'),
            'telefone_responsavel' => $this->faker->numerify('###########'),
            'email_responsavel' => $this->faker->unique()->safeEmail,
        ];
    }
}

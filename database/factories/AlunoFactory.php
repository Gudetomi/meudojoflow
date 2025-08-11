<?php

namespace Database\Factories;

use App\Models\Aluno;
use App\Models\User;
use App\Models\Unidade;
use App\Models\Turma;
use App\Models\Responsavel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aluno>
 */
class AlunoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idade = $this->faker->numberBetween(5, 40);
        $possuiResponsavel = $idade < 18;

        return [
            'nome_aluno' => $this->faker->name,
            'user_id' => User::inRandomOrder()->first()->id,
            'unidade_id' => Unidade::inRandomOrder()->first()->id,
            'turma_id' => Turma::inRandomOrder()->first()->id,
            'ativo' => true,
            'data_nascimento' => $this->faker->dateTimeBetween('-' . ($idade + 1) . ' years', '-' . $idade . ' years')->format('Y-m-d'),
            'cpf' => $this->faker->unique()->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail,
            'idade' => $idade,
            'sexo' => $this->faker->numberBetween(1, 2),
            'telefone' => $this->faker->numerify('###########'),
            'endereco' => $this->faker->streetAddress,
            'numero' => $this->faker->buildingNumber,
            'bairro' => $this->faker->word,
            'cidade' => $this->faker->city,
            'cep' => $this->faker->numerify('########'),
            'estado' => $this->faker->stateAbbr,
            'possui_responsavel' => $possuiResponsavel,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Aluno $aluno) {
            if ($aluno->possui_responsavel) {
                Responsavel::factory()->create([
                    'aluno_id' => $aluno->id,
                    'user_id' => $aluno->user_id,
                ]);
            }
        });
    }
}

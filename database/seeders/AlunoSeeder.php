<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Turma;
use App\Models\Aluno;
class AlunoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $turmas = Turma::all();

        // Se não houver turmas, não faz nada
        if ($turmas->isEmpty()) {
            return;
        }

        // Cria 100 alunos
        Aluno::factory(100)->create()->each(function ($aluno) use ($turmas) {
            // Para cada aluno criado, atribui-o a uma turma aleatória
            $aluno->turma_id = $turmas->random()->id;
            $aluno->save();
        });
    }
}

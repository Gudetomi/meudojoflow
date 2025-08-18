<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aluno;
use App\Models\Presenca;
use Carbon\Carbon;
class PresencaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alunos = Aluno::whereNotNull('turma_id')->get();
        foreach ($alunos as $aluno) {
            for ($i = 0; $i < 30; $i++) {
                Presenca::create([
                    'aluno_id' => $aluno->id,
                    'turma_id' => $aluno->turma_id,
                    'user_id' => $aluno->user_id,
                    'data_presenca' => Carbon::today()->subDays($i),
                    'presente' => (bool)random_int(0, 1),
                ]);
            }
        }
    }
}

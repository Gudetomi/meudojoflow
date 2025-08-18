<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unidade;
use App\Models\Turma;
use App\Models\Modalidade;
class TurmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = Unidade::all();
        $modalidades = Modalidade::all();

        if ($unidades->isEmpty() || $modalidades->isEmpty()) {
            $this->command->info('Nenhuma unidade ou modalidade encontrada, o TurmaSeeder não será executado.');
            return;
        }

        foreach ($unidades as $unidade) {
            Turma::factory(5)->create([
                'unidade_id' => $unidade->id,
                'user_id' => $unidade->user_id,
                'modalidade_id' => $modalidades->random()->id,
            ]);
        }
    }
}

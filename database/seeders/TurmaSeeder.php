<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unidade;
use App\Models\Turma;
class TurmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = Unidade::all();
        foreach ($unidades as $unidade) {
            Turma::factory(5)->create([
                'unidade_id' => $unidade->id,
                'user_id' => $unidade->user_id,
            ]);
        }
    }
}

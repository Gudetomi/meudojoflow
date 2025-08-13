<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modalidade;
use App\Models\Faixa;
use Illuminate\Support\Facades\DB;

class ModalidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faixas')->delete();
        DB::table('modalidades')->delete();
        $judo = Modalidade::create([
            'nome' => 'Judo',
            'descricao' => 'Arte marcial de origem japonesa',
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Branca',
            'ordem' => 1,
            'cor_principal' => '#FFFFFF',
            'cor_secundaria' => null,
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Branca ponta Cinza',
            'ordem' => 2,
            'cor_principal' => '#FFFFFF',
            'cor_secundaria' => '#8e8e8e',
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Cinza',
            'ordem' => 3,
            'cor_principal' => '#8e8e8e',
            'cor_secundaria' => null,
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Cinza ponta Azul',
            'ordem' => 4,
            'cor_principal' => '#8e8e8e',
            'cor_secundaria' => '#017fe8',
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Azul',
            'ordem' => 5,
            'cor_principal' => '#017fe8',
            'cor_secundaria' => null,
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Azul ponta Amarela',
            'ordem' => 6,
            'cor_principal' => '#017fe8',
            'cor_secundaria' => '#faed0c',
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Amarela',
            'ordem' => 7,
            'cor_principal' => '#faed0c',
            'cor_secundaria' => null,
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Amarela ponta Laranja',
            'ordem' => 8,
            'cor_principal' => '#faed0c',
            'cor_secundaria' => '#e46e0a',
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Laranja',
            'ordem' => 9,
            'cor_principal' => '#e46e0a',
            'cor_secundaria' => null,
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Verde',
            'ordem' => 10,
            'cor_principal' => '#02770e',
            'cor_secundaria' => null,
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Roxa',
            'ordem' => 11,
            'cor_principal' => '#71024e',
            'cor_secundaria' => null,
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Marrom',
            'ordem' => 12,
            'cor_principal' => '#4f240d',
            'cor_secundaria' => null,
        ]);

        Faixa::create([
            'modalidade_id' => $judo->id,
            'nome' => 'Faixa Preta',
            'ordem' => 13,
            'cor_principal' => '#000000',
            'cor_secundaria' => null,
        ]);
    }
}

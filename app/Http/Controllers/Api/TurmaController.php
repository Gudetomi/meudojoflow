<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Turma;

class TurmaController extends Controller
{
    public function getByUnidade($unidadeId)
    {
        dd($unidadeId);
        $turmas = Turma::where('unidade_id', $unidadeId)->where('ativo', true)->get(['id', 'nome_turma']);
        return response()->json($turmas);
    }
}

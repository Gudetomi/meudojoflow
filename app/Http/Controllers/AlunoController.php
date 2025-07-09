<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Unidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $unidades = Unidade::where('user_id', Auth::id())->where('ativo', true)->get();
        $turmas = Turma::where('user_id', Auth::id())->where('ativo', true)->get();
        
        $alunos = Aluno::where('user_id', Auth::id())
            // Filtra por termo de pesquisa (nome ou CPF)
            ->when($request->query('search'), function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nome_aluno', 'like', "%{$search}%")
                      ->orWhere('cpf', 'like', "%{$search}%");
                });
            })
            // Filtra por turma (relação muitos-para-muitos)
            ->when($request->query('turma_id'), function ($query, $turmaId) {
                $query->whereHas('turmas', function ($q) use ($turmaId) {
                    $q->where('turmas.id', $turmaId);
                });
            })
            // Filtra por unidade (relação através da turma)
            ->when($request->query('unidade_id'), function ($query, array|string|null $unidadeId) {
                $query->whereHas('turmas', function ($q) use ($unidadeId) {
                    $q->where('unidade_id', $unidadeId);
                });
            })
            ->latest() // Ordena os resultados pelos mais recentes
            ->paginate(10); // Pagina os resultados

        // 3. Retorna a view com todos os dados necessários
        return view('alunos.index', [
            'alunos' => $alunos,
            'unidades' => $unidades,
            'turmas' => $turmas,
            'filters' => $request->query() // Passa todos os filtros para a view
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Aluno $aluno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aluno $aluno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aluno $aluno)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aluno $aluno)
    {
        //
    }
}

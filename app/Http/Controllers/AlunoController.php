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
        $alunos = Aluno::where('user_id', Auth::id())
            ->with('turma')
            ->when($request->query('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nome_aluno', 'ilike', "%{$search}%")
                    ->orWhere('cpf', 'ilike', "%{$search}%");
                });
            })
            ->when($request->query('turma_id'), function ($query, $turmaId) {
                $query->where('turma_id', $turmaId);
            })
            ->when($request->query('unidade_id'), function ($query, $unidadeId) {
                $query->where('unidade_id', $unidadeId);
            })
            ->orderByDesc('created_at')
            ->paginate(10);
        $unidades = Unidade::where('user_id', Auth::id())->where('ativo', true)->get();
        $turmas = Turma::where('user_id', Auth::id())->where('ativo', true)->get(); 

        return view('alunos.index', [
            'alunos' => $alunos,
            'unidades' => $unidades,
            'turmas' => $turmas,
            'filters' => $request->query()
        ]);
   }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $unidades = Unidade::where('user_id',Auth::id())->where('ativo',true)->get();
       $turmas = Turma::where('user_id', Auth::id())->where('ativo', true)->get(); 
       return view('alunos.create',compact('unidades','turmas'));
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

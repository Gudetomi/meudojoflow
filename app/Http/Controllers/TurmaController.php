<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;;
use Illuminate\Validation\Rule;
class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $turmas = Turma::where('user_id',Auth::id())->where('ativo',true)->get();
        return view('turmas.index',compact('turmas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unidades = Unidade::where('user_id',Auth::id())->where('ativo',true)->get();
        return view('turmas.create',compact('unidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_turma' => ['required', 'string', 'max:255', 'unique:turmas,nome_turma'],
            'unidade_id' => ['required',
                Rule::exists('unidades', 'id')->where(function ($query) {
                        return $query->where('user_id', Auth::id());
                    }),
            ]   
        ],[
            'nome_turma.required' => 'O nome da turma é obrigatório.',
            'unidade_id.required' => 'Por favor, selecione uma unidade.',
            'unidade_id.exists'   => 'A unidade selecionada é inválida.',
        ]);
            Turma::create([
                'nome_turma' => $validatedData['nome_turma'],
                'unidade_id' => $validatedData['unidade_id'],
                'user_id'    => Auth::id(),
                'ativo'      => true,
            ]);
            return redirect()->route('turmas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turma $turma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turma $turma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turma $turma)
    {
        //
    }
}

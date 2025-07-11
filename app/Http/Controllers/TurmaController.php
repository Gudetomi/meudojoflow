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
            'nome_turma' => ['required', 'string', 'max:255',  
                Rule::unique('turmas')->where(function($query) use ($request){
                    return $query->where('unidade_id', $request->unidade_id);
                })
            ],
            'unidade_id' => ['required',
                Rule::exists('unidades', 'id')->where(function ($query) {
                        return $query->where('user_id', Auth::id());
                })
            ]   
        ],[
            'nome_turma.required' => 'O nome da turma é obrigatório.',
            'nome_turma.unique'   => 'Já existe uma turma com este nome nesta unidade.',
            'unidade_id.required' => 'Por favor, selecione uma unidade.',
            'unidade_id.exists'   => 'A unidade selecionada é inválida.',
        ]);
            Turma::create([
                'nome_turma' => $validatedData['nome_turma'],
                'unidade_id' => $validatedData['unidade_id'],
                'user_id'    => Auth::id()
            ]);
            return redirect()->route('turmas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turma $turma)
    {
        if(Auth::id() != $turma->user_id){
            abort(403, 'Acesso negado.');
        }
        $unidades = Unidade::where('user_id',Auth::id())->where('ativo',true)->get();
        return view('turmas.edit', compact('turma','unidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turma $turma)
    {
        if (Auth::id() !== $turma->user_id) {
            abort(403, 'Acesso não autorizado.');
        }
        $validatedData = $request->validate([
            'nome_turma' => ['required', 'string', 'max:255', 
                Rule::unique('turmas')->where(function($query) use ($request){
                    return $query->where('unidade_id', $request->unidade_id);
                })->ignore($turma->id)
            ],
            'unidade_id' => ['required',
                Rule::exists('unidades', 'id')->where(function ($query) {
                        return $query->where('user_id', Auth::id());
                    }),
            ]   
        ],[
            'nome_turma.required' => 'O nome da turma é obrigatório.',
            'nome_turma.unique'   => 'Já existe uma turma com este nome nesta unidade.',
            'unidade_id.required' => 'Por favor, selecione uma unidade.',
            'unidade_id.exists'   => 'A unidade selecionada é inválida.',
        ]);
        $turma->update($validatedData);
        return redirect()->route('turmas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turma $turma)
    {
        $turma->update(['ativo' => false]);
        return redirect()->route('turmas.index')->with('success', 'Turma desativada com sucesso.');
    }
    public function getByUnidade($unidadeId)
    {
        $turmas = Turma::where('unidade_id', $unidadeId)
            ->where('user_id', Auth::id())
            ->get();
        return response()->json($turmas);
    }

}

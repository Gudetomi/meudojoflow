<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unidades = Unidade::where('user_id',Auth::id())->where('ativo',true)->get();
        return view('unidades.index',compact('unidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $request->validate([
                'nome_unidade' => ['required', 'string', 'max:255',Rule::unique('unidades', 'nome_unidade')->where(function ($query) {
                    return $query->where('ativo', 1);
                })],
            ],[
                'nome_unidade.unique' => 'Já existe uma unidade com esse nome!'
            ]);
            Unidade::create([
                'nome_unidade' => $request->nome_unidade,
                'user_id' => Auth::id()
            ]);
        });
        return redirect()->route('unidades.index');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unidade $unidade)
    {
       return view('unidades.edit', compact('unidade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidade $unidade)
    {
        $validatedData = $request->validate([
            'nome_unidade' => 'required|string|max:255|unique:unidades,nome_unidade',
        ],[
            'nome_unidade.unique' => 'Já existe uma unidade com esse nome!'
        ]);
        $unidade->nome_unidade = $validatedData['nome_unidade'];
        $unidade->save();
        return redirect()->route('unidades.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidade $unidade)
    {
        $unidade->update(['ativo' => false]);
        return redirect()->route('unidades.index')->with('success', 'Unidade desativada com sucesso.');
        
    }
}

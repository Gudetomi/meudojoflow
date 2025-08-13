<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Graduacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GraduacaoController extends Controller
{
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'aluno_id' => 'required|uuid|exists:alunos,id',
            'faixa_id' => 'required|uuid|exists:faixas,id',
            'data_graduacao' => 'required|date',
            'observacoes' => 'nullable|string',
        ]);

        $aluno = Aluno::findOrFail($validated['aluno_id']);
        if ($aluno->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        $aluno->graduacoes()->create([
            'user_id' => Auth::id(),
            'faixa_id' => $validated['faixa_id'],
            'data_graduacao' => $validated['data_graduacao'],
            'observacoes' => $validated['observacoes'],
        ]);
        return back()->with('success', 'Graduação registada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Graduacao $graduacao)
    {
        dd($graduacao);
        if ($graduacao->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        $graduacao->delete();
        return back()->with('success', 'Graduação removida com sucesso!');
    }
}

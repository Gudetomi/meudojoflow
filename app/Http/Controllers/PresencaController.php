<?php

namespace App\Http\Controllers;
use App\Models\Turma;
use App\Models\Unidade;
use App\Models\Presenca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PresencaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Busca os dados para preencher os filtros de <select>
        $unidades = Unidade::where('user_id', Auth::id())->where('ativo', true)->get();
        $turmas = Turma::where('user_id', Auth::id())->where('ativo', true)->get();

        // 2. Inicia a query e aplica os filtros condicionalmente
        $presencas = Presenca::query()
            // Eager load os relacionamentos para otimizar a consulta
            ->with(['aluno', 'turma'])
            // Garante que estamos a ver apenas presenças de alunos do utilizador logado
            ->whereHas('aluno', function ($query) {
                $query->where('user_id', Auth::id());
            })
            // Filtra por data inicial (a partir de)
            ->when($request->query('data_inicial'), function ($query, $dataInicial) {
                $query->where('data_presenca', '>=', $dataInicial);
            })
            // Filtra por data final (até)
            ->when($request->query('data_final'), function ($query, $dataFinal) {
                $query->where('data_presenca', '<=', $dataFinal);
            })
            // Filtra por turma
            ->when($request->query('turma_id'), function ($query, $turmaId) {
                $query->where('turma_id', $turmaId);
            })
            // Filtra por unidade (através do relacionamento da turma)
            ->when($request->query('unidade_id'), function ($query, $unidadeId) {
                $query->whereHas('turma', function ($q) use ($unidadeId) {
                    $q->where('unidade_id', $unidadeId);
                });
            })
            ->latest('data_presenca') // Ordena pela data mais recente
            ->paginate(15); // Pagina os resultados

        // 3. Retorna a view com todos os dados necessários
        return view('presencas.index', [
            'presencas' => $presencas,
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
        $unidades = Unidade::where('user_id',Auth::id())->where('ativo',true)->get();
        return view('presencas.create',compact('unidades'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

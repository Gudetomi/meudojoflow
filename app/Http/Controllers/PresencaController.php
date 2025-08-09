<?php

namespace App\Http\Controllers;
use App\Models\Turma;
use App\Models\Unidade;
use App\Models\Presenca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PresencaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $unidades = Unidade::where('user_id', Auth::id())->where('ativo', true)->get();
        $turmas = Turma::where('user_id', Auth::id())->where('ativo', true)->get();

        $aulasQuery = DB::table('presencas')
            ->join('turmas', 'presencas.turma_id', '=', 'turmas.id')
            ->join('unidades', 'turmas.unidade_id', '=', 'unidades.id')
            ->join('alunos', 'presencas.aluno_id', '=', 'alunos.id')
            ->where('alunos.user_id', Auth::id())
            ->select('presencas.data_presenca', 'presencas.turma_id', 'turmas.nome_turma', 'unidades.nome_unidade')
            ->distinct();

        $aulasQuery->when($request->query('data_inicial'), function ($query, $dataInicial) {
            $query->where('presencas.data_presenca', '>=', $dataInicial);
        });
        $aulasQuery->when($request->query('data_final'), function ($query, $dataFinal) {
            $query->where('presencas.data_presenca', '<=', $dataFinal);
        });
        $aulasQuery->when($request->query('turma_id'), function ($query, $turmaId) {
            $query->where('presencas.turma_id', $turmaId);
        });
        $aulasQuery->when($request->query('unidade_id'), function ($query, $unidadeId) {
            $query->where('turmas.unidade_id', $unidadeId);
        });

        $paginatedAulas = $aulasQuery->latest('presencas.data_presenca')->paginate(15);

        $paginatedAulas->getCollection()->transform(function ($aula) {
            $aula->data_presenca_formatada = $this->formatarData($aula->data_presenca);
            return $aula;
        });

        return view('presencas.index', [
            'aulas' => $paginatedAulas,
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
        return view('presencas.create',compact('unidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $validation = $request->validate([
            'turma_id' => ['required', Rule::exists('turmas', 'id')->where(function ($query) {
                return $query->where('user_id', Auth::id());
            })],
            'data_presenca' => ['required', 'date'],
            'presencas' => ['array','nullable'],
            'presencas.*' => ['exists:alunos,id']
        ], [
            'turma_id.required' => 'Por favor, selecione uma turma.',
            'turma_id.exists' => 'A turma selecionada é inválida.',
            'data_presenca.required' => 'A data de presença é obrigatória.',
            'data_presenca.date' => 'A data de presença deve ser uma data válida.'
        ]);

        $turmaId = $validation['turma_id'];
        $dataPresenca = $validation['data_presenca'];
        $alunosPresentesIds = $validation['presencas'] ?? [];

        DB::transaction(function () use($turmaId, $dataPresenca, $alunosPresentesIds) {
            $turmaAlunos = Turma::findOrFail($turmaId)->alunos()->get();
            foreach ($turmaAlunos as $aluno) {
                $isPresente = in_array($aluno->id, $alunosPresentesIds);
                Presenca::create([
                    'turma_id' => $turmaId,
                    'aluno_id' => $aluno->id,
                    'data_presenca' => $dataPresenca,
                    'presente' => $isPresente,
                    'user_id' => Auth::id()
                ]);
            }
        });
         return redirect()->route('presenca.index')->with('success', 'Aula salva com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Turma $turma,$data)
    {
        if($turma->user != Auth::user()) {
                abort(403, 'Acesso não autorizado.');
            }
            $presencas = Presenca::where('turma_id', $turma->id)
                ->where('data_presenca', $data)
                ->with(['aluno', 'turma'])
                ->get();
            dd($presencas);
            return view('presencas._aula_detalhes', ['presencas' => $presencas]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turma $turma,$data)
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

<?php

namespace App\Http\Controllers;
use App\Models\Turma;
use App\Models\Unidade;
use App\Models\Presenca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresencaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $unidades = Unidade::where('user_id', Auth::id())->where('ativo', true)->get();
        $turmas = Turma::where('user_id', Auth::id())->where('ativo', true)->get();
        $dataInicial = $request->query('data_inicial', Carbon::today()->toDateString());
        $dataFinal = $request->query('data_final', Carbon::today()->toDateString());
        $aulasQuery = DB::table('presencas')
            ->join('turmas', 'presencas.turma_id', '=', 'turmas.id')
            ->join('unidades', 'turmas.unidade_id', '=', 'unidades.id')
            ->join('alunos', 'presencas.aluno_id', '=', 'alunos.id')
            ->where('alunos.user_id', Auth::id())
            ->select('presencas.data_presenca', 'presencas.turma_id', 'turmas.nome_turma', 'unidades.nome_unidade')
            ->distinct();

        $aulasQuery->whereBetween('presencas.data_presenca', [$dataInicial, $dataFinal]);
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
        $jaExiste = Presenca::where('turma_id', $turmaId)
                            ->where('data_presenca', $dataPresenca)
                            ->exists();

        if ($jaExiste) {
            return back()
                ->withErrors(['geral' => 'A frequência para esta turma na data selecionada já foi lançada. Você pode editá-la na página de histórico.'])
                ->withInput();
        }
        
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
            $presencas = Presenca::with('aluno')
                               ->join('alunos', 'presencas.aluno_id', '=', 'alunos.id')
                               ->where('presencas.turma_id', $turma->id)
                               ->where('presencas.data_presenca', $data)
                               ->orderBy('alunos.nome_aluno', 'asc')
                               ->select('presencas.*')
                               ->get();
            return view('presencas.visualizar', ['presencas' => $presencas]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turma $turma,$data)
    {
        if(Auth::id() != $turma->user_id){
            abort(403, 'Acesso negado.');
        }
        $unidades = Unidade::where('user_id',Auth::id())->where('ativo',true)->get();
        $turmas = Turma::where('id',$turma->id)->where('ativo', true)->get();
        $alunos = $turma->alunos()->orderBy('nome_aluno', 'asc')->get();
        $presencas = Presenca::where('turma_id', $turma->id)
            ->where('data_presenca', $data)
            ->get();

        return view('presencas.edit', compact('turma', 'unidades', 'turmas', 'presencas', 'data', 'alunos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turma $turma, $data)
    {
        if ($turma->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $validated = $request->validate([
            'data_presenca' => 'required|date',
            'presencas' => 'nullable|array',
            'presencas.*' => 'uuid|exists:alunos,id'
        ]);

        $dataPresenca = $validated['data_presenca'];
        $alunosPresentesIds = $validated['presencas'] ?? [];
        DB::transaction(function () use ($turma, $dataPresenca, $alunosPresentesIds) {
            $todosAlunosDaTurma = $turma->alunos;
            foreach ($todosAlunosDaTurma as $aluno) {
                $estaPresente = in_array($aluno->id, $alunosPresentesIds);
                Presenca::updateOrCreate(
                    [
                        'aluno_id' => $aluno->id,
                        'turma_id' => $turma->id,
                        'data_presenca' => $dataPresenca,
                    ],
                    [ 
                        'presente' => $estaPresente,
                        'user_id' => Auth::id(),
                    ]
                );
            }
        });

        return redirect()->route('presenca.index')->with('success', 'Lista de presença atualizada com sucesso!');
    }
}

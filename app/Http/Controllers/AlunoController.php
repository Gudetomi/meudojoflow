<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Unidade;
use App\Models\Responsavel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
    $validated = $request->validate([
        'nome_aluno' => 'required|string|max:255',
        'cpf' => 'required|string|max:14|unique:alunos,cpf',
        'data_nascimento' => 'required|date',
        'idade' => 'required|integer',
        'sexo' => 'required|in:1,2',
        'telefone' => 'required|string',
        'email' => 'nullable|email',
        'cep' => 'required|string',
        'endereco' => 'required|string',
        'numero' => 'nullable|string',
        'bairro' => 'required|string',
        'cidade' => 'required|string',
        'estado' => 'required|string',
        'possui_responsavel' => 'required|boolean',
        'unidade_id' => 'required|uuid|exists:unidades,id',
        'turma_id' => 'required|uuid|exists:turmas,id',

        // Se tiver responsável
        'nome_responsavel' => 'required_if:possui_responsavel,1|string|nullable',
        'cpf_responsavel' => 'required_if:possui_responsavel,1|string|nullable',
        'telefone_responsavel' => 'required_if:possui_responsavel,1|string|nullable',
        'email_responsavel' => 'nullable|email',
    ]);

    DB::transaction(function () use ($request) {
        $aluno = Aluno::create([
            'nome_aluno' => $request->nome_aluno,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'idade' => $request->idade,
            'sexo' => $request->sexo,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'cep' => $request->cep,
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'possui_responsavel' => $request->possui_responsavel,
            'unidade_id' => $request->unidade_id,
            'turma_id' => $request->turma_id,
            'user_id' => auth()->id(),
        ]);

        if ($request->possui_responsavel) {
            $aluno->responsavel()->create([
                'nome' => $request->nome_responsavel,
                'cpf' => $request->cpf_responsavel,
                'telefone' => $request->telefone_responsavel,
                'email' => $request->email_responsavel,
            ]);
        }
    });

    return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso!');
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
    public function edit($id)
    {
        $aluno = Aluno::with('responsavel')->findOrFail($id);
        dd($aluno['responsavel']);
        $unidades = Unidade::all();
        $turmas = Turma::where('unidade_id', $aluno->unidade_id)->get();

        return view('alunos.edit', compact('aluno', 'unidades', 'turmas'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    $request->validate([
        'nome_aluno' => 'required|string|max:255',
        'data_nascimento' => 'required|date',
        'cpf' => 'required|string|max:14',
        'telefone' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'idade' => 'nullable|integer',
        'sexo' => 'required|in:1,2',
        'unidade_id' => 'required|uuid',
        'turma_id' => 'required|uuid',
        'possui_responsavel' => 'required|boolean',
        'cep' => 'required|string',
        'endereco' => 'required|string',
        'numero' => 'nullable|string',
        'bairro' => 'required|string',
        'cidade' => 'required|string',
        'estado' => 'required|string',
    ]);

    DB::transaction(function () use ($request, $id) {
        $aluno = Aluno::findOrFail($id);

        // Atualiza aluno
        $aluno->update([
            'nome_aluno' => $request->nome_aluno,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'idade' => $request->idade,
            'sexo' => $request->sexo,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'cep' => $request->cep,
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'possui_responsavel' => $request->possui_responsavel,
            'unidade_id' => $request->unidade_id,
            'turma_id' => $request->turma_id,
        ]);

        // Se menor de idade, obriga dados do responsável
        if ((int)$request->idade < 18 || $request->possui_responsavel) {
            $request->validate([
                'nome_responsavel' => 'required|string|max:255',
                'cpf_responsavel' => 'required|string|max:14',
                'telefone_responsavel' => 'required|string|max:20',
                'email_responsavel' => 'nullable|email|max:255',
            ]);

            $responsavel = $aluno->responsavel ?? new Responsavel();
            $responsavel->nome = $request->nome_responsavel;
            $responsavel->cpf = $request->cpf_responsavel;
            $responsavel->telefone = $request->telefone_responsavel;
            $responsavel->email = $request->email_responsavel;
            $responsavel->aluno_id = $aluno->id;
            $responsavel->save();
        } else {
            // Se for maior e já tiver responsável, podemos deletar (opcional)
            if ($aluno->responsavel) {
                $aluno->responsavel->delete();
            }
        }
    });

    return redirect()->route('alunos.index')->with('success', 'Aluno atualizado com sucesso.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aluno $aluno)
    {
        $aluno->update(['ativo' => false]);
        return redirect()->route('alunos.index')->with('success', 'Aluno desativada com sucesso.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Unidade;
use App\Models\Responsavel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        dd($request->all());
        $validatedData = $request->validate([
            'nome_aluno' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string'],
            'data_nascimento' => ['required', 'date'],
            'idade' => ['nullable', 'integer'],
            'sexo' => ['required', Rule::in(['M', 'F'])],
            'telefone' => ['required'],
            'email' => ['nullable', 'email'],
            'cep' => ['required'],
            'endereco' => ['required'],
            'numero' => ['nullable'],
            'bairro' => ['required'],
            'cidade' => ['required'],
            'estado' => ['required'],
            'possui_responsavel' => ['required', 'boolean'],
            'unidade_id' => [
                'required',
                Rule::exists('unidades', 'id')->where(fn($q) => $q->where('user_id', Auth::id())),
            ],
            'turma_id' => [
                'required',
                Rule::exists('turmas', 'id')->where(fn($q) => $q->where('user_id', Auth::id())),
            ],

            // Dados do responsável
            'nome_responsavel' => ['required_if:possui_responsavel,1'],
            'cpf_responsavel' => ['required_if:possui_responsavel,1'],
            'telefone_responsavel' => ['required_if:possui_responsavel,1'],
            'email_responsavel' => ['nullable', 'email'],
        ]);

        // Limpa máscaras
        $validatedData['cpf'] = preg_replace('/\D/', '', $validatedData['cpf']);
        $validatedData['telefone'] = preg_replace('/\D/', '', $validatedData['telefone']);
        $validatedData['cep'] = preg_replace('/\D/', '', $validatedData['cep']);

        $validatedData['user_id'] = Auth::id();

        // Cria o aluno
        $aluno = Aluno::create($validatedData);

        // Se tiver responsável, cria e relaciona
        if ($request->possui_responsavel) {
            Responsavel::create([
                'aluno_id' => $aluno->id,
                'nome' => $request->nome_responsavel,
                'cpf' => preg_replace('/\D/', '', $request->cpf_responsavel),
                'telefone' => preg_replace('/\D/', '', $request->telefone_responsavel),
                'email' => $request->email_responsavel,
                'user_id' => Auth::id(),
            ]);
        }

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

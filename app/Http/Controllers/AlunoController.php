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
use Illuminate\Support\Arr;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
   { 
        $alunos = Aluno::where('user_id', Auth::id())
            ->where('ativo', true)
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
        //passar isso para outra função e reaproveitar
        $request->merge([
            'cpf' => $this->removeMascara($request->input('cpf')),
            'telefone' => $this->removeMascara($request->input('telefone')),
            'cep' => $this->removeMascara($request->input('cep')),
            'cpf_responsavel' => $this->removeMascara($request->input('cpf_responsavel')),
            'telefone_responsavel' => $this->removeMascara($request->input('telefone_responsavel')),
        ]);

        // 2. VALIDAÇÃO: Alinhada com a sua migration.
        $validatedData = $request->validate([
            'nome_aluno'        => 'required|string|max:255',
            'cpf'               => 'required|string|max:11|unique:alunos,cpf',
            'data_nascimento'   => 'required|date',
            'idade'             => 'required|integer',
            'sexo'              => 'required|integer',
            'telefone'          => 'required|string|max:11',
            'email'             => 'nullable|email|unique:alunos,email',
            'cep'               => 'required|string|max:8',
            'endereco'          => 'required|string',
            'numero'            => 'required|string',
            'bairro'            => 'required|string',
            'cidade'            => 'required|string',
            'estado'            => 'required|string',
            'possui_responsavel'=> 'required|boolean',
            'unidade_id'        => ['required', 'uuid', Rule::exists('unidades', 'id')->where('user_id', Auth::id())],
            'turma_id'          => ['required', 'uuid', Rule::exists('turmas', 'id')->where('user_id', Auth::id())],

            // Validação do responsável
            'nome_responsavel'      => 'required_if:possui_responsavel,true|nullable|string|max:255',
            'cpf_responsavel'       => 'required_if:possui_responsavel,true|nullable|string|max:11',
            'telefone_responsavel'  => 'required_if:possui_responsavel,true|nullable|string|max:11',
            'email_responsavel'     => 'nullable|email|max:255',
        ]);

        // 3. TRANSAÇÃO: Garante a integridade dos dados.
        $aluno = DB::transaction(function () use ($validatedData) {

            // CORREÇÃO: Filtra os dados que pertencem apenas à tabela 'alunos'.
            $alunoData = Arr::except($validatedData, [
                'nome_responsavel', 'cpf_responsavel', 'telefone_responsavel', 'email_responsavel'
            ]);
            // Adiciona o user_id e o estado 'ativo'
            $alunoData['user_id'] = Auth::id();
            $alunoData['ativo'] = true;

            // Cria o aluno com os dados corretos.
            $aluno = Aluno::create($alunoData);

            // Se tiver responsável, cria o registo do responsável.
            if ($validatedData['possui_responsavel']) {
                $aluno->responsavel()->create([
                    'nome_responsavel'      => $validatedData['nome_responsavel'],
                    'cpf_responsavel'       => $validatedData['cpf_responsavel'],
                    'telefone_responsavel'  => $validatedData['telefone_responsavel'],
                    'email_responsavel'     => $validatedData['email_responsavel'],
                ]);
            }

            return $aluno;
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
        $unidades = Unidade::all();
        $turmas = Turma::where('unidade_id', $aluno->unidade_id)->get();

        return view('alunos.edit', compact('aluno', 'unidades', 'turmas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aluno $aluno)
    {
        // Verificação de segurança: garante que o utilizador só pode editar os seus próprios alunos.
        if (Auth::id() !== $aluno->user_id) {
            abort(403, 'Acesso não autorizado.');
        }
        $request->merge([
            'cpf' => $this->removeMascara($request->input('cpf')),
            'telefone' => $this->removeMascara($request->input('telefone')),
            'cep' => $this->removeMascara($request->input('cep')),
            'cpf_responsavel' => $this->removeMascara($request->input('cpf_responsavel')),
            'telefone_responsavel' => $this->removeMascara($request->input('telefone_responsavel')),
        ]);
        // 1. Validação ÚNICA e COMPLETA, agora alinhada com a sua migration.
        $validatedData = $request->validate([
            'nome_aluno'        => 'required|string|max:255',
            'cpf'               => ['required', 'string', 'max:11', Rule::unique('alunos')->ignore($aluno->id)],
            'data_nascimento'   => 'required|date',
            'idade'             => 'required|integer', // Adicionado
            'sexo'              => 'required|integer', // Adicionado
            'telefone'          => 'required|string|max:11',
            'email'             => 'nullable|email',
            'cep'               => 'required|string|max:8',
            'endereco'          => 'required|string',
            'numero'            => 'required|string', // Ajustado para 'required'
            'bairro'            => 'required|string',
            'cidade'            => 'required|string',
            'estado'            => 'required|string',
            'possui_responsavel'=> 'required|boolean',
            'unidade_id'        => ['required', 'uuid', Rule::exists('unidades', 'id')->where('user_id', Auth::id())],
            'turma_id'          => ['required', 'uuid', Rule::exists('turmas', 'id')->where('user_id', Auth::id())],

            // Validação do responsável
            'nome_responsavel'      => 'required_if:possui_responsavel,true|nullable|string|max:255',
            'cpf_responsavel'       => 'required_if:possui_responsavel,true|nullable|string|max:14',
            'telefone_responsavel'  => 'required_if:possui_responsavel,true|nullable|string|max:15',
            'email_responsavel'     => 'nullable|email|max:255',
        ]);

        // 2. Inicia uma transação para garantir a integridade dos dados
        DB::transaction(function () use ($validatedData, $aluno) {

            // 3. Filtra os dados que pertencem apenas à tabela 'alunos'.
            $alunoData = Arr::except($validatedData, [
                'nome_responsavel', 'cpf_responsavel', 'telefone_responsavel', 'email_responsavel'
            ]);
            $aluno->update($alunoData);

            // 4. Lógica para criar ou atualizar o responsável.
            // Pré-requisito: O modelo Aluno deve ter o método 'public function responsavel() { return $this->hasOne(Responsavel::class); }'
            if ($validatedData['possui_responsavel']) {
                $aluno->responsavel()->updateOrCreate(
                    ['aluno_id' => $aluno->id],
                    [
                        'nome_responsavel'      => $validatedData['nome_responsavel'],
                        'cpf_responsavel'       => $validatedData['cpf_responsavel'],
                        'telefone_responsavel'  => $validatedData['telefone_responsavel'],
                        'email_responsavel'     => $validatedData['email_responsavel'],
                    ]
                );
            } else {
                // Se não possui mais responsável, apaga o registo existente (se houver).
                $aluno->responsavel()->delete();
            }
        });

        return redirect()->route('alunos.index')->with('success', 'Aluno atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aluno $aluno)
    {
        $aluno->update(['ativo' => false]);
        return redirect()->route('alunos.index')->with('success', 'Aluno desativado com sucesso.');
    }
}

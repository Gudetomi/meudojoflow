<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
   use HasFactory, HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'alunos';
    protected $fillable = [
        'nome_aluno',
        'user_id',
        'unidade_id',
        'data_nascimento',
        'cpf',
        'email',
        'idade',
        'sexo',
        'telefone',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'cep',
        'estado',
        'possui_responsavel',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}

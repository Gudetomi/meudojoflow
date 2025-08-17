<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
   use HasFactory, HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'responsaveis';
    protected $fillable = [
        'user_id',
        'aluno_id',
        'nome_responsavel',
        'cpf_responsavel',
        'email_responsavel',
        'telefone_responsavel'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}

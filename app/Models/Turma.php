<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory, HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'turmas';
    protected $fillable = [
        'nome_turma',
        'user_id',
        'unidade_id',
        'ativo',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
        public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }
}

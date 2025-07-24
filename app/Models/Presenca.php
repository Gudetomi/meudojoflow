<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presenca extends Model
{
    use HasFactory;
    protected $fillable = [
        'aluno_id',
        'turma_id',
        'data_presenca',
        'presente',
    ];

    /**
     * Obtém o aluno associado a este registo de presença.
     */
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    /**
     * Obtém a turma associada a este registo de presença.
     */
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}

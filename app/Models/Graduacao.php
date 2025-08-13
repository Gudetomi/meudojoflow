<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Graduacao extends Model
{
   use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'graduacoes';
     protected $fillable = [
        'aluno_id',
        'user_id',
        'faixa_id',
        'data_graduacao',
        'observacoes',
    ];
     protected $casts = [
        'data_graduacao' => 'date',
    ];

    /**
     * Obtém o aluno associado a este registo de graduação.
     */
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    /**
     * Obtém a faixa associada a este registo de graduação.
     */
    public function faixa()
    {
        return $this->belongsTo(Faixa::class);
    }

    /**
     * Obtém o utilizador que registou a graduação.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

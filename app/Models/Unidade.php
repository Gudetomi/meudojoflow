<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unidade extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'unidades';
    protected $fillable = [
        'nome_unidade',
        'user_id',
        'ativo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }
}

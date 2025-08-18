<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{
   use HasFactory, HasUuids;

   protected $keyType = 'string';
   public $incrementing = false;

   protected $fillable = [
       'nome',
       'descricao',
   ];

   public function faixas()
   {
       return $this->hasMany(Faixa::class)->orderBy('ordem');
   }
   public function turmas()
    {
        return $this->hasMany(Turma::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faixa extends Model
{
   use HasFactory,HasUuids;
   protected $keyType = 'string';
   public $incrementing = false;
   protected $fillable = [
       'user_id',
       'modalidade_id',
       'nome',
       'ordem',
       'cor_principal',
       'cor_secundaria',
   ];

   public function modalidade()
   {
       return $this->belongsTo(Modalidade::class);
   }
}

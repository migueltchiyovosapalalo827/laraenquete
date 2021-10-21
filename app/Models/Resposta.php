<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    use HasFactory;

       /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nome','qtdvotos','pergunta_id'
    ];

    
      public function pergunta()
      {
          # code...
          return $this->belongsTo(Pergunta::class);
      }
}

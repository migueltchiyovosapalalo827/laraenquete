<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nome',	'user_id'
    ];



    // esta função serve para criar relecionamento inverso de um para muito entre o usuario e as pergunta
    public function usuario()
    {
        # code...
        return $this->belongsTo(User::class);
    }


    // esta função serve para criar relecionamento de um para muito entre  a pergunta e as resposta
    public function respostas()
    {
        # code...
        return $this->hasMany(Resposta::class);
    }
}

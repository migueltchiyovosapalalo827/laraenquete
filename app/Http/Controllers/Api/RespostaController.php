<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resposta;
use Illuminate\Http\Request;

class RespostaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $respostas = Resposta::all();
        return response()->json(compact('respostas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $resposta = Resposta::find($request->id_resposta);
        $resposta->qtdvotos = $resposta->qtdvotos++;
        $qtdvotos  = $resposta->qtdvotos++;
        $total = Resposta::where('pergunta_id',$request->id_pergunta)->sum('qtdvotos');
        $percetagem = ( $qtdvotos * 100)/$total;
        $resposta->percetagem = $percetagem;
        $resposta->save();
        return response()->json(['percetagem'=>round($percetagem)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

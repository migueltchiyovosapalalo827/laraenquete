<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;
use App\Models\Resposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class PerguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Inertia::render('enquete/index',['perguntas'=>Pergunta::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return Inertia::render('enquete/create');
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
        DB::beginTransaction();
        try {
            //code...
            $pergunta = Pergunta::create(['nome'=>$request->pergunta,'user_id'=>Auth::user()->id]);
           foreach ($request->resposta as $resposta) {
                 # code...
                 if(!is_null($resposta)){
                 $respostas = new Resposta(['nome'=>$resposta]);
                 $pergunta->respostas()->save($respostas);}
             }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('message',$th->getMessage());
        }
        DB::commit();
        return redirect()->route('pergunta.index')->with('message',"enquente criado com sucesso");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pergunta  $pergunta
     * @return \Illuminate\Http\Response
     */
    public function show(Pergunta $perguntum)
    {
        //
        return Inertia::render('enquete/show',['pergunta'=>$perguntum,
                                'respostas'=>$perguntum->respostas]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pergunta  $pergunta
     * @return \Illuminate\Http\Response
     */
    public function edit(Pergunta $perguntum)
    {
        //
        return Inertia::render('enquete/update',['pergunt'=>$perguntum,
                                'resposts'=>$perguntum->respostas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pergunta  $pergunta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pergunta $perguntum)
    {
        //

        DB::beginTransaction();
        try {
            //code...
             $perguntum->update(['nome'=>$request->pergunta,'user_id'=>Auth::user()->id]);
             for ($i=0; $i < count($request->resposta) ; $i++) {
                 # code...
                 if(!is_null($request->resposta[$i])){
                     if ($i < count($perguntum->respostas)) {
                         # code...
                         $perguntum->respostas[$i]->nome = $request->resposta[$i];
                    $perguntum->respostas[$i]->save();
                     } else{
                        $respostas = new Resposta(['nome'=> $request->resposta[$i]]);
                        $perguntum->respostas()->save($respostas);
                     }
                    }

             }

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('message',$th->getMessage());
        }
        DB::commit();
        return redirect()->route('pergunta.index')->with('message',"enquente actualizada com sucesso");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pergunta  $pergunta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pergunta $perguntum)
    {
        //

        if (!$found = $perguntum->delete()) {
            return redirect()->back()->with('message',"não foi possivel eliminar esta inquete");

        }

        return redirect()->route('pergunta.index')->with('message',"enquente eliminado com sucesso");
    }

    public function home()
    {
        # code...
        return Inertia::render('Home',['perguntas'=>Pergunta::with('respostas')->get(),
                                        'canLogin' => Route::has('login'),
                                        'canRegister' => Route::has('register'),
                    ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rama;

class RamaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
            
            $buscar = $request->buscar;
            $criterio = $request->criterio;

            if($buscar == '') {
                $ramas = Rama::orderBy('id', 'DESC')->paginate(10);
            } else {
                $ramas = Rama::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'DESC')->paginate(10);
            }        
        
        return [
            'pagination' => [
                'total' => $ramas->total(),
                'current_page' => $ramas->currentPage(),
                'per_page' => $ramas->perPage(),
                'last_page' => $ramas->lastPage(),
                'from' => $ramas->firstItem(),
                'to' => $ramas->lastItem(),
            ],

            'ramas' => $ramas
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rama = new Rama();
        $rama->titulo = $request->titulo;
        $rama->descripcion = $request->descripcion;            
        $rama->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        $rama = Rama::findOrFail($request->id);        
        $rama->titulo = $request->titulo;        
        $rama->descripcion = $request->descripcion;        
        $rama->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {        
        if(!$request->ajax()) return redirect('/');              

        $rama = Rama::findOrFail($id);   
        $rama->delete();
    }

    /**
     * Return the rama
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectRama(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $ramas = Rama::all();
        return ['ramas' => $ramas ];
    }
}


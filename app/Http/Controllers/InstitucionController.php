<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institucion;

class InstitucionController extends Controller
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
                $instituciones = Institucion::orderBy('id', 'DESC')->paginate(10);
            } else {
                $instituciones = Institucion::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'DESC')->paginate(10);
            }        
        
        return [
            'pagination' => [
                'total' => $instituciones->total(),
                'current_page' => $instituciones->currentPage(),
                'per_page' => $instituciones->perPage(),
                'last_page' => $instituciones->lastPage(),
                'from' => $instituciones->firstItem(),
                'to' => $instituciones->lastItem(),
            ],

            'instituciones' => $instituciones
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
        //if(!$request->ajax()) return redirect('/');
        $institucion = new Institucion();
        $institucion->nombre = $request->nombre;
        $institucion->telefono = $request->telefono;
        $institucion->direccion = "casa"; //$request->telefono;
        $institucion->tipo_id = $request->tipo_id;
        $institucion->rama_id = $request->rama_id;
        $institucion->estado_id = $request->estado_id;        
        $institucion->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {        
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
        if(!$request->ajax()) return redirect('/');

        $institucion = Institucion::findOrFail($request->id);
        $institucion->nombre = $request->nombre;
        $institucion->telefono = $request->telefono;
        $institucion->direccion = $request->direccion;
        $institucion->tipo_id = $request->tipo_id;
        $institucion->rama_id = $request->rama_id;
        $institucion->estado_id = $request->estado_id;        
        $institucion->save();

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

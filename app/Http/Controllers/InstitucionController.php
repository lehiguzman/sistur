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
       $instituciones = Institucion::all();
       return $instituciones;
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ausencia;

class AusenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ausencias = Ausencia::all();
        return $ausencias;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ausencia = new Ausencia();
        $ausencia->fecfal = $request->fecfal;
        $ausencia->tipo = $request->tipo;
        $ausencia->observacion = $request->observacion;
		$ausencia->empleado_id = $request->empleado_id;
        $ausencia->save();
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

        $ausencia = Ausencia::findOrFail($request->id);        
        $ausencia->fecfal = $request->fecfal;
        $ausencia->tipo = $request->tipo;
        $ausencia->observacion = $request->observacion;
		$ausencia->empleado_id = $request->empleado_id;       
        $ausencia->save();
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

        $ausencia = Ausencia::findOrFail($id);   
        $ausencia->delete();
    }
}



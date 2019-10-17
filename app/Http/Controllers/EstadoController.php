<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados = Estado::all();
        return $estados;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $estado = new Estado();
        $estado->nombre = $request->nombre;            
        $estado->save();
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

        $estado = Estado::findOrFail($request->id);        
        $estado->nombre = $request->nombre;        
        $estado->save();
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

        $estado = Estado::findOrFail($id);   
        $estado->delete();
    }

    /**
     * Return the estado
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectEstado(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $estados = Estado::all();
        return ['estados' => $estados ];
    }
}

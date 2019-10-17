<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargos = Cargo::all();
        return $cargos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cargo = new Cargo();
        $cargo->titulo = $request->titulo;
        $cargo->descripcion = $request->descripcion;            
        $cargo->save();
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

        $cargo = Cargo::findOrFail($request->id);        
        $cargo->titulo = $request->titulo;        
        $cargo->descripcion = $request->descripcion;        
        $cargo->save();
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

        $cargo = Cargo::findOrFail($id);   
        $cargo->delete();
    }

    /**
     * Return the cargo
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectCargo(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $cargos = Cargo::all();
        return ['cargos' => $cargos ];
    }
}


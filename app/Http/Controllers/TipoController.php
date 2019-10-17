<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipo;

class TipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = Tipo::all();
        return $tipos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipo = new Tipo();
        $tipo->nombre = $request->nombre;            
        $tipo->save();
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

        $tipo = Tipo::findOrFail($request->id);        
        $tipo->nombre = $request->nombre;        
        $tipo->save();
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

        $tipo = Tipo::findOrFail($id);   
        $tipo->delete();
    }

    /**
     * Return the tipo
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectTipo(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tipos = Tipo::all();
        return ['tipos' => $tipos];
    }
}

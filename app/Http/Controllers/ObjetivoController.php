<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Objetivo;
use App\Etapa;
use App\Empleado;

class ObjetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objetivos = Objetivo::all();
        return $objetivos;
    }

    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $objetivo = Objetivo::find($id)->get();
         
        return ['objetivo' => $objetivo];
    }

    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $detalles = Etapa::where('objetivo_id', '=', $id)->get();
         
        return ['detalles' => $detalles];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();           
 
            $objetivo = new Objetivo();            
            $objetivo->titulo = $request->titulo;
            $objetivo->descripcion = $request->descripcion;                    
            $objetivo->save();
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos
 
            foreach($detalles as $ep=>$det)
            {
                $etapa = new Etapa();
                $etapa->objetivo_id = $objetivo->id;
                $etapa->titulo = $det['titulo'];
                $etapa->descripcion = $det['descripcion'];
                $etapa->fecini = $det['fecini'];
                $etapa->fecfin = $det['fecfin'];
                $etapa->estatus = $det['estatus'];
                $etapa->save();
            }             
 
            DB::commit();            

        } catch (Exception $e){
            DB::rollBack();
        }
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

        $objetivo = Objetivo::findOrFail($id);   
        $objetivo->delete();
    }

    /**
     * Return the objetivo
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectObjetivo(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $objetivos = Objetivo::all();
        return ['objetivos' => $objetivos ];
    }

    /**
     * Return the objetivo
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectObjetivoEmpleado(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $empleados = Empleado::all();
        return ['empleados' => $empleados ];
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function registrarObjetivoEmpleado(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        $objetivo = Objetivo::find($request->id);

        $empleados = $request->data;//Array de detalles
            //Recorro todos los elementos
 
            foreach($empleados as $ep=>$det)
            {                
                $objetivo->empleados()->attach($det);
            }           
    }

}


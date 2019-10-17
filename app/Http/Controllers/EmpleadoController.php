<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $empleados = Empleado::all();
       return $empleados;
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
        $empleado = new Empleado();
        $empleado->cedula = $request->cedula;
        $empleado->nombre = $request->nombre;
        $empleado->email = $request->email;
        $empleado->telefono = $request->telefono;
        $empleado->movil = $request->movil;        
        $empleado->direccion = $request->direccion;
        $empleado->salario = $request->salario;
        $empleado->fecing = $request->fecing;
        $empleado->fecegr = $request->fecegr;
        $empleado->cargo_id = $request->cargo_id; 
        $empleado->institucion_id = 5;         
        $empleado->save();
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
        $empleado = Empleado::findOrFail($request->id);        
        $empleado->cedula = $request->cedula;
        $empleado->nombre = $request->nombre;
        $empleado->email = $request->email;
        $empleado->telefono = $request->telefono;
        $empleado->movil = $request->movil;        
        $empleado->direccion = $request->direccion;
        $empleado->salario = $request->salario;
        $empleado->fecing = $request->fecing;
        $empleado->fecegr = $request->fecegr;
        $empleado->cargo_id = $request->cargo_id; 
        $empleado->institucion_id = 5;             
        $empleado->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if(!$request->ajax()) return redirect('/');              

        $empleado = Empleado::findOrFail($id);   
        $empleado->delete();
    }

    /**
     * Return the empleado
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectEmpleado(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $empleados = Empleado::all();
        return ['empleados' => $empleados ];
    }
}

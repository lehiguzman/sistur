<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Curso;
use App\Contenido;
use App\Empleado;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $buscar = $request->buscar;
            $criterio = $request->criterio;

            if($buscar == '') {
                $cursos = Curso::orderBy('id', 'DESC')->paginate(10);
            } else {
                $cursos = Curso::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'DESC')->paginate(10);
            }        
        
        return [
            'pagination' => [
                'total' => $cursos->total(),
                'current_page' => $cursos->currentPage(),
                'per_page' => $cursos->perPage(),
                'last_page' => $cursos->lastPage(),
                'from' => $cursos->firstItem(),
                'to' => $cursos->lastItem(),
            ],

            'cursos' => $cursos
        ];
    }

    public function listarPdf(Request $request) {

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == '') {
            $cursos = Curso::orderBy('id', 'DESC')->paginate(10);
        } else {
            $cursos = Curso::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'DESC')->paginate(10);
        }

        $pdf = \PDF::loadView('pdf.cursos', ['cursos' => $cursos]);
        return $pdf->download('cursos.pdf');
    }

    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $curso = Curso::find($id)->get();
         
        return ['curso' => $curso];
    }

    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $detalles = Contenido::where('curso_id', '=', $id)->get();
         
        return ['detalles' => $detalles];
    }

    public function store(Request $request)
    {
       //if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();           
 
            $curso = new Curso();            
            $curso->nombre = $request->nombre;
            $curso->fecini = $request->fecini;
            $curso->duracion = $request->duracion;
            $curso->cupos = $request->cupos;
            $curso->descripcion = $request->descripcion;           
            $curso->save();
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos
 
            foreach($detalles as $ep=>$det)
            {
                $contenido = new Contenido();
                $contenido->curso_id = $curso->id;
                $contenido->contenido = $det['contenido'];
                $contenido->descripcion = $det['descripcion'];                      
                $contenido->save();
            }             
 
            DB::commit();            

        } catch (Exception $e){
            DB::rollBack();
        }
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

        $curso = Curso::findOrFail($request->id);        
        $curso->nombre = $request->nombre;
        $curso->fecini = $request->fecini;
        $curso->duracion = $request->duracion;
        $curso->descripcion = $request->descripcion;            
        $curso->cupos = $request->cupos;            
        $curso->save();
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

        $curso = Curso::findOrFail($id);   
        $curso->delete();
    }

    /**
     * Return the curso
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectCurso(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $cursos = Curso::all();
        return ['cursos' => $cursos ];
    }

    /**
     * Return the cargo
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectCursoEmpleado(Request $request, $curso_id)
    {
        $empleadosAll = Empleado::all();                
        $curso = Curso::find($curso_id);        
        
        $empleados_curso = $curso->empleados;
        $arrayEmpleados = [];

        foreach ($curso->empleados as $emp) {
            $arrayEmpleados[] = $emp->id;
        }

        $empleados = DB::table('empleados')
                    ->whereNotIn('id', $arrayEmpleados)
                    ->get();
        
        return [ 'empleados' => $empleados ];
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function registrarCursoEmpleado(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        $curso = Curso::find($request->id);

        $empleados = $request->data;//Array de detalles
            //Recorro todos los elementos
 
            foreach($empleados as $ep=>$det)
            {                
                $curso->empleados()->attach($det);
            }           
    }
}



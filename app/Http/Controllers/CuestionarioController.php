<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cuestionario;
use App\Pregunta;
use App\Respuesta;
use Auth;

class CuestionarioController extends Controller
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
                $cuestionarios = Cuestionario::orderBy('id', 'DESC')->paginate(10);                
            } else {
                $cuestionarios = Cuestionario::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'DESC')->paginate(10);
            }        
        
        return [
            'pagination' => [
                'total' => $cuestionarios->total(),
                'current_page' => $cuestionarios->currentPage(),
                'per_page' => $cuestionarios->perPage(),
                'last_page' => $cuestionarios->lastPage(),
                'from' => $cuestionarios->firstItem(),
                'to' => $cuestionarios->lastItem(),
            ],

            'cuestionarios' => $cuestionarios
        ];
    }

    public function listarEncuesta(Request $request) {    

        $user_id = Auth::user()->id;
        $encuestas = [];
    
        $cuestionariosArr = Respuesta::join('preguntas', 'respuestas.pregunta_id', '=', 'preguntas.id')->select('preguntas.cuestionario_id')->where('user_id', '=', $user_id)->groupBy('preguntas.cuestionario_id')->distinct()->get();

        $cuestionarios = DB::table('cuestionarios')
                        ->whereNotIn('id', $cuestionariosArr)
                        ->get();

        
        return [ 'cuestionarios' => $cuestionarios ];
    }

    public function listarPdf(Request $request) {

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == '') {
            $cuestionarios = Cuestionario::orderBy('id', 'DESC')->paginate(10);
        } else {
            $cuestionarios = Cuestionario::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'DESC')->paginate(10);
        }

        $pdf = \PDF::loadView('pdf.cuestionarios', ['cuestionarios' => $cuestionarios]);
        return $pdf->download('cuestionarios.pdf');
    }

    public function obtenerCabecera(Request $request){
        
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $cuestionario = Cuestionario::find($id)->get();
         
        return ['cuestionario' => $cuestionario];
    }

    public function obtenerDetalles(Request $request){
        
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $detalles = Pregunta::where('cuestionario_id', '=', $id)->get();
         
        return ['detalles' => $detalles];
    }

    public function registrarEncuesta(Request $request) {

        $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos
 
            foreach($detalles as $ep=>$det)
            {
                $pregunta = new Respuesta();
                $pregunta->respuesta = $det['respuesta'];
                $pregunta->user_id = Auth::user()->id;
                $pregunta->pregunta_id = $det['id'];                      
                $pregunta->save();
            }         
    }

    public function obtenerRespuestas(Request $request) {

        $pregunta_id = $request->id;

        $respuestas = Respuesta::where('pregunta_id', '=', $pregunta_id)->get();

        return [ 'respuestas' => $respuestas ];
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $institucion_id = Auth::user()->institucion_id;
        try{
            DB::beginTransaction();           
 
            $cuestionario = new Cuestionario();            
            $cuestionario->titulo = $request->titulo;
            $cuestionario->institucion_id = $institucion_id;              
            $cuestionario->save();
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos
 
            foreach($detalles as $ep=>$det)
            {
                $pregunta = new Pregunta();
                $pregunta->cuestionario_id = $cuestionario->id;
                $pregunta->pregunta = $det['pregunta'];
                $pregunta->tipo = $det['tipo'];                      
                $pregunta->save();
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

        $cuestionario = Cuestionario::findOrFail($id);   
        $cuestionario->delete();
    }

    
}



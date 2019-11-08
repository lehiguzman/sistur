<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Nomina;
use App\Tiponomina;
use App\Empleado;
use App\Nominadetalle;
use Auth;

class NominaController extends Controller
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
                //$nominas = Nomina::orderBy('id', 'DESC')->paginate(10);
                $nominas = Nomina::join('tiponominas', 'nominas.tiponomina_id', '=', 'tiponominas.id')->select('tiponominas.nombre', 'nominas.id', 'nominas.fecini', 'nominas.fecfin', 'nominas.tiponomina_id')->paginate(10);
            } else {
                $nominas = Nomina::join('tiponominas', 'nominas.tiponomina_id', '=', 'tiponominas.id')->select('tiponominas.nombre', 'nominas.id', 'nominas.fecini', 'nominas.fecfin', 'nominas.tiponomina_id')->where($criterio, 'like', '%'.$buscar.'%')->orWhere('tiponominas.'.$criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'DESC')->paginate(10);
            }        
        
        return [
            'pagination' => [
                'total' => $nominas->total(),
                'current_page' => $nominas->currentPage(),
                'per_page' => $nominas->perPage(),
                'last_page' => $nominas->lastPage(),
                'from' => $nominas->firstItem(),
                'to' => $nominas->lastItem(),
            ],

            'nominas' => $nominas
        ];
    }

    public function listarPdf(Request $request) {

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == '') {
                //$nominas = Nomina::orderBy('id', 'DESC')->paginate(10);
                $nominas = Nomina::join('tiponominas', 'nominas.tiponomina_id', '=', 'tiponominas.id')->select('tiponominas.nombre', 'nominas.id', 'nominas.fecini', 'nominas.fecfin', 'nominas.tiponomina_id')->paginate(10);
            } else {
                $nominas = Nomina::join('tiponominas', 'nominas.tiponomina_id', '=', 'tiponominas.id')->select('tiponominas.nombre', 'nominas.id', 'nominas.fecini', 'nominas.fecfin', 'nominas.tiponomina_id')->where($criterio, 'like', '%'.$buscar.'%')->orWhere('tiponominas.'.$criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'DESC')->paginate(10);
            }

        $pdf = \PDF::loadView('pdf.nominas', ['nominas' => $nominas]);
        return $pdf->download('nominas.pdf');
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
 
            $nomina = new Nomina();
            $nomina->tiponomina_id = $request->tiponomina_id;
            $nomina->fecini = $request->fecini;
            $nomina->fecfin = $request->fecfin;     
            $nomina->save();
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos
                
            foreach($detalles as $ep=>$det)
            {
                $detalleNomina = new Nominadetalle();
                $detalleNomina->nomina_id = $nomina->id;
                $detalleNomina->empleado_id = $det['id'];
                $detalleNomina->monsal = $det['monsal'];
                if($det['monded']) { $detalleNomina->monded = $det['monded']; }
                else { $detalleNomina->monded = 0.00; }
                $detalleNomina->save();
            }             
 
            DB::commit();            

        } catch (Exception $e){
            DB::rollBack();
        }
        
    }

    public function obtenerCabecera(Request $request){
        
        //if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $nomina = Nomina::find($id);
        	
        $nombre = Tiponomina::find($nomina->tiponomina_id);
         
        return ['nomina' => $nomina, 'nombre' => $nombre];
    }

     public function obtenerDetalles(Request $request){
        
        //if (!$request->ajax()) return redirect('/');
        
        $id = $request->id;
        $detalles = Nominadetalle::join('empleados', 'nominadetalles.empleado_id', '=', 'empleados.id')->select('empleados.nombre', 'nominadetalles.id', 'nominadetalles.monsal', 'nominadetalles.monded', 'nominadetalles.nomina_id')->where('nomina_id', '=', $id)->get();
         
        return ['detalles' => $detalles];
    }

    /**
     * Return the objetivo
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectNominaEmpleado(Request $request, $nomina_id)
    {
        //if(!$request->ajax()) return redirect('/');
        $institucion_id = Auth::user()->institucion_id;
        $empleados = Empleado::where("tiponomina_id", "=", $nomina_id)->where('empleados.institucion_id', '=', $institucion_id)->get();
        /*$empleadosAll = Empleado::all();                
        $nomina = Nomina::find($nomina_id);        
        
        $empleados_nomina = $objetivo->empleados;
        $arrayEmpleados = [];

        foreach ($objetivo->empleados as $emp) {
            $arrayEmpleados[] = $emp->id;
        }

        $empleados = DB::table('empleados')
                    ->whereNotIn('id', $arrayEmpleados)
                    ->get(); */
        
        return [ 'empleados' => $empleados ];
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

        $nomina = Nomina::findOrFail($id);   
        $nomina->delete();
    }
    
}

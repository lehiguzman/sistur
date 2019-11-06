<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tiponomina;

class TiponominaController extends Controller
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
                $tipoNominas = Tiponomina::orderBy('id', 'DESC')->paginate(10);
            } else {
                $tipoNominas = Tiponomina::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'DESC')->paginate(10);
            }        
        
        return [
            'pagination' => [
                'total' => $tipoNominas->total(),
                'current_page' => $tipoNominas->currentPage(),
                'per_page' => $tipoNominas->perPage(),
                'last_page' => $tipoNominas->lastPage(),
                'from' => $tipoNominas->firstItem(),
                'to' => $tipoNominas->lastItem(),
            ],

            'tipoNominas' => $tipoNominas
        ];
    }

    public function store(Request $request)
    {
       //if (!$request->ajax()) return redirect('/');       
 
            $nomina = new Tiponomina();            
            $nomina->nombre = $request->nombre;                  
            $nomina->save();
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

        $nomina = Tiponomina::findOrFail($request->id);        
        $nomina->nombre = $request->nombre;                 
        $nomina->save();
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

        $nomina = Tiponomina::findOrFail($id);   
        $nomina->delete();
    }

    /**
     * Return the tipo de nomina
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectTipoNomina(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tipoNominas = Tiponomina::all();
        return ['tipoNominas' => $tipoNominas ];
    }
}

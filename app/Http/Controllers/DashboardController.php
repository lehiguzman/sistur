<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

	//If you would like to define a controller that only handles a single action, you may place a single __invoke method on the controller:
	//When registering routes for single action controllers, you do not need to specify a method:
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function __invoke(Request $request)
    {
        $anio=date('Y');
        $tendencias=DB::table('respuestas as c')
        ->select(DB::raw('c.tendencia as tendencia')->get();

        /*$ventas=DB::table('ventas as v')
        ->select(DB::raw('MONTH(v.fecha_venta) as mes'),
        DB::raw('YEAR(v.fecha_venta) as anio'),
        DB::raw('SUM(v.total) as total'))
        ->whereYear('v.fecha_venta',$anio)
        ->groupBy(DB::raw('MONTH(v.fecha_venta)'),DB::raw('YEAR(v.fecha_venta)'))
        ->get(); */

		return [ 'tendencias' => $tendencias ];

    }
}

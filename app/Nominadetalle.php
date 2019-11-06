<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nominadetalle extends Model
{
    protected $table = "nominadetalles";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'empleado_id', 'monsal', 'monded', 'nomina_id'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ausencia extends Model
{
    protected $table = "ausencias";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'fecfal', 'tipo', 'empleado_id', 'observacion'
    ];

    /**
     * Ausencia belongs to .
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empleado()
    {    	
    	return $this->belongsTo(Empleado::class);
    }
}

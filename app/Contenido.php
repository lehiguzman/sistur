<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $table = "contenidos";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'contenido', 'descripcion', 'curso_id'
    ];

    /**
     * Contenido belongs to Curso.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curso()
    {    	
    	return $this->belongsTo(Curso::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    protected $table = "objetivos";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'titulo', 'descripcion'
    ];

    /**
     * Objetivo has many Etapas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function etapas()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = objetivo_id, localKey = id)
    	return $this->hasMany(Etapa::class);
    }

    /**
     * Objetivo has many Empleados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empleados()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = curso_id, localKey = id)
        return $this->belongsToMany(Empleado::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = "cursos";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'nombre', 'fecini', 'duracion', 'descripcion', 'cupos'
    ];

    /**
     * Curso has many Contenidos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contenidos()
    {
    	return $this->hasMany(Contenido::class);
    }

    /**
     * Curso has many Empleados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empleados()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = curso_id, localKey = id)
        return $this->belongsToMany(Empleado::class);
    }
}

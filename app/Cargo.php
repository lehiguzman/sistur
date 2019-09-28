<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'titulo', 'descripcion'
    ];

    /**
     * Cargo has many Empleados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empleados()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = cargo_id, localKey = id)
    	return $this->hasMany(Empleado::class);
    }
}

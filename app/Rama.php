<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rama extends Model
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
     * Rama has many Instituciones.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instituciones()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = rama_id, localKey = id)
    	return $this->hasMany(Institucion::class);
    }
}

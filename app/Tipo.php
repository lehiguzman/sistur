<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = "tipos";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'nombre'
    ];

    /**
     * Tipo has many Instituciones.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instituciones()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = tipo_id, localKey = id)
    	return $this->hasMany(Institucion::class);
    }
}

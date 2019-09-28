<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'nombre'
    ];

    /**
     * Estado has many Instituciones.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instituciones()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = estado_id, localKey = id)
    	return $this->hasMany(Institucion::class);
    }
}

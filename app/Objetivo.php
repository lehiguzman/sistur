<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
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
     * Objetivo has many Objetivos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objetivos()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = objetivo_id, localKey = id)
        return $this->hasMany(Objetivo::class);
    }
}

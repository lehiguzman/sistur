<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'respuesta', 'pregunta_id'
    ];

    /**
     * Respuesta belongs to Pregunta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pregunta()
    {
    	// belongsTo(RelatedModel, foreignKey = pregunta_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Pregunta::class);
    }

    /**
     * Respuesta has many Users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = respuesta_id, localKey = id)
        return $this->hasMany(User::class);
    }

}

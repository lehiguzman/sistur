<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'pregunta', 'tipo', 'cuestionario_id'
    ];

    /**
     * Pregunta belongs to Cuestionario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cuestionario()
    {
    	// belongsTo(RelatedModel, foreignKey = cuestionario_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Cuestionario::class);
    }

    /**
     * Pregunta has many Respuestas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function respuestas()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = pregunta_id, localKey = id)
        return $this->hasMany(Respuesta::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuestionario extends Model
{
    protected $table = "cuestionarios";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'titulo', 'institucion_id'
    ];

    /**
     * Cuestionario has many Preguntas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function preguntas()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = cuestionario_id, localKey = id)
    	return $this->hasMany(Pregunta::class);
    }

    /**
     * Cuestionario belongs to Institucion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institucion()
    {
        // belongsTo(RelatedModel, foreignKey = institucion_id, keyOnRelatedModel = id)
        return $this->belongsTo(Institucion::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = "instituciones";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'nombre', 'telefono', 'direccion', 'tipo_id', 'rama_id', 'estado_id'
    ];

    /**
     * Institucion belongs to Tipo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
    	// belongsTo(RelatedModel, foreignKey = tipo_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Tipo::class);
    }

    /**
     * Institucion belongs to Rama.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rama()
    {
    	// belongsTo(RelatedModel, foreignKey = rama_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Rama::class);
    }

    /**
     * Institucion belongs to Estado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
    	// belongsTo(RelatedModel, foreignKey = estado_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Estado::class);
    }

    /**
     * Institucion has many Cuestionarios.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cuestionarios()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = institucion_id, localKey = id)
        return $this->hasMany(Cuestionario::class);
    }
}

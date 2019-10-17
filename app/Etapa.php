<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    protected $table = "etapas";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'titulo', 'descripcion', 'fecini', 'fecfin', 'estatus', 'objetivo_id'
    ];

    /**
     * Etapa belongs to Objetivo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function objetivo()
    {
    	// belongsTo(RelatedModel, foreignKey = objetivo_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Objetivo::class);
    }
}

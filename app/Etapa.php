<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'descripcion', 'objetivo_id'
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

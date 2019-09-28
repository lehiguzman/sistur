<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'cedula', 'nombre', 'email', 'telefono', 'movil', 'direccion', 'salario', 'fecing', 'fecegr', 'cargo_id', 'institucion_id'
    ];

    /**
     * Empleado has many Ausencias.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ausencias()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = empleado_id, localKey = id)
        return $this->hasMany(Ausencia::class);
    }

    /**
     * Empleado belongs to Cargo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cargo()
    {
        // belongsTo(RelatedModel, foreignKey = cargo_id, keyOnRelatedModel = id)
        return $this->belongsTo(Cargo::class);
    }

    /**
     * Empleado belongs to Institucion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institucion()
    {
        // belongsTo(RelatedModel, foreignKey = institucion_id, keyOnRelatedModel = id)
        return $this->belongsTo(Institucion::class);
    }

    /**
     * Empleado has many Cursos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursos()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = empleado_id, localKey = id)
        return $this->hasMany(Curso::class);
    }

    /**
     * Empleado has many Empleados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empleados()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = empleado_id, localKey = id)
        return $this->hasMany(Empleado::class);
    }

}

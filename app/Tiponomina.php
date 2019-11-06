<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiponomina extends Model
{
     protected $table = "tiponominas";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'nombre', 
    ];
}

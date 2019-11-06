<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    protected $table = "nominas";

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'fecini', 'fecfin', 'tiponomina_id'
    ];
    
}

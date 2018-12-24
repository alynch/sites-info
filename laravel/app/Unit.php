<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function applications()
    {
        return $this->belongsToMany(
            Applications::class,
            'application_units',
            'unit_id',
            'application_id'
        );
    }

    public function type()
    {
        return $this->belongsTo(
            UnitType::class,
            'type_id'
        );
    }
}

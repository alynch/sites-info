<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name', 'label', 'type', 'description'];

    const FEATURE_BOOLEAN = 'boolean';
    const FEATURE_STRING = 'string';

    public function applications()
    {
        return $this->belongsToMany(
            Applications::class,
            'application_features',
            'feature_id',
            'application_id'
        );
    }

    public function getTypes()
    {
       $reflector = new \ReflectionClass(get_class($this));
       $constants = $reflector->getConstants();
       $values = [];

       foreach ($constants as $constant => $value) {
           $prefix = "FEATURE_";
           if (strpos($constant, $prefix) !==false) {
               $values[$constant] = $value;
           }
       }
       return $values;
    }
}

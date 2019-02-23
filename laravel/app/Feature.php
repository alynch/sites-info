<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name', 'label', 'type', 'description'];

    public function applications()
    {
        return $this->belongsToMany(
            Applications::class,
            'application_features',
            'feature_id',
            'application_id'
        );
    }
}

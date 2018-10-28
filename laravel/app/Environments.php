<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Environments extends Model
{
    protected $fillable = ['name', 'code', 'sort_order'];

    public function applications()
    {
        return $this->belongsToMany(
            Applications::class,
            'application_environments',
            'environment_id',
            'application_id'
        );
    }
}

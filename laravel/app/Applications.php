<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    protected $fillable = ['name', 'description', 'group_id', 'all_year'];

    public function group()
    {
        return $this->belongsTo(ApplicationGroups::class);
    }

    public function timeline()
    {
        return $this->hasMany(
            Timeline::class,
            'application_id'
        );
    }


    public function environments()
    {
        return $this->belongsToMany(
            Environments::class,
            'application_environments',
            'application_id',
            'environment_id'
        )->withPivot('url')
        ->withTimestamps()
        ->orderBy('sort_order', 'desc');
    }

    public function units()
    {
        return $this->belongsToMany(
            Unit::class,
            'application_units',
            'application_id',
            'unit_id'
        )->withTimestamps()
        ->orderBy('name');
    }

    public function production()
    {
        $prod = \App\Environments::where('code', 'prod')->first();
        return $this->environments()
            ->wherePivot('environment_id', $prod->id)->first();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    protected $fillable = ['name', 'description', 'group_id'];

    public function group()
    {
        return $this->belongsTo(ApplicationGroups::class);
    }


    public function environments()
    {
        return $this->belongsToMany(
            Environments::class,
            'application_environments',
            'application_id',
            'environment_id'
        )->withPivot('url')
        ->withTimestamps();
    }

    public function production()
    {
        $prod = \App\Environments::where('code', 'prod')->first();
        return $this->environments()
            ->wherePivot('environment_id', $prod->id)->first();
    }
}

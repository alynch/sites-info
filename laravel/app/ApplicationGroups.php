<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationGroups extends Model
{
//    protected $table = 'application_groups';
    protected $fillable = ['name', 'description'];

    public function applications()
    {
        return $this->hasMany(Applications::class, 'group_id');
    }
}

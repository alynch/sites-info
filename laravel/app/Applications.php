<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Exception;

class Applications extends Model
{
    protected $fillable = ['name', 'description', 'group_id', 'all_year', 'gitlab_id'];

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

    public function getReleasesAttribute()
    {

        //$url = "https://gitlab.iit.artsci.utoronto.ca/api/v4/projects/
        //$id/repository/files/laravel%2Freadme.md?ref=master";

        $url = 'https://gitlab.iit.artsci.utoronto.ca/api/v4/projects/' . $this->gitlab_id . '/repository/tags';

        $client = new Client(
            [
                'verify' => false,
                'headers'        => ['PRIVATE-TOKEN' => env('GITLAB_TOKEN')]
            ]
        );

        try {
            $response = $client->request('GET', $url);

            $results = $response->getBody();
            $results = json_decode($results);
        } catch (Exception $e) {
            $results = [];
        }

        return collect($results)->map(function ($item, $key) {
            return (object)['name' =>$item->name, 'date' => $item->message];
        });
    }
}

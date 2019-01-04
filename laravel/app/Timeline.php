<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $table = 'application_periods';
    protected $fillable = ['start_month', 'start_day', 'end_month', 'end_day'];


    public function application()
    {
        return $this->belongsTo(Applications::class, 'application_id');
    }

    public function getRange()
    {
        $start = $this->calcRange($this->start_month, $this->start_day);
        $end = $this->calcRange($this->end_month, $this->end_day);
        $width = $end - $start;

        return [
            'start' => $start,
            'width' => $width
        ];
    }

    private function calcRange($month, $day)
    {
        return (($month - 1) + (($day -1) / 30)) * 50;
    }
}

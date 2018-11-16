<?php
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
?>
 <div class="card mb-3">
    <div class="card-header">
        <h5>Peak periods</h5>
    </div>


    <div class="card-body">
        <div class="range-box" style="display: flex">
            @foreach ($months as $key => $month)
                <span style="width: 8.333%; border-left: 1px solid #ccc; text-align: center">{{$month }}</span>
            @endforeach
        </div>
        <div class="range-box">
        @foreach ($application->timeline as $period)
            <div class="range" style="left: {{ $period->getRange()['start'] }}px; width: {{$period->getRange()['width']}}px;"> 
            </div>
        @endforeach
    </div>
    </div>

    <div class="card-body">
        <peak-periods
            :periods="{{ $application->timeline }}">
        </peak-periods>
    </div>
</div>

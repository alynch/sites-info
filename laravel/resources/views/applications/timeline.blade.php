<?php
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
?>
 <div class="card mb-3">
    <div class="card-header">
        <h3>Peak periods</h3>
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

        @foreach ($application->timeline as $period)

        <div class="form-group row">
            <label class="col-sm-1 col-form-label">
                From
            </label>


           <div class="col-sm-4">
                <select name="period[{{ $period->id }}][start_month]">
                    <option value="">Select month</option>
                    @foreach ($months as $key => $month)
                    <option value="{{ $key+1 }}"
                        @if ($period->start_month == $key+1) selected @endif >{{ $month }}</option>
                    @endforeach
                </select>
                  <input style="width: 4em" type="number" min="1" max="31" name="period[{{ $period->id }}][start_day]"
                        value="{{ $period->start_day ?? 1 }}"/>
            </div>

            <label class="col-sm-1 col-form-label">
                To
            </label>

            <div class="col-sm-4">
                <select name="period[{{ $period->id }}][end_month]">
                    <option value="">Select month</option>
                    @foreach ($months as $key => $month)
                    <option value="{{ $key+1 }}"
                        @if ($period->end_month == $key+1) selected @endif >{{ $month }}</option>
                    @endforeach
                </select>
                  <input style="width: 4em" type="number" min="1" max="31" name="period[{{ $period->id }}][end_day]"
                        value="{{ $period->end_day ?? 1 }}"/>
             </div>
        </div>
        @endforeach
    
        <a href="">Add period</a>
    </div>
</div>

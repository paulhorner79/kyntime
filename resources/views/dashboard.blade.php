@extends('layout/layout')

@section('title')
Timecodes
@stop

@section('content')

@if ($timecode)
<h2>Stop Timecode</h2>
<br>
<form method="post" action="{{Route('timecode.clear')}}">
    {{ csrf_field() }}
    <button class="btn btn-lg btn-danger" type="submit" id="stop">
          STOP<br>
          TIMECODE
    </button>
</form>
@else
<h2>Start Timecode</h2>
<br>
<form method="post" action="{{Route('timecode')}}">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="timecode[hour]">Timecode</label>
        <div class="row">
            <div class="col-xs-4">
                <input type="tel" class="form-control" name="timecode[hour]" placeholder="Hours" min="0" max="24" step="1">
            </div>
            <div class="col-xs-4">
                <input type="tel" class="form-control" name="timecode[minute]" placeholder="Minutes" min="0" max="59" step="1">
            </div>
            <div class="col-xs-4">
                <input type="tel" class="form-control" name="timecode[second]" placeholder="Seconds" min="0" max="59" step="1">
            </div>
        </div>
    </div>
    <div class="form-group">
        <button class="btn btn-lg btn-success" type="submit" id="start">
              START<br>
              TIMECODE
        </button>
    </div>
</form>
@endif

@stop

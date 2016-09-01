@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<br/>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Event Details</h3>
  </div>
  <div class="panel-body">
    <form method="POST" action="/book/saveEvent">
    {{ csrf_field() }}
<div class="row">
<div class="col-lg-5 col-sm-5 col-xs-12">
<div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
    <label for="Event Date">Event Date</label>
    <input name="date" type="text" class="form-control" id="date" placeholder="Date" value="<?php if($date!=null) echo $date; else echo old('date'); ?>">
    <span class="help-block"> In YYYY-MM-DD Format </span>
    @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
 </div> 
</div>
</div>
<div class="row">
<div class="col-lg-6 col-sm-6 col-xs-12">
 <div class="form-group">
    <label for="Event Time">Event Start Time</label>
    <select class="form-control" name="startTime">
   @for ($time = 7; $time <= 11; $time++)
       <?php $timee=$time."am"; ?>
       @if($timee==$startTime) {{-- to check if time is in db --}}
        <option value="{{$time}}am" selected> {{$time}} AM </option>
        @continue
       @endif
       @if($timee==old('startTime'))
        <option value="{{$time}}am" selected> {{$time}} AM </option>
        @continue
       @endif
    <option value="{{$time}}am"> {{$time}} AM </option>
  @endfor
   @for ($time = 12; $time <= 12; $time++)
      @if($time==$startTime) {{-- to check if time is in db --}}
        <option value="{{$time}}pm" selected> {{$time}} PM </option>
        @continue
       @endif
      @if($time==old('startTime'))
        <option value="{{$time}}pm" selected> {{$time}} PM </option>
        @continue
       @endif
    <option value="{{$time}}pm"> {{$time}} PM </option>
  @endfor

   @for ($time = 1; $time <=11 ; $time++)
       <?php $timee=$time."pm"; ?>
       @if($timee==$startTime) {{-- to check if time is in db --}}
        <option value="{{$time}}pm" selected> {{$time}} PM </option>
        @continue
       @endif
       @if($timee==old('startTime'))
        <option value="{{$time}}pm" selected> {{$time}} PM </option>
        @continue
       @endif
    <option value="{{$time}}pm"> {{$time}} PM </option>
  @endfor
</select>
 </div> 
 </div>
 <div class="col-lg-6 col-sm-6 col-xs-12">
  <div class="form-group">
    <label for="Wedding Time">To</label>
    <select  name="endTime" class="form-control">
   @for ($time = 7; $time <= 11; $time++)
       <?php $timee=$time."am"; ?>
       @if($timee==$endTime) {{-- to check if time is in db --}}
        <option value="{{$time}}am" selected> {{$time}} AM </option>
        @continue
       @endif
       @if($timee==old('endTime'))
        <option value="{{$time}}am" selected> {{$time}} AM </option>
        @continue
       @endif
    <option value="{{$time}}am"> {{$time}} AM </option>
  @endfor
   @for ($time = 12; $time <= 12; $time++)
      @if($time==$endTime) {{-- to check if time is in db --}}
        <option value="{{$time}}pm" selected> {{$time}} PM </option>
        @continue
       @endif
      @if($time==old('endTime'))
        <option value="{{$time}}pm" selected> {{$time}} PM </option> 
        @continue
       @endif
    <option value="{{$time}}pm"> {{$time}} PM </option>
  @endfor
   @for ($time = 1; $time <=11 ; $time++)
       <?php $timee=$time."pm"; ?>
       @if($timee==$endTime) {{-- to check if time is in db --}}
        <option value="{{$time}}pm" selected> {{$time}} PM </option>
        @continue
       @endif
       @if($timee==old('endTime'))
        <option value="{{$time}}pm" selected> {{$time}} PM </option>
        @continue
       @endif
    <option value="{{$time}}pm"> {{$time}} PM </option>
  @endfor
</select>
 </div> 
 </div>
 </div>
 <div class="row">
<div class="col-lg-6 col-sm-6 col-xs-12">
<div class="form-group {{ $errors->has('venue') ? ' has-error' : '' }}">
    <label for="Event Date">Venue</label>
    <input name="venue" type="text" class="form-control" id="venue" placeholder="Event Venue" value="<?php if($venue!=null) echo $venue; else echo old('venue'); ?>">
    @if ($errors->has('venue'))
         <span class="help-block">
        <strong>{{ $errors->first('venue') }}</strong>
         </span>
    @endif
 </div> 
</div>
</div>
 <div class="row">
<div class="col-lg-6 col-sm-6 col-xs-12">
<div class="form-group {{ $errors->has('guestsNo') ? ' has-error' : '' }}">
    <label for="guestsNo">Number of Guests Expected</label>
    <input name="guestsNo" type="text" class="form-control" id="guestsNo" placeholder="Number of Guests Expected" value="<?php if($guestNo!=null) echo $guestNo; else echo old('guestsNo'); ?>">
     @if ($errors->has('guestsNo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('guestsNo') }}</strong>
                                    </span>
                                @endif
 </div> 
</div>
</div>
 <div class="row">
<div class="col-lg-6 col-sm-6 col-xs-12">
<div class="form-group">
    <label for="Guests">Select MC</label>
    <select  class="form-control" name="mc">
  <option value="autopick">Auto Pick</option>
  <option value="yy">YY</option>
  <option value="zz">ZZ</option>
  <option value="ww">WW</option>
</select>
 </div> 
</div>
</div>
<div class="row">
<div class="col-lg-12 col-sm-12 col-xs-12">
<input type="submit" class="btn btn-primary pull-right" value="Next">

</div>
</div>
    </form>
  </div>
</div>
</div>
</div>
@endsection

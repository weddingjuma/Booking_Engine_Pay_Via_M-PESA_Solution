@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-lg-5 col-sm-5 col-xs-12 col-lg-offset-3 col-lsm-offset-3">
<p class="alert alert-info">{{ $amountDue }} </p>
</div>
</div>
<div class="row">
<article class="col-lg-offset-1 col-sm-offset-1 col-lg-9 col-sm-7 col-lg-push-2 col-sm-push-4 toprow">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Package Details</h3>
  </div>
  <div class="panel-body">
  <form>
  <div class="row">
  <div class="col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
    <label> Package Choosen </label>
    <input type="text" class="form-control" value="{{ucfirst($package)}}" readonly>
  </div>
    </div>
   </div>
   <div class="row">
  <div class="col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
    <label> Amount To Pay </label>
    <input type="text" class="form-control" value="{{$amount}}" readonly>
    </div>
    </div>
    </div>
    <div class="row">
    <div class="col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
    <label>Mpesa No To Pay With</label>
    <input type="text" class="form-control" value="{{$mpesaNo}}" readonly>
    </div>
    </div>
    </div>
  </form>
  </div>
</div>
</article>
<aside class="col-lg-2 col-sm-4 col-lg-pull-10 col-sm-pull-8">
<h3 class="page-header"> Your Details </h3>
<ul class="nav nav-pills nav-stacked">
<li role="presentation"> <a href="/book/bookingFinished">Bride Groom</a></li>
<li role="presentation"> <a href="/book/bookingFinishedBride">Bride </a></li>
<li role="presentation"> <a href="/book/bookingFinishedEvent">Event </a></li>
<li role="presentation" class="active"> <a href="/book/bookingFinishedPackage">Package</a></li>
</ul>
</aside>
</div>
</div>
@endsection

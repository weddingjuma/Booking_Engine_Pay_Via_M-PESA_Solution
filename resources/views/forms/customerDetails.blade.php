@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-lg-12 col-sm-12 col-xs-12">
<form method="POST" action="/book/saveCustomerDetails" >
{{ csrf_field() }}
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Couple Details</h3>
  </div>
  <div class="panel-body">
            <div class="panel panel-default">
                    <div class="panel-body">
                  <div class="row">
                  <div class="col-lg-5 col-sm-5 col-xs-12">
                  <div class="form-group {{ $errors->has('bridegroomName') ? ' has-error' : '' }}">
                      <label for="bridegroomName">Bride Groom's Name</label>
                <input name="bridegroomName" type="text" class="form-control" id="bridegroomName" placeholder="Bridegroom Name" value="<?php if($bgName!=null) echo $bgName; else echo old('bridegroomName'); ?>" >
                      @if ($errors->has('bridegroomName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bridegroomName') }}</strong>
                                    </span>
                                @endif
                    </div>
                  </div>
                  <div class="col-lg-5 col-sm-5 col-xs-12 col-lg-offset-1 col-sm-offset-1">
                  <div class="form-group{{ $errors->has('bridegroomMobileNumber') ? ' has-error' : '' }}">
                      <label for="bridegroomMobileNumber">Bride Groom's Mobile Number</label>
                      <input name="bridegroomMobileNumber" type="text" class="form-control" id="bridegroomMobileNumber" placeholder="Bridegroom Mobile Number"  value="<?php if($bgNo!=null) echo $bgNo; else echo old('bridegroomMobileNumber'); ?>" >
                      @if ($errors->has('bridegroomMobileNumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bridegroomMobileNumber') }}</strong>
                                    </span>
                                @endif
                    </div>
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-lg-5 col-sm-5 col-xs-12">
                  <div class="form-group{{ $errors->has('bridegroomEmail') ? ' has-error' : '' }}">
                      <label for="bridegroomEmail">Bride Groom's Email Address</label>
                      <input name="bridegroomEmail" type="email" class="form-control" id="bridegroomEmail" placeholder="Email Address" value="<?php if($bgEmail!=null) echo $bgEmail; else echo old('bridegroomEmail'); ?>" >
                      @if ($errors->has('bridegroomEmail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bridegroomEmail') }}</strong>
                                    </span>
                                @endif
                    </div>
                  </div>
                  </div>
                  </div>
          </div>
          </div>
                             <div class="panel-body">
                              <div class="panel panel-default">
                                      <div class="panel-body">
                            <div class="row">
                            <div class="col-lg-5 col-sm-5 col-xs-12">
                            <div class="form-group{{ $errors->has('brideName') ? ' has-error' : '' }}">
                                <label for="bridegroomName">Bride's Name</label>
                                <input name="brideName" type="text" class="form-control" id="brideName" placeholder="BrideName" value="<?php if($bName!=null) echo $bName; else echo old('brideName'); ?>" >
                      @if ($errors->has('brideName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brideName') }}</strong>
                                    </span>
                                @endif
                              </div>
                            </div>
                            <div class="col-lg-5 col-sm-5 col-xs-12 col-lg-offset-1 col-sm-offset-1">
                            <div class="form-group{{ $errors->has('brideMobileNumber') ? ' has-error' : '' }}">
                                <label for="brideMobileNumber">Bride's Mobile Number</label>
                                <input name="brideMobileNumber" type="text" class="form-control" id="brideMobileNumber" placeholder="Mobile Number" value="<?php if($bNo!=null) echo $bNo; else echo old('brideMobileNumber'); ?>" >
                      @if ($errors->has('brideMobileNumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brideMobileNumber') }}</strong>
                                    </span>
                                @endif
                              </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-lg-5 col-sm-5 col-xs-12">
                          <div class="form-group{{ $errors->has('brideEmail') ? ' has-error' : '' }}">
                                <label for="brideEmail">Bride's Email Address</label>
                                <input name="brideEmail" type="email" class="form-control" id="bridegroomEmail" placeholder="Email Address" value="<?php if($bEmail!=null) echo $bEmail; else echo old('brideEmail'); ?>" >
                      @if ($errors->has('brideEmail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brideEmail') }}</strong>
                                    </span>
                                @endif
                              </div>
                            </div>
                            </div>
                             </div>
                                    </div>
                                    </div>
    <div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
    <input type="submit" name="submit" class="btn  btn-primary pull-right" value="Next">
    </div>
    </div>
 </div>
</div>
</form>
</div>
</div>
</div>
@endsection

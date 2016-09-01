@extends('layouts.app')

@section('content')
<?php $package = "/"; ?>
<div class="container">
<div class="row">
        <div class="col-md-8 col-md-offset-1">
           <h2 style="text-align:center;"> Packages We Offer </h2>
        </div>
    </div>
<div class="row">
<div class="col-lg-3">
<div class="list-group">
  <a href="/" class="list-group-item active" style="background-color:#b300b3;">
    WEDDING M.C. ONLY
  </a>
  <a href="mc+dj" class="list-group-item">WEDDING M.C.+D.J. & SOUND (P.A.)</a>
  <a href="mconlyplus" class="list-group-item">WEDDING M.C. ONLY   <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
  <a href="mc+djplus" class="list-group-item">WEDDING M.C. + D.J. & SOUND (P.A.) <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
</div>
</div>
    <div class="col-lg-8 col-sm-8 col-xs-12">
     <div class="panel panel-default">
  <div class="panel-heading">WEDDING M.C. ONLY <p class="pull-right btn btn-default">KES 50,000.00</p></div>
  <div class="panel-body">
  <ul class="classlobster">
<li>Experience Conceptualization: dreaming up a unique
and exclusive experience specific to your wedding </li>
<br/>
<li>Dance: interactive guest engagement through dance </li><br/>
<li>Leadership: people and time management </li> <br/>
<li>Program: customized wedding program</li> <br/>
<li>Service Period: Picking the Bride, Ceremony, Reception, After Party </li> <br/>
</ul>
<a href="package/mconly" class="btn btn-primary pull-right"> Book Package </a>
  </div>
</div>
    </div>
    </div>   
</div>
@endsection

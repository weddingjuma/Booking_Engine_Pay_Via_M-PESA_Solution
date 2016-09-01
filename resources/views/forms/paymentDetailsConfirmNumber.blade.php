@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3>Payment Instructions </h3>
  </div>
<ol><br/>
<li>Select the 'Buy Goods and Services' menu item from your ‘Lipa na M-PESA’ menu </li><br/>
<li> Enter Sisimsha Entertainment's M-PESA Till Number, i.e. 40276 </li><br/>
<li>Enter the exact amount you wish to pay to Sisimsha Entertainment</li><br/>
<li>Enter your M-PESA account PIN</li><br/>
<li>Confirm Details are correct and press OK </li><br/>
<li>Having entered the above details correctly, you will receive a confirmation message</li><br/>
</ol>
</div>
</div>

<form action="/book/bookingFinish" method="POST">
{{ csrf_field() }}
<div class="row" id="confirm">
<div class="col-lg-6 col-sm-6 col-xs-12">
<div class="form-group">
    <label for="Mobile Number">Is this the mobile number you will pay with?</label>
    <input name="oldMobileNo" type="text" class="form-control" id="oldMobileNo" value="{{$phoneNumber}}" readonly>
 </div> 
 </div>
 </div>
 <div class="row">
 <div class="col-lg-6 col-sm-6 col-xs-12">
 <label class="radio-inline">
  <input type="radio" name="inlineRadioOptions" id="yes" value="yes" checked="checked"> Yes
</label>
<label class="radio-inline">
  <input type="radio" name="inlineRadioOptions" id="no" value="no"> No
</label>
 </div>
 </div>
 <div class="row" style="display: none;" id="newMobile">
 <div class="col-lg-6 col-sm-6 col-xs-12">
 <label for="Mobile Number">Enter Mobile Number</label>
 <input name="newMobileNo" type="text" class="form-control" id="newMobileNo" placeholder="Mobile Number to pay with" >
 </div>
 </div>
 <div class="row">
 <div class="col-lg-12 col-sm-12 col-xs-12">
 <input type="submit" class="btn btn-primary pull-right" value="FINISH">
 </div>
 </div>
</form>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
    $('input[type=radio][name=inlineRadioOptions]').change(function() {
        if (this.value == 'yes') {
          $('#confirm').show('slow');
          $('#newMobile').css('display','none');
         // $('#oldMobileNo').val("{{ $phoneNumber }}");
        }
        else if (this.value == 'no') {
            $('#confirm').hide('slow');
            $('#newMobile').css('display','inline');
           // $('#oldMobileNo').val("");
        }
    });
});
</script>

@endsection

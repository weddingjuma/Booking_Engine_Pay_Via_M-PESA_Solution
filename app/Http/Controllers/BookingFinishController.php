<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use DateTime;
use App\User;
use App\Http\Requests;
use GuzzleHttp;
use Mail;
class BookingFinishController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
   public function bookingFinish(Request $request){
    	//redirect to view all detaills entered
    $radio =$request->inlineRadioOptions;
    if($radio=="no"){
        
      $mobile= $request->newMobileNo;
    }
    else{
     $mobile= $request->oldMobileNo;
    }
   // echo $mobile;
    $user_id= Auth::user()->id;
    //save to db change status from temp to onHold 
     $result=  DB::table('BookingDetails')
                                ->where('user_id', $user_id)
                                ->update(
            array(
                                 'status'=>"onHold",
           )
                                  );
      //insert new number if any to payment details
                                //fetch event details and concatenate
    $booking_user_details = $this->booking_user_details();
                                //retrieve
                                   $bgName =$booking_user_details->bgName;
                                   $bName =$booking_user_details->bName;
    //is it an insert or update
                                   
   $amount= $this->determineAmount($booking_user_details);
   $check = DB::table('PaymentDetails')
            ->where('userId', '=', $user_id)
            ->count();
				   if($check==1){ //update
					$result=  DB::table('PaymentDetails')
				                                ->where('userId', $user_id)
				                                ->update(
				            array(
				                                 'mpesaNo'=>$mobile,
				                                 'amount' => $amount,
                                                 'remainderAmount'=> $amount,
				           )
				                                  );
				   }
				   else{ //insert
				    	$result=  DB::table('PaymentDetails')->insert(
				          array(
				           'userId'=>$user_id,
				           'eventName'=>ucwords($bgName." and ".$bName),
				           'mpesaNo'=>$mobile,
				           'amount'=>$amount, //dependent on amount
                           'remainderAmount'=> $amount,
				           )
				);
				   }
			   //end insertion and update redirect to new page with all details
    $this->sendToTeamUp(); //send to team up
    $this->sendEmailToCustomer(Auth::user()->email);                       //send email to customer //who signed up
    return $this->bookingFinished();
   
}
public function determineAmount($bookingDetails){
	$package= $bookingDetails->package;
	if($package=="mconly"){
		$amount ="50000";
	}
	else if($package=="mcanddj")
	{
		$amount ="85000";
	}
	else if($package=="mcanddjplus")
	{
		$amount ="300000";
	}
	else if($package=="mconlyplus")
	{
		$amount ="100000";
	}
return $amount;
}
public function booking_user_details(){
	 $user_id= Auth::user()->id;
	$booking_user_details = DB::table('BookingDetails')
            ->where('user_id', '=', $user_id)
            ->first();
    return $booking_user_details;
}
public function payment_user_details(){
	 $user_id= Auth::user()->id;
   $payment_user_details = DB::table('PaymentDetails')
            ->where('userId', '=', $user_id)
            ->first();
   return $payment_user_details;
}
public function bookingFinished(){ //bride groom 
	$booking_user_details = $this->booking_user_details();
    $payment_user_details = $this->payment_user_details();
    $amount= $this->determineAmount($booking_user_details);
    $time= "From ".$booking_user_details->startTime. "To ".$booking_user_details->endTime;
	return view('forms.savedDetails', array(
         'bgName'=>$booking_user_details->bgName,
         'bgEmail'=>$booking_user_details->bgEmail,
         'bgNo'=>$booking_user_details->bgNo,
         'bName'=>$booking_user_details->bName,
         'bEmail'=>$booking_user_details->bEmail,
         'bNo'=>$booking_user_details->bNo,
         'date'=>$booking_user_details->date,
         'time'=>$time,
         'venue'=>$booking_user_details->venue,
         'noOfGuests'=>$booking_user_details->guestNo,
         'mc'=>$booking_user_details->mcSelected,
         'amount'=>$amount,
         'amountDue'=>$this->amountDue(),
         'mpesaMobileNo'=>$payment_user_details->mpesaNo,
         'package'=>$booking_user_details->package,
    	)
    	);
   

}
public function bookingFinishedBride(){ //bride
	$booking_user_details = $this->booking_user_details();
	return view('forms.savedDetailsBride', array(
         'amountDue'=>$this->amountDue(),
         'bName'=>$booking_user_details->bName,
         'bEmail'=>$booking_user_details->bEmail,
         'bNo'=>$booking_user_details->bNo,
    	)
    	);
}
public function bookingFinishedEvent(){ //event 
	$booking_user_details = $this->booking_user_details();
	$time= "From ".$booking_user_details->startTime. " To ".$booking_user_details->endTime;
    // $myDateTime = DateTime::createFromFormat('d-m-Y', $booking_user_details->date);
    // $date = $myDateTime->format('d-m-Y');
	return view('forms.savedDetailsEvent', array(
         'date'=>$booking_user_details->date,
         'time'=>$time,
         'amountDue'=>$this->amountDue(),
         'venue'=>$booking_user_details->venue,
         'noOfGuests'=>$booking_user_details->guestNo,
         'mc'=>$booking_user_details->mcSelected,
    	)
    	);
    
}
public function bookingFinishedPackage(){ //package
	$payment_user_details = $this->payment_user_details();
	$booking_user_details = $this->booking_user_details();
    $package=$this->process_package($booking_user_details->package);
	return view('forms.savedDetailsPackage', array(
         'amount'=>$payment_user_details->amount,
         'amountDue'=>$this->amountDue(),
         'package'=>$package,
         'mpesaNo'=>$payment_user_details->mpesaNo,
    	)
    	);
}
public function amountDue(){
$user_id= Auth::user()->id;
$result = DB::table('PaymentDetails')
            ->where('userId', '=', $user_id)
            ->first();
$is_booking_fee_paid= $this->bookingPayed();
if($is_booking_fee_paid==1){ // dispaly booking fee payment info
  $amount_due= (0.3*$result->remainderAmount);  
  $to_pay ="Amount  KES ".$amount_due. " is due before 2 weeks before .";
}
else{
$amount_due= (0.2*$result->remainderAmount);
$to_pay ="Booking fee KES ".$amount_due. " is due.";
}

return $to_pay;
}
public function bookingPayed(){
$user_id= Auth::user()->id;
$result = DB::table('PaymentDetails')
            ->where('userId', '=', $user_id)
            ->first();
$booking_fee= $result->fee;
if($booking_fee==1){ //booking fee has been paid
return $paid=1;
}
else{
    return $paid= 0;
}
return $paid;
}
public function sendToTeamUp(){
$api_key ='54021be70842e369d9d2835df47e4a7d2a4d0ad86227a4dc76a452de2eb0b1fb';
$formatted= $this->formatForTeamUp();
$client = new GuzzleHttp\Client([
    'headers' => [
    'Teamup-Token' => $api_key ],
    'Teamup-Password' => 'sisimshapassword'
    ]);
        

$res = $client->post('https://api.teamup.com/ksd0736dbc41707a22/events', [
    'json' => [
        "subcalendar_id" => 2131352,
        "start_dt" => $formatted['start_date'],
        "end_dt" => $formatted['end_date'],
        "all_day" => false,
        "rrule" => "",
        "title" => $formatted['title'],
        "who" => $formatted['who'],
        "location" => $formatted['location'],
        "notes" => "Come All",
        "readonly" => true,
 ]   
]);

// echo $res->getStatusCode();
// // "201"
// echo "<br /><br />";
// $json_string = json_encode(json_decode($res->getBody()), JSON_PRETTY_PRINT);
// echo '<pre>' . $json_string . '</pre>';
}
public function formatForTeamUp(){
     $booking=$this->booking_user_details();
    switch($booking->startTime){
        case "7am":  $startTime="07:00:00"; break; case "8am":  $startTime="08:00:00"; break;
        case "9am":  $startTime="09:00:00"; break; case "10am":  $startTime="10:00:00"; break;
        case "11am":  $startTime="11:00:00"; break; case "12pm":  $startTime="12:00:00"; break;
        case "1pm":  $startTime="13:00:00"; break; case "2pm":  $startTime="14:00:00"; break;
        case "3pm":  $startTime="15:00:00"; break; case "4pm":  $startTime="16:00:00"; break;
        case "5pm":  $startTime="17:00:00"; break; case "6pm":  $startTime="18:00:00"; break;
        case "7pm":  $startTime="19:00:00"; break; case "8pm":  $startTime="20:00:00"; break;
        case "9pm":  $startTime="21:00:00"; break; case "10pm":  $startTime="22:00:00"; break;
        case "11pmm":  $startTime="23:00:00"; break;
    }
    switch($booking->endTime){
        case "7am":  $endTime="07:00:00"; break; case "8am":  $endTime="08:00:00"; break;
        case "9am":  $endTime="09:00:00"; break; case "10am":  $endTime="10:00:00"; break;
        case "11am":  $endTime="11:00:00"; break; case "12pm":  $endTime="12:00:00"; break;
        case "1pm":  $endTime="13:00:00"; break; case "2pm":  $endTime="14:00:00"; break;
        case "3pm":  $endTime="15:00:00"; break; case "4pm":  $endTime="16:00:00"; break;
        case "5pm":  $endTime="17:00:00"; break; case "6pm":  $endTime="18:00:00"; break;
        case "7pm":  $endTime="19:00:00"; break; case "8pm":  $endTime="20:00:00"; break;
        case "9pm":  $endTime="21:00:00"; break; case "10pm":  $endTime="22:00:00"; break;
        case "11pm":  $endTime="23:00:00"; break;
    }
     $date= $booking->date;
     $start_date =$date.'T'.$startTime;
     $end_date =$date.'T'.$endTime;
     $title=ucwords($booking->bgName). " and ".ucwords($booking->bName);
     $location=$booking->venue;
     $who = $booking->guestNo;
return array('start_date'=>$start_date,
     'end_date'=>$end_date,
     'title'=>$title,
     'location'=>$location,
     'who'=>$who,
    );
}
public function process_package($package){
    if($package=="mconly"){
        $package="Mc Only Package";
    }
    elseif($package=="mcanddj"){
        $package="Mc and DJ Package";
    }
    elseif($package=="mconlyplus"){
        $package="Mc Only Plus Package";
    }
    elseif($package=="mcanddjplus"){
         $package="Mc and DJ  Plus Package";
    }
    return $package;
}
public function sendEmailToCustomer($email){
$booking_user_details = $this->booking_user_details();
$payment_user_details = $this->payment_user_details();
$email= $email;
 $data = array(
                'packageTotal' => $payment_user_details->amount,
                'amountDue'=>(0.2*$payment_user_details->amount),
                'mobile' => $payment_user_details->mpesaNo,
            );
       Mail::send('emails.sentEmailOnFinishingBooking', $data, function ($m) use ($email) {
            $m->from('sisimshatest@gmail.com', 'Support@Sisimsha');

            $m->to($email)->subject('Your Booking.');
        });
}
}

<?php

namespace App\Http\Controllers;
use DB;
use Hash;
use Mail;
use SoapClient;
use Illuminate\Http\Request;

use App\Http\Requests;

class PaymentController extends Controller
{
    public function receiveFromKopokopo(Request $request){
   $amount_paid=  $request->amount;
   $mobile_no= $request->mobileNo;
//what about if customer pays with a different mobile no 
  //send mail to sismsha for reconciliation

  //deduct
   $result = DB::table('PaymentDetails')
            ->where('mpesaNo', '=', $mobile_no)
            ->first();
   $to_pay= $result->remainderAmount;
   $remainder=$to_pay - $amount_paid;
   //insert to db remainder 
   //send text to customer
   //check to see if the first payment hence booking fee
  $is_booking_fee_payed=$result->fee;
  if($is_booking_fee_payed==1){ //second installment
   $result= $this->updatePaymentMade($mobile_no, $remainder);
  }
  else{  //booking fee --book mc
  $result= $this->insertPaymentMade($mobile_no, $remainder);
    }
if($result=="bookmc"){
$this->bookingFeePayment($mobile_no ,$amount_paid);
//send email and text to mc choosen
$this->sendSmsToMc();
$this->sendEmailOnToMc();
}
else{ //second installment send text to customer trigger sismsha need be

}
   }
   public function updatePaymentMade($mobile_no, $remainder){
    $result_update=  DB::table('PaymentDetails')
				                                ->where('mpesaNo', $mobile_no)
				                                ->update(
				            array(
				               'remainderAmount'=> $remainder,
				           )
				                                  );
    return "secondins";
   }
   public function insertPaymentMade($mobile_no, $remainder){
   	$result_update=  DB::table('PaymentDetails')
				                                ->where('mpesaNo', $mobile_no)
				                                ->update(
				            array(
				               'remainderAmount'=> $remainder,
				               'fee'=>1,
				           )
				                                  );
    return "bookmc";
   }
  public function bookingFeePayment($mobile_no, $amount_paid){
   //book mc send intial contract change status to confirmed
  	$this->bookmc($mobile_no);
   //update status to confirmed --db and team up
   $this->updateStatus($mobile_no);
   //send mail with contract and info
   $userDetails=$this->userDetails($mobile_no);
   $userEmail=$userDetails->bgEmail;   //change this to auth email
   $this->sendEmailOnPayingBookingFee($amount_paid, $userEmail);
   //echo $userEmail;
  } 
  public function bookmc($mobile){
   $user_details= $this->userDetails($mobile);
   $mc= $user_details->mcSelected; //selected mc fname
   $date=$user_details->date;
   //mc details
   $mc_details = DB::table('mcs')
            ->where('fname', '=', $mc)
            ->first();
   $varmc=$mc.$date;
   //create a hash
   $mc_hash= Hash::make($varmc);
   $mc_id=$mc_details->id;
   ///insert to db   this mc should not be selected by another user
    $result=  DB::table('mc_availability')->insert(
          array(
           'mc_hash'=>$mc_hash,
           'mc_id'=>$mc_id,
           )
);
  }
  public function updateStatus($mobile){
  	 $user_details= $this->userDetails($mobile);
  	 $user_id= $user_details->user_id;
  	 $result_update=  DB::table('BookingDetails')
				                                ->where('user_id', $user_id)
				                                ->update(
				            array(
				               'status'=> "confirmed",
				           )
				                                  );
	//do the same for team up
  }
  public function userDetails($mobile){
  	$payment_details = DB::table('PaymentDetails')
            ->where('mpesaNo', '=', $mobile)
            ->first();
    $user_id = $payment_details->userId;
   $user_details = DB::table('BookingDetails')
            ->where('user_id', '=', $user_id)
            ->first();
   return $user_details;
  }
  public function sendEmailOnPayingBookingFee($amount,$userEmail){
  	     $email= $userEmail;
  	      $data = array(
                'amount' => $amount,
            );

            Mail::send('emails.sentEmailOnPayingBookingFee', $data, function ($message) use ($email) {

                $message->from('sisimshatest@gmail.com', 'Support@Sisimsha');

                $message->to($email)->subject('Your Booking');

            });

         //   return "Your email has been sent successfully";

  }
  public function sendSmsToMc(){
        $mobilenumber="0720322106";
        $message ="You have been booked for MC  services Kindly check your emailfor futher details";
        $url="http://52.41.162.150:8080/sms/smsws?wsdl";
        $sc = new SoapClient($url);
        $params = array('mobilenumber' => $mobilenumber, 'message' => $message);
        $result = $sc->__soapCall('process', array('parameters' => $params));
  }
public function sendEmailOnToMc(){
         $user_details= $this->userDetails("0720813999");
         $email= "jbett@dibon.co.ke";
          $data = array(
                'date' => $user_details->date,
                'venue' => $user_details->venue,
                'who' =>$user_details->guestNo,
            );

            Mail::send('emails.sendEmailToMc', $data, function ($message) use ($email) {

                $message->from('sisimshatest@gmail.com', 'Support@Sisimsha');

                $message->to($email)->subject('You have been Booked');

            });

         //   return "Your email has been sent successfully";

  }
}

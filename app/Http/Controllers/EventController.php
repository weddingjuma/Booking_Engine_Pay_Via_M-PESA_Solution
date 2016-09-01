<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
Use Validator;
use DateTime;
use App\User;
use App\Http\Requests;

class EventController extends Controller
{
    public function __construct(){
    $this->middleware('auth');
  }
   public function saveEvent(Request $request){ //event details logic
      $validator = Validator::make($request->all(), [
            'date' => 'required|min:10',
            'guestsNo'=>'required',
            'venue'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect('/saveEventDetail')
                        ->withErrors($validator)
                        ->withInput();
        }
    	$date=$request->date;
      // $myDateTime = DateTime::createFromFormat('d-m-Y', $date);
      // $date = $myDateTime->format('Y-m-d');
    	$startTime=$request->startTime;
    	$endTime=$request->endTime;
    	$venue=$request->venue;
    	$guestNo=$request->guestsNo;
    	$mcSelected="kimari"; ///for now
      $user_id=Auth::user()->id;
      //always an update by what if user types url?
  $result=  DB::table('BookingDetails')
                                ->where('user_id', $user_id)
                                ->update(
            array(
           'date'=>$date,
           'startTime'=>$startTime,
           'endTime'=>$endTime,
           'venue'=>$venue,
           'guestNo'=>$guestNo,
           'mcSelected'=>$mcSelected,
           'status'=>'temp',
           )
);
  //query db for the user number;
  $check = DB::table('users')
            ->where('id', '=', $user_id)
            ->first();
$phoneNumber=  $check->phoneNumber;
 if($result==1 || $result==0){
 return view('forms.paymentDetailsConfirmNumber',array('phoneNumber'=>$phoneNumber));
 }
 else //redirect back
   return back()->withInput();
  }
  public function saveEventDetail(){
    //load user details if they exist
     $user_id= Auth::user()->id;
      $check = DB::table('BookingDetails')
            ->where('user_id', '=', $user_id)
            ->count();
    if($check==1){ 
      $user_details = DB::table('BookingDetails')
            ->where('user_id', '=', $user_id)
            ->first();
     if(isset($user_details)){
       return view("forms.eventDetails", array(
         'date'=> $user_details->date,
        'startTime'=>$user_details->startTime,
        'endTime'=>$user_details->endTime,
        'venue'=>$user_details->venue,
        'guestNo'=>$user_details->guestNo,
        'mcSelected'=>$user_details->mcSelected,
        ));
      }
       else{
    return view("forms.eventDetails"); 
    }
    }
    else
    return view('forms.eventDetails');
  }
}

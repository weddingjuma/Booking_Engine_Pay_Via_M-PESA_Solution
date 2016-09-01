<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
Use Redirect;
use DateTime;
use App\User;
use App\Http\Requests;

class BookPackageController extends Controller
{
	public function __construct(){
    $this->middleware('auth');
  }
    public function book($package,User $user){
    	//call a view where customer enter details
    $user_id= Auth::user()->id;
      $check = DB::table('BookingDetails')
            ->where('user_id', '=', $user_id)
            ->count();
    ///insert package or update for existing records
      if($check==1){ //load columns that exist and pass to customer details
      $user_details = DB::table('BookingDetails')
            ->where('user_id', '=', $user_id)
            ->first();
   //update package
            $packageResult= DB::table('BookingDetails')
                                ->where('user_id', $user_id)
                                ->update(
            array(
                                 'package'=>$package,
           )
                                  ); ///end update

if(isset($user_details)){
       return view("forms.customerDetails", array(
        'bgName'=> $user_details->bgName,
        'bgEmail'=>$user_details->bgEmail,
        'bgNo'=>$user_details->bgNo,
        'bgEmail'=>$user_details->bgEmail,
        'bName'=>$user_details->bName,
        'bNo'=>$user_details->bNo,
        'bEmail'=>$user_details->bEmail,
        ));
    }//end if issset user details
       else{
    return view("forms.customerDetails", array(
        'bgName'=> null,
        'bgEmail'=>null,
        'bgNo'=>null,
        'bgEmail'=>null,
        'bName'=>null,
        'bNo'=>null,
        'bEmail'=>null,
        )); 
    }
    } //end if check
    else{ //insert package name
     $result=  DB::table('BookingDetails')->insert(
          array(
           'user_id'=>$user_id,
           'package'=>$package,
           )
);
     return view("forms.customerDetails", array(
        'bgName'=> null,
        'bgEmail'=>null,
        'bgNo'=>null,
        'bgEmail'=>null,
        'bName'=>null,
        'bNo'=>null,
        'bEmail'=>null,
        ));  
    }
  }//function
    public function saveCustomerDetails(Request $request){  //customer details logic
      ///validate first
      $this->validate($request,[
            'bridegroomName' => 'required',
            'bridegroomMobileNumber' => 'required|min:10',
            'bridegroomEmail' => 'required|email',
            'brideName' => 'required',
            'brideMobileNumber' => 'required|min:10',
            'brideEmail' => 'required|email',
        ]);
      ///done validating
    	$bridegroomName=$request->bridegroomName;
    	$bridegroomMobileNumber=$request->bridegroomMobileNumber;
    	$bridegroomEmail=$request->bridegroomEmail;
    	$brideName=$request->brideName;
    	$brideMobileNumber=$request->brideMobileNumber;
    	$brideEmail=$request->brideEmail;
    	///insert to db this is temporary data
    ///validate
    //check if user id exists
        $user_id=Auth::user()->id;
    	$check = DB::table('BookingDetails')
            ->where('user_id', '=', $user_id)
            ->exists();
           // echo $check;
      if($check == 1){
        //update
        $result=  DB::table('BookingDetails')
                                ->where('user_id', $user_id)
                                ->update(
            array(
                                 'bgName'=>$bridegroomName,
                                 'bgEmail'=>$bridegroomEmail,
                                 'bgNo'=>$bridegroomMobileNumber,
                                 'bName'=>$brideName,
                                 'bNo'=>$brideMobileNumber,
                                 'bEmail'=>$brideEmail,
                                 'status'=>'temp'
           )
                                  );
                                if($result==0) $result=1; //update but no change
      }
      else{ //insert
    //  insert to db 
   $result=  DB::table('BookingDetails')->insert(
          array(
           'user_id'=>$user_id,
           'bgName'=>$bridegroomName,
           'bgEmail'=>$bridegroomEmail,
           'bgNo'=>$bridegroomMobileNumber,
           'bName'=>$brideName,
           'bNo'=>$brideMobileNumber,
           'bEmail'=>$brideEmail,
           'status'=>'temp'
           )
);

 }
     //  echo $result;
   
   if($result>=1){//load next page  
    ///if user details exist 
     if($check==1){ //load columns that exist and pass to customer details
      $user_details = DB::table('BookingDetails')
            ->where('user_id', '=', $user_id)
            ->first();
    //  print_r($user_details);
if(isset($user_details)){
    $myDateTime = DateTime::createFromFormat('Y-m-d', $user_details->date);
    $date = $myDateTime->format('d-m-Y');
       return view('forms.eventDetails', array(
         'date'=> $user_details->date,
        'startTime'=>$user_details->startTime,
        'endTime'=>$user_details->endTime,
        'venue'=>$user_details->venue,
        'guestNo'=>$user_details->guestNo,
        'mcSelected'=>$user_details->mcSelected,
        ));
      }
    }
else {
  return view('forms.eventDetails');
}
   }
   else //redirect back
   return back()->withInput();
   	
   
    }
}

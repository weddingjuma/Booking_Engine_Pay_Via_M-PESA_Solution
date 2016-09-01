<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use DB;
class BookingController extends Controller
{
    public function __construct(){
    $this->middleware('auth')->except('index');
//    $this->middleware('ExistingUser')->only('index');
  }
    public function index(){
    	return view('book.bookinghomepage');
    }
    // public function mconly(){
    // 	return view('book.bookinghomemc+dj');
    // }
    public function mcanddj(){
    	return view('book.bookinghomemc+dj');
    }
    public function mconlyplus(){
    	return view('book.bookinghomemconlyplus');
    }
    public function mcanddjplus(){
    	return view('book.bookinghomemcanddjplus');
    }
    public function user_details(){
     $user_id= Auth::user()->id;
     $user_details = DB::table('BookingDetails')
            ->where('user_id', '=', $user_id)
            ->first();
            return $user_details;
  }  
}

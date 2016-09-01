<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use App\Http\Requests;

class ConnectToTeamUpController extends Controller
{

	public function sendToTeamUp(){
		$time="9pm";
		echo date("H:i:s");
}

}
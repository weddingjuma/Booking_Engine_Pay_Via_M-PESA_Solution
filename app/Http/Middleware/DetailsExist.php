<?php

namespace App\Http\Middleware;

use Closure;
Use Auth;
use DB;

class DetailsExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    $user_id= Auth::user()->id;
    $user_details = DB::table('BookingDetails')
            ->where('user_id', '=', $user_id)
            ->first();
     if(isset($user_details)){
    if($user_details->status=="onHold" || $user_details->status=="completed" )
     return redirect()->action('BookingFinishController@bookingFinished');
     }
        return $next($request);
    }
}

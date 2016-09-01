<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['middlewareGroups' => ['web']], function () {
Route::auth();
Route::get('/','BookingController@index');
Route::get('/home', 'HomeController@index');
//Route::get('/mconly', 'BookingController@mconly');
Route::get('/mc+dj', 'BookingController@mcanddj');
Route::get('/mconlyplus', 'BookingController@mconlyplus');
Route::get('/mc+djplus', 'BookingController@mcanddjplus');
Route::get('package/{package}','BookPackageController@book');
Route::post('saveCustomerDetails','BookPackageController@saveCustomerDetails');
Route::post('/saveEvent','EventController@saveEvent');
Route::get('/saveEventDetail','EventController@saveEventDetail');
Route::post('/bookingFinish','BookingFinishController@bookingFinish');
Route::get('/bookingFinished','BookingFinishController@bookingFinished');
Route::get('/bookingFinishedBride','BookingFinishController@bookingFinishedBride');
Route::get('/bookingFinishedEvent','BookingFinishController@bookingFinishedEvent');
Route::get('/bookingFinishedPackage','BookingFinishController@bookingFinishedPackage');
Route::get('/receiveFromKopokopo', 'PaymentController@receiveFromKopokopo');
Route::get('/sendToTeamUp','ConnectToTeamUpController@sendToTeamUp');
Route::get('/sendSmsToMc','PaymentController@sendSmsToMc');
});

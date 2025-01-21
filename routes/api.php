<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* Registe Front User */
Route::post('registeruser','API\Frontcontroller@registeruser');
/* Forget Pwd */
Route::post('forgotpassword','API\Frontcontroller@forgotpassword');
/*Password_update*/
Route::post('updatepassword','API\Frontcontroller@password_update');
/* login */
Route::post('login','API\UserController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api-check')->get('/userlogin', function (Request $request) {
	$post['data']		= \Auth::guard('api')->user();
	$post['message']    = 'You are login!';
    $post['response']   = true; 
	return response()->json($post);
});


Route::group(['middleware' => 'auth:api'],function(){

	Route::post('event/live','API\EventsDashController@liveEvent');
	Route::post('event/past','API\EventsDashController@pastEvents');
	Route::post('event/dashbord/{id}','API\EventsDashController@eventDash');
	Route::post('order/ticktes/{id}','API\EventsDashController@orderTickets');
	Route::post('ticketcode/{qrcode}/{eventuid}','API\EventsDashController@ticketCode');
	Route::get('faq','API\UserController@faq');
	Route::get('privacy','API\UserController@privacy');
	Route::get('terms','API\UserController@terms');
	Route::get('logout','API\UserController@log_out');


	//For Display Event List
	Route::get('event-list','API\EventsDashController@eventlist');
	

	Route::get('logout','API\UserController@log_out');

	/* Feature Event List */
	Route::get('event-list','API\EventlistController@featureeventlist');

	/*Single Event List */
	Route::get('singlevent/{id}','API\EventlistController@single_event');

	/*Event Ticket */
	Route::get('singlevent/ticket/{id}','API\EventlistController@single_event_ticket');
	
	/*past events */
	Route::get('past/event','API\EventlistController@pastEvents');

	/*Today events*/
	Route::get('today/event/{id?}','API\EventlistController@todayEvents');

	/*Tomoorow Events*/
	Route::get('tomorrow/event/{id?}','API\EventlistController@tomorrowEvents');

	/*Thisweek Events*/
	Route::get('thisweek/event/{id?}','API\EventlistController@thisweekEvents');
	
	/*Perticuler Category Eventlist*/
	Route::get('categoryevent/{id}','API\EventlistController@categorywiseevent');

	/*upcoming events */
	Route::get('upcoming/event','API\EventlistController@upcomingEvents');

	/*bookmark events */
	Route::get('bookmark/event','API\EventlistController@savedEvents');
	Route::post('bookmark/event/{action}','API\EventlistController@savedBookmark');

	/*edit user profile */
	Route::get('user/editprofile','API\Frontcontroller@usereditprofile');

	Route::post('user/update/profile','API\Frontcontroller@userUpdate');

	/*select Category */
	Route::get('category','API\EventlistController@category_event');


	// order booking 
	Route::post('order/book','API\BookingController@orderBook');
	Route::get('order/generate/{token}','API\BookingController@register');
	Route::post('order/store','API\BookingController@orderStore');
	// order booking
	// Order Suucess or not
	// Route::get('/order/success/{id}','API\BookingController@orderSuccess');
	Route::get('order/cancel/{id}','API\BookingController@orderCancel');

	Route::post('checked-card','API\PaymentController@checkedCardData');
	Route::post('orderdone/{id}','API\BookingController@payments');

	Route::get('order/summery/{order_id}','API\BookingController@orderSummery');
	// Order Suucess or not

	Route::get('order/tickets/upcomeing','API\BookingController@ordBook');
	Route::get('order/book/{order_id}','API\BookingController@ordTickets');
	Route::get('order/tickets/past','API\BookingController@pastEvents');


	Route::get('user-language/{id}','API\UserLanguageController@getUserLanguage');
});





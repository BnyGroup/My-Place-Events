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
/* login */
Route::post('login','APIV2\UserController@login');
Route::post('logmein','APIV2\UserController@logmein');

/* Registe Front User */
Route::post('registeruser','APIV2\Frontcontroller@registeruser');

/* Forget Pwd */
Route::post('forgotpassword','APIV2\Frontcontroller@forgotpassword');

/*Password_update*/
Route::post('updatepassword','APIV2\Frontcontroller@password_update');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* API FOR EVENTZ BOT */
	/* bot filter events */
	/**/Route::post('bot-categories','BOT\BotController@botCategoryList');
	/**/Route::post('bot-eventlist','BOT\BotController@botEventsList');
	/**/Route::post('bot-eventtickets','BOT\BotController@botEventTickets');
	/**/Route::post('bot-booking','BOT\BotController@botBooking');
/* API FOR EVENTZ BOT */

Route::group(['middleware' => 'auth:api'],function(){

	/* Organization APP API */
	Route::post('event/live','APIV2\EventsDashController@liveEvent');
	Route::post('event/past','APIV2\EventsDashController@pastEvents');
	Route::post('event/dashbord/{id}','APIV2\EventsDashController@eventDashbord');
	Route::post('order/ticktes/{id}','APIV2\EventsDashController@orderTickets');
	Route::post('ticketcode/{qrcode}/{eventuid}','APIV2\EventsDashController@ticketCode');
	Route::get('logout','APIV2\UserController@log_out');
    
	Route::get('myorder/tickets/{id}','APIV2\EventsDashController@myOrderTickets');
	Route::get('myorder/ticketsScanned/{id}','APIV2\EventsDashController@myOrderTicketsScanned');
	Route::get('myorderdetails/tickets/{orderid}','APIV2\EventsDashController@myOrderTicketsDetails');

	Route::get('eventAttendee/{id}','APIV2\EventsDashController@eventAttendee');
	Route::get('userdatas/{id}','APIV2\EventsDashController@userDatas');
	Route::get('eventlistall','APIV2\EventsDashController@userAllList');
	/* Organization APP API */
 	// //For Display Event List
	// Route::get('event-list','APIV2\EventsDashController@eventlist');

	/* Feature Event List */
	/**/Route::get('event-list','APIV2\EventlistController@featureeventlist');
	
	/*Single Event List */
	/**/Route::get('singlevent/{id}','APIV2\EventlistController@single_event');
	Route::get('mysinglevent/{id}','APIV2\EventlistController@mysingle_event');
	/*Event Ticket */
	/**/Route::post('event/ticket','APIV2\EventlistController@single_event_ticket');

	Route::post('event/booking', 'APIV2\EventlistController@single_event_booking')->middleware('scopes:event-booking-url');

	/*upcoming events */
	Route::get('upcoming/event','APIV2\EventlistController@upcomingEvents');
	Route::get('myupcoming/event','APIV2\EventlistController@myupcomingEvents');
	Route::post('checkqrcode/event','APIV2\EventlistController@checkeventqrcode');
	/*past events */
	Route::get('past/event','APIV2\EventlistController@pastEvents');    
    Route::get('myevent/past','APIV2\EventsDashController@myPastEvents');



	/*select Category */
	/**/Route::get('category','APIV2\EventlistController@getCategoryList');
	/*Perticuler Category Eventlist*/
	/**/Route::post('category/event','APIV2\EventlistController@categorywiseevent');
	/*Today events*/
	/**/Route::post('today/event','APIV2\EventlistController@todayEvents');
	/*Tomoorow Events*/
	/**/Route::post('tomorrow/event','APIV2\EventlistController@tomorrowEvents');
	/*Thisweek Events*/
	/**/Route::post('thisweek/event','APIV2\EventlistController@thisweekEvents');


	/*bookmark events */
	/**/Route::get('bookmark/event','APIV2\EventlistController@savedEvents'); /* Set Paninate */
	/**/Route::post('setbookmark','APIV2\EventlistController@savedBookmark');


	/*edit user profile */
	/**/Route::get('user/profile','APIV2\Frontcontroller@userProfile');
	/**/Route::post('user/update/profile','APIV2\Frontcontroller@userUpdate');


	// order booking 
	/**/Route::post('order/book','APIV2\BookingController@orderBook');
	/**/Route::post('order/generate','APIV2\BookingController@register');
	/**/Route::post('order/store','APIV2\BookingController@orderStore');

	/* Order Payment - stripe */
	/**/Route::post('checked-card','APIV2\PaymentController@checkedCardData');
	
	// Order Suucess or not
	/**/Route::post('order/done','APIV2\BookingController@orderDone');		
	/**/Route::post('order/cancel','APIV2\BookingController@orderCancel');


	// order booking
	/**/Route::get('order/summery/{order_id}','APIV2\BookingController@orderSummery');
	/**/Route::get('order/tickets/upcomeing','APIV2\BookingController@upcomingOrder');
	/**/Route::get('order/tickets/past','APIV2\BookingController@pastOrder');
	/**/Route::get('order/tickets/{order_id}','APIV2\BookingController@ordTickets');

	/* */
	Route::get('user-language/{id}','APIV2\UserLanguageController@getUserLanguage');

});



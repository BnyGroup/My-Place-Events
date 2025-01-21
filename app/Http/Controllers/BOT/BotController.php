<?php

namespace App\Http\Controllers\BOT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Booking;
use App\orderTickets;
use App\EventTicket;
use App\Bookmark;
use App\EventCategory;
use App\GuestUser;

use Auth;
use Session;

class BotController extends Controller {

    public function __construct() {
        $this->event_category = new EventCategory;
        $this->event = new Event;
        $this->eventTicket = new EventTicket;
        $this->ticket_booking = new Booking;
        $this->guest_user = new GuestUser;
    }

    /* Bot Categories List */
    public function botCategoryList(Request $request) {
    	$categoryData = $this->event_category->get_Category_eventAPI();
        $output = array();
        if(!$categoryData->isEmpty()) {
            foreach ($categoryData as $key => $value) {
                $output[$key]['category_id'] = (String)$value->id;
                $output[$key]['category_name'] = (String)$value->category_name;
                $output[$key]['child'] = array();
                if(!$value->children->isEmpty()){
                    foreach ($value->children as $skey => $svalue) {
                        $output[$key]['child'][$skey]['category_id'] = (String)$svalue->id;
                        $output[$key]['child'][$skey]['category_name'] = (String)$svalue->category_name;
                    }
                }
            }
        }
        if (!empty($output)) {
            $message = "Categories list";
            return $this->getSuccessResult($output,$message,true);
        }else{
            $message    = "Cagegory not found";
            return $this->getErrorMessage($message);
        }
    }
    /* Bot Categories List */
    /* Bot Events List */
    public function botEventsList(Request $request) {
        $input      = $request->all();
        $category_id    = isset($input['category_id'])?$input['category_id']:'';
        $location       = isset($input['location'])?$input['location']:'';
        $category_ids = array();
        if($category_id != ''){
            $childid =  $this->event_category->getChildCategory($category_id);
            if(!empty($childid)){
                foreach ($childid as $key => $value) {
                    $category_ids[] = (String)$value;
                }              
                array_push($category_ids, $category_id);
            }else{
                $category_ids = $category_id;
            }
        }

        $eventData      = $this->event->getBotEvnetsList($category_ids,$location);
        $datas = array();
        $oData['events'] = array();
        if(!$eventData->isEmpty()){
            foreach ($eventData as $key => $value) {
                $datas[$key]['event_id']        = (String)$value->event_unique_id;
                $datas[$key]['event_image']     = (String)getImage($value->event_image, 'resize');
                $datas[$key]['event_name']      = (String)$value->event_name;
                $datas[$key]['event_start_datetime'] = (String)$value->event_start_datetime;
                $datas[$key]['event_location']  = (String)$value->event_location;
            }
        }
        $oData['events'] = $datas;
        $last_page = !is_null($eventData->lastPage())?$eventData->lastPage():'';
        $pagination['current_page']   = !is_null($eventData->currentPage())?$eventData->currentPage():'';
        $pagination['last_page']      = $last_page;
        $pagination['first_page_url'] = $eventData->url(1);
        $pagination['last_page_url']  = $eventData->url($last_page);
        $pagination['next_page_url']  = !is_null($eventData->nextPageUrl())?$eventData->nextPageUrl():'' ;
        $pagination['prev_page_url']  = !is_null($eventData->previousPageUrl())?$eventData->previousPageUrl():'';
        // $pagination['path']           = !is_null($eventData->getOptions()['path'])?$eventData->getOptions()['path']:'';
        $pagination['per_page']       = !is_null($eventData->perPage())?$eventData->perPage():'';
        $pagination['from']           = !is_null($eventData->firstItem())?$eventData->firstItem():'';
        $pagination['to']             = !is_null($eventData->lastItem())?$eventData->lastItem():'';
        $pagination['total']          = !is_null($eventData->total())?$eventData->total():'';
        $oData['paginate'] = $pagination;
        if (!$eventData->isEmpty()) {
            $message = 'Feature Events';
        }else{
            $message    = "Feature Events not found";
        }
        return $this->getSuccessResult($oData,$message,true);
    }
    /* Bot Events List */
    /* Bot Event's Tickets' */
    public function botEventTickets(Request $request) {
    	$input      = $request->all();
        $event_id   = $input['event_id'];
        $ddata      =  $this->event->get_single_event_data($event_id);
        $ticketdata = $this->eventTicket->getsingle_event_ticket($event_id);            

        $data = array();
        // $data['event'] = $ddata;
        foreach ($ticketdata as $key => $value) {
            $data[$key]['ticket_id']             = (String)$value->ticket_id;
            $data[$key]['ticket_title']          = (String)$value->ticket_title;
            $data[$key]['ticket_description']    = (String)$value->ticket_description;
            $data[$key]['ticket_type']           = (String)$value->ticket_type;
            $data[$key]['ticket_qty']            = (String)$value->ticket_qty;
            $data[$key]['ticket_remaning_qty']   = (String)$value->ticket_remaning_qty;
            $data[$key]['ticket_price_buyer']    = (String)$value->ticket_price_buyer;
        }
        if (!empty($data)) {
            $message = 'Tickets';
            return $this->getSuccessResult($data,$message,true);
        }
        $message    = "Tickets not found";
        return $this->getErrorMessage($message);
    }
    /* Bot Event's Tickets' */
    /* Bot Event Booking */
    public function botBooking(Request $request) {
    	$input      = $request->all();
    	$guestuserName 	= $input['guestuserName'];
    	$guestUserEmail	= $input['guestUserEmail'];
    	$userdata = ['guest_id' => str_shuffle(time()), 'user_name' => $guestuserName, 'guest_email' => $guestUserEmail];

    	$getGuestUser = $this->guest_user->searchByEmail($guestUserEmail);
    	if(is_null($getGuestUser)){
    		$guestUserData = $this->guest_user->insertData($userdata);
    	}else{
    		$guestUserData = $getGuestUser;
    	}

        $client_token		= str_shuffle(generateCrefToken());        
		$bookingOrder_id	= generate_booking_code($input['event_id']);
        $event_id   		= $input['event_id'];

        $bookingData['user_id'] 		= 0;
		$bookingData['gust_id']			= $guestUserData->guest_id;
		$bookingData['event_id']		= $input['event_id'];
		$bookingData['order_id']		= $bookingOrder_id;		
		$bookingData['client_token']	= $client_token;

    	$order_t_id = array();
		$order_t_title = array();
		$order_t_price = array();
		$order_t_fees = array();
		$order_t_commission = array();
		$order_t_qty = array();
		$order_commission = array();
		$order_Tamount = array();

		foreach ($input['ticket_type_qty'] as $key => $value) {
			if($value != 0){
				$quanty		= $input['ticket_type_qty'][$key];
				$ticket_id 	= $input['ticket_id'][$key];
				$ticket 	= $this->eventTicket->ticket_by_id($ticket_id);

				$ticketPriceActual = number_format(floatval($ticket->ticket_price_actual),2, '.', '');

				/* TICKET COMMISSION AND FEES */
				$orderTcommission	= ($ticketPriceActual * $ticket->ticket_commission) / 100;
				if($ticket->ticket_services_fee == 1){
					$orderTfees	= floatval($orderTcommission);
				}else{
					$orderTfees	= floatval(0);
				}
				/* TICKET COMMISSION AND FEES */
				/* TICKET DATA */
				if($ticket->ticket_qty >= $quanty){
					$order_t_id[]			= $ticket_id;
					$order_t_title[]		= $ticket->ticket_title;
					$order_t_price[]		= $ticketPriceActual;					
					$order_t_fees[]			= number_format(floatval($orderTfees), 2, '.', '');
					$order_t_commission[]	= number_format(floatval($orderTcommission),2, '.', '');
					$order_t_qty[]			= $quanty;
					$order_commission[]		= floatval($orderTcommission) * intval($quanty);
					$order_Tamount[]		= ($ticketPriceActual+$orderTfees)*$quanty;
				}
				/* TICKET DATA */
				$ticketId = $ticket->ticket_id;
				$ticket_update = $this->eventTicket->decres_ticket_qty($ticketId, intval($quanty));
				$ticket_data['ticket_remaning_qty']	= intval($ticket->ticket_remaning_qty) - intval($quanty);

			}
		}
		/*tickets data*/
		$bookingData['order_tickets']		= $input['total_ticket'];
		$bookingData['order_amount']		= number_format(array_sum($order_Tamount),2, '.', '');
		$bookingData['order_commission']	= number_format(array_sum($order_commission),2, '.', '');
		/*serialize data*/
		$bookingData['order_t_id']			= serialize($order_t_id);
		$bookingData['order_t_title']		= serialize($order_t_title);
		$bookingData['order_t_qty']			= serialize($order_t_qty);
		$bookingData['order_t_price']		= serialize($order_t_price);
		$bookingData['order_t_fees']		= serialize($order_t_fees);
		$bookingData['order_t_commission']	= serialize($order_t_commission);

		$data = $this->ticket_booking->insertData($bookingData);
		$this->session = new Session();
		$this->session::push('order_id', $bookingOrder_id );

		$url = route('ticket.register', $client_token);

		$message = 'Order booking';
        return $this->getSuccessResult(array('url'=>$url),$message,true);


        
        
        // // $data['event'] = $ddata;
        // foreach ($ticketdata as $key => $value) {
        //     $data[$key]['ticket_id']             = (String)$value->ticket_id;
        //     $data[$key]['ticket_title']          = (String)$value->ticket_title;
        //     $data[$key]['ticket_description']    = (String)$value->ticket_description;
        //     $data[$key]['ticket_type']           = (String)$value->ticket_type;
        //     $data[$key]['ticket_qty']            = (String)$value->ticket_qty;
        //     $data[$key]['ticket_remaning_qty']   = (String)$value->ticket_remaning_qty;
        //     $data[$key]['ticket_price_buyer']    = (String)$value->ticket_price_buyer;
        // }
        // if (!empty($data)) {
        //     $message = 'Tickets';
        //     return $this->getSuccessResult($data,$message,true);
        // }
        // $message    = "Tickets not found";
        // return $this->getErrorMessage($message);
    }
    /* Bot Event Booking */
/* ================================================================================= */
/* ================================================================================= */
/* ================================================================================= */
    /* NEW CODE */
    public function getSuccessResult($datas='',$message,$response) {
        $output['data']       = $datas;
        $output['message']    = $message;
        $output['response']   = $response;
        return response()->json($output);        
    }
    public function getErrorMessage($message='Some Thing Wrong!') {
        $output['data']       = '';
        $output['message']    = $message;
        $output['response']   = false;
        return response()->json($output);
    }
    public function getValidationMessage($message) {
        $output['data']       = '';
        $output['message']    = $message;
        $output['response']   = false;
        return response()->json($output);   
    }
    /* NEW CODE */
/* ================================================================================= */
/* ================================================================================= */
/* ================================================================================= */

}

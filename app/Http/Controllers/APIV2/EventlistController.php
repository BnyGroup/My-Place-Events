<?php

namespace App\Http\Controllers\APIV2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\APIV2\UserController;
use App\ModalAPI\Event;
use App\ModalAPI\Booking;
use App\ModalAPI\orderTickets;
use App\ModalAPI\EventTicket;
use Auth;
use App\ModalAPI\Bookmark;
use App\ModalAPI\EventCategory;
use App\GuestUser;
use App\EventTicket as EventTicketBooking;
use App\Booking as TicketBooking;

class EventlistController extends UserController
{
    public function __construct()
    {
        $this->event = new Event;
        $this->orderTicket = new orderTickets;
        $this->eventTicket = new EventTicket;
        $this->event_book = new Booking;
        $this->event_save = new Bookmark;
        $this->event_category = new EventCategory;
        $this->guestUser = new GuestUser;
        $this->ticketBooking = new TicketBooking;
        $this->eventTicketBooking = new EventTicketBooking;
    }

    /* feature event list */
    public function featureeventlist() {
        if (Auth::guard('api')->check()) {
            $user_id    = Auth::guard('api')->user()->id;
            $eventData  = $this->event->getfeatureevent();
            $savedeve   = $this->event_save->getBookListeve($user_id);
            $result_array = array();
            foreach ($savedeve as $each_number) {
                $result_array[] = $each_number;
            }
            $datas = array();
            $oData['events'] = array();
            if(!$eventData->isEmpty()){
                foreach ($eventData as $key => $value) {
                    $datas[$key]['event_id']        = (String)$value->event_unique_id;
                    $datas[$key]['event_image']     = (String)getImage($value->event_image, 'resize');
                    $datas[$key]['event_name']      = (String)$value->event_name;
                    $datas[$key]['event_start_datetime'] = (String)$value->event_start_datetime;
                    $datas[$key]['event_location']  = (String)$value->event_location;
                    if(in_array($value->event_unique_id,$result_array)){
                        $datas[$key]['liked'] = 1;
                    }else{
                        $datas[$key]['liked'] = 0;
                    }
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
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    /* feature event list */

    /* single event */
    
     public function mysingle_event($id) {        
        if (Auth::guard('api')->check()) {
            $user_id    = Auth::guard('api')->user()->id;
            $datas =  $this->event_save->getData($id,$user_id);
            $tscanned = $this->event->geteventscanned($id);
            $grossIncome    = array();
            
            $eventData = $this->event->getsingle_event($id);
			
            if (!empty($eventData)) {
                
                $output['id']         = (Int)$eventData->id;
                $output['event_category'] = (String)$eventData->category_name;
                $output['event_id']         = (String)$eventData->event_unique_id;
                $output['event_name']       = (String)isset($eventData->event_name)?$eventData->event_name:'';
                $output['event_image']      = (String)getImage($eventData->event_image, 'resize');

                $output['event_start_datetime'] = (String)isset($eventData->event_start_datetime)?$eventData->event_start_datetime:'';
                $output['event_end_datetime']   = (String)isset($eventData->event_end_datetime)?$eventData->event_end_datetime:'';

                $output['event_location']   = (String)isset($eventData->event_location)?$eventData->event_location:'';
                $output['event_address']    = (String)isset($eventData->event_address)?$eventData->event_address:'';
                
                $output['EVENT_ORDERD_TICKETS']   = (String)is_null($eventData->EVENT_ORDERD_TICKETS)?'0':$eventData->EVENT_ORDERD_TICKETS;
                $output['EVENT_TOTAL_TICKETS']    = (String)is_null($eventData->EVENT_TOTAL_TICKETS)?'0':$eventData->EVENT_TOTAL_TICKETS;
                
                //$output['organizer_id']     = (String)isset($eventData->organizations_id)?$eventData->organizations_id:'';
                //$output['organizer_name']   = (String)isset($eventData->organizer_name)?$eventData->organizer_name:'';
                //$output['about_organizer']  = (String)isset($eventData->about_organizer)?$eventData->about_organizer:'';
               // $output['url_slug']         = (String)isset($eventData->url_slug)?$eventData->url_slug:'';

                $output['event_max_price']  = (String)isset($eventData->event_max_price)?$eventData->event_max_price:'0.00';
                $output['event_min_price']  = (String)isset($eventData->event_min_price)?$eventData->event_min_price:'0.00';
                $output['currency_symbol']  = (String)isset(use_currency()->symbol)?use_currency()->symbol:'&#36;';
                $output['currency_type']    = (String)isset(use_currency()->type)?use_currency()->type:'USD';
                $output['TOTAL_SCANNED']    = (String)$tscanned->TOTAL_SCANNED;//is_null($tscanned->TOTAL_SCANNED)?'0':
 
                $ddata      =  $this->event->get_single_event_data($id);
                //$ticketdata = $this->eventTicket->getsingle_event_ticket($id);            
    
                $output['event'] = $ddata;
                /*foreach ($ticketdata as $key => $value) {
                    $output['tickets'][$key]['ticket_id']             = (String)$value->ticket_id;
                    $output['tickets'][$key]['ticket_title']          = (String)$value->ticket_title;
                    $output['tickets'][$key]['ticket_description']    = (String)$value->ticket_description;
                    $output['tickets'][$key]['ticket_type']           = (Integer)$value->ticket_type;
                    $output['tickets'][$key]['ticket_qty']            = (Integer)$value->ticket_qty;
                    $output['tickets'][$key]['ticket_remaning_qty']   = (Integer)$value->ticket_remaning_qty;
                    $output['tickets'][$key]['ticket_price_buyer']    = (String)$value->ticket_price_buyer;
                }*/
                $event_id = $id;
                $eventData = $this->event->eventByUid($event_id);
                if(!is_null($eventData)){
                    $event_tickets      = $this->eventTicket->event_total_tickets($event_id);
                    $eventOrderTickets  = $this->eventTicket->eventOrderTickets($event_id);
                    $totalOrderTickss   = $this->orderTicket->totalOrderTickss($event_id);

                    foreach ($eventOrderTickets as $key => $value) {
                        $chackIn = $value->NUMBER_OF_CHACKIN==null?0:$value->NUMBER_OF_CHACKIN;
                        $total_order = $value->NUMBER_OF_ORDER==null?0:$value->NUMBER_OF_ORDER;
                        $ticket_income = floatval($value->TICKE_PRICE)* intval($total_order);
                        $orderTicket[$key] = array(
                            'TICKE_TITLE'         => (String)$value->TICKE_TITLE,
                            'TICKE_QTY'           => (Integer)$value->TICKE_QTY,
                            'NUMBER_OF_ORDER'     => (Integer)$total_order,
                            'NUMBER_OF_CHACKIN'   => (Integer)$chackIn,
                            'TICKET_PRICE' => (String)$value->TICKE_PRICE,
                            'TICKET_SOLD' => (String)$ticket_income,

                        );
                        $grossIncome[$key] = $ticket_income; 
                    }
                    $eventgrossIncome = number_format(array_sum($grossIncome),2).' '.html_entity_decode(use_currency()->symbol);
                    $output['event_gross_income']     = (String)$eventgrossIncome;
                    //$output['event_total_tickets']    = (String)$event_tickets->TOTAL_TICKETS;
                    //$output['total_order_tickets']    = (String)$totalOrderTickss->TOTAL_ORDER_TICKETS;
                    $output['event_order_tickets']    = $orderTicket;
                }
              
                $message = 'Events';
                return $this->getSuccessResult($output,$message,true);
            }else{
                $message    = "Event not found";
                return $this->getErrorMessage($message);    
            }
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    
    public function single_event($id) {        
        if (Auth::guard('api')->check()) {
            $user_id    = Auth::guard('api')->user()->id;
            $datas =  $this->event_save->getData($id,$user_id);

            $eventData = $this->event->getsingle_event($id);
            if (!empty($eventData)) {
                $output['event_id']         = (String)$eventData->event_unique_id;
                $output['event_name']       = (String)isset($eventData->event_name)?$eventData->event_name:'';
                $output['event_image']      = (String)getImage($eventData->event_image, 'resize');

                $output['event_description']    = (String)isset($eventData->event_description)? ($eventData->event_description) :'';
                $output['event_start_datetime'] = (String)isset($eventData->event_start_datetime)?$eventData->event_start_datetime:'';
                $output['event_end_datetime']   = (String)isset($eventData->event_end_datetime)?$eventData->event_end_datetime:'';

                $output['event_location']   = (String)isset($eventData->event_location)?$eventData->event_location:'';
                $output['event_address']    = (String)isset($eventData->event_address)?$eventData->event_address:'';
                
                $output['organizer_id']     = (String)isset($eventData->organizations_id)?$eventData->organizations_id:'';
                $output['organizer_name']   = (String)isset($eventData->organizer_name)?$eventData->organizer_name:'';
                $output['about_organizer']  = (String)isset($eventData->about_organizer)?$eventData->about_organizer:'';
                $output['url_slug']         = (String)isset($eventData->url_slug)?$eventData->url_slug:'';

                $output['event_max_price']  = (String)isset($eventData->event_max_price)?$eventData->event_max_price:'0.00';
                $output['event_min_price']  = (String)isset($eventData->event_min_price)?$eventData->event_min_price:'0.00';
                $output['currency_symbol']  = (String)isset(use_currency()->symbol)?use_currency()->symbol:'&#36;';
                $output['currency_type']    = (String)isset(use_currency()->type)?use_currency()->type:'USD';

                $location = getLatLong($eventData->event_location);
                $output['latitude']         = (String)isset($location->lat)?$location->lat:'0';
                $output['longitude']        = (String)isset($location->long)?$location->long:'0';

                if(! is_null($datas)){
                    $output['liked'] = 1;
                }else{
                    $output['liked'] = 0;
                }
                
                $message = 'Events';
                return $this->getSuccessResult($output,$message,true);
            }else{
                $message    = "Event not found";
                return $this->getErrorMessage($message);    
            }
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    /* single event */
    /* single_event_ticket */
    public function single_event_ticket(Request $request) {
        if (Auth::guard('api')->check()) {
            $input      = $request->all();
            $event_id   = $input['event_id'];
            $user_id    = Auth::guard('api')->user()->id;
            $ddata      =  $this->event->get_single_event_data($event_id);
            $ticketdata = $this->eventTicket->getsingle_event_ticket($event_id);            

            $data = array();
            $data['event'] = $ddata;
            foreach ($ticketdata as $key => $value) {
                $data['tickets'][$key]['ticket_id']             = (String)$value->ticket_id;
                $data['tickets'][$key]['ticket_title']          = (String)$value->ticket_title;
                $data['tickets'][$key]['ticket_description']    = (String)$value->ticket_description;
                $data['tickets'][$key]['ticket_type']           = (Integer)$value->ticket_type;
                $data['tickets'][$key]['ticket_qty']            = (Integer)$value->ticket_qty;
                $data['tickets'][$key]['ticket_remaning_qty']   = (Integer)$value->ticket_remaning_qty;
                $data['tickets'][$key]['ticket_price_buyer']    = (String)$value->ticket_price_buyer;
            }
            if (!empty($data)) {
                $message = 'Tickets';
                return $this->getSuccessResult($data,$message,true);
            }
            $message    = "Tickets not found";
            return $this->getErrorMessage($message);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    /* single_event_ticket */

    public function single_event_booking(Request $request) {

        $request->validate([
            'customer_name' => 'string',
            'customer_email' => 'email',
            'customer_cellphone' => 'string',
            'event_id' => 'integer|exists:events,event_unique_id',
            'tikets' => 'array',
            'tikets.*' => 'string',
        ]);

        $customer = $this->guestUser->searchByEmail($request->customer_email);
        if (is_null($customer)) 
            $customer = $this->guestUser->insertData([
                'guest_id' => str_shuffle(time()), 
                'user_name' => $request->customer_name, 
                'guest_email' => $request->customer_email,
                'cellphone' => $request->customer_cellphone,
            ]);

        // Prepare order
        $order_t_id = $order_t_title = $order_t_price = $order_t_fees = $order_t_commission = $order_t_qty = $order_commission = $order_Tamount = [];

        foreach ($request->tickets as $item) {
            $t = explode('::', $item);
            $t_id = $t[0];
            $t_qty = (int) $t[1];

            $ticket = $this->eventTicketBooking->ticket_by_id($t_id);

            if ($ticket && $t_qty > 0) {
                // Recalculate price
                $ticket_price = number_format(floatval($ticket->ticket_price_actual),2, '.', '');
                
                // Apply commissions and fees
                $ticket_commissions	= ($ticket_price * $ticket->ticket_commissions) / 100;
                $ticket_fees = ($ticket->ticket_services_fee == 1) ? floatval($ticket_commissions) : floatval(0);
                
                // Update order infos
                if ($ticket->ticket_qty >= $t_qty) {
                    $order_t_id[]			= $ticket->ticket_id;
                    $order_t_title[]		= $ticket->ticket_title;
                    $order_t_price[]		= $ticket_price;					
                    $order_t_fees[]			= number_format(floatval($ticket_fees), 2, '.', '');
                    $order_t_commission[]	= number_format(floatval($ticket_commissions), 2, '.', '');
                    $order_t_qty[]			= $t_qty;
                    $order_commission[]		= floatval($ticket_commissions) * intval($t_qty);
                    $order_Tamount[]		= ($ticket_price + $ticket_fees) * $t_qty;
                }
    
                // Decrement ticket quantity
                $this->eventTicketBooking->decres_ticket_qty($ticket->ticket_id, intval($t_qty));
            }
        }

        // Set booking data
        $bookingData['user_id'] 		    = 0;
        $bookingData['gust_id']			    = $customer->guest_id;
        $bookingData['event_id']		    = $request->event_id;
        $bookingData['order_id']		    = generate_booking_code($request->event_id);	
        $bookingData['client_token']	    = str_shuffle(generateCrefToken());
		$bookingData['order_tickets']		= array_sum($order_t_qty);
		$bookingData['order_amount']		= number_format(array_sum($order_Tamount), 2, '.', '');
		$bookingData['order_commission']	= number_format(array_sum($order_commission), 2, '.', '');
		$bookingData['order_t_id']			= serialize($order_t_id);
		$bookingData['order_t_title']		= serialize($order_t_title);
		$bookingData['order_t_qty']			= serialize($order_t_qty);
		$bookingData['order_t_price']		= serialize($order_t_price);
		$bookingData['order_t_fees']		= serialize($order_t_fees);
		$bookingData['order_t_commission']	= serialize($order_t_commission);

        // Insert data
        $this->ticketBooking->insertData($bookingData);

		// $this->session = new Session();
		// $this->session::push('order_id', $bookingData['order_id']);

        return response()->json(['url' => route('ticket.register', $bookingData['client_token'])]);
    }

/* ======================================================================================== */
/* ======================================================================================== */
/* ======================================================================================== */
    /* User upcoming events for api*/
    public function upcomingEvents() { 
        if (Auth::guard('api')->check()) {
            $user_id    = Auth::guard('api')->user()->id;
            $eventData = $this->event_book->upcoming_tikcets_events($user_id);
            $oData['events'] = array();
            if(!$eventData->isEmpty()){
                foreach ($eventData as $key => $value) {
                    $output[$key]['event_id']       = (String)$value->event_unique_id;
                    $output[$key]['event_name']     = (String)$value->event_name;
                    $output[$key]['event_image']    = (String)getImage($value->event_image);
                    $output[$key]['order_id']       = (String)$value->order_id;
                    $output[$key]['event_location'] = (String)$value->event_location;
                    $output[$key]['event_start_datetime'] = (String)$value->event_start_datetime;
                }
                $oData['events'] = $output;
            }
            $last_page = !is_null($eventData->lastPage())?$eventData->lastPage():'';
            $pagination['current_page']   = !is_null($eventData->currentPage())?$eventData->currentPage():'';
            $pagination['last_page']      = $last_page;
            $pagination['first_page_url'] = $eventData->url(1);
            $pagination['last_page_url']  = $eventData->url($last_page);
            $pagination['next_page_url']  = !is_null($eventData->nextPageUrl())?$eventData->nextPageUrl():'' ;
            $pagination['prev_page_url']  = !is_null($eventData->previousPageUrl())?$eventData->previousPageUrl():'';
            $pagination['per_page']       = !is_null($eventData->perPage())?$eventData->perPage():'';
            $pagination['from']           = !is_null($eventData->firstItem())?$eventData->firstItem():'';
            $pagination['to']             = !is_null($eventData->lastItem())?$eventData->lastItem():'';
            $pagination['total']          = !is_null($eventData->total())?$eventData->total():'';
            $oData['paginate'] = $pagination;

            if (!$eventData->isEmpty()) {
                $message = 'User past events';
            }else{
                $message    = "User upcoming events not found";
            }
            return $this->getSuccessResult($oData,$message,true);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    
    public function myupcomingEvents() { 
        if (Auth::guard('api')->check()) { 
            $user_id    = Auth::guard('api')->user()->id; 
            $data = $this->event->myliveEvent($user_id);
            $eventData=$data;
            $oData['events'] = array();
            if(!$data->isEmpty()){
            $outputData = array();
                foreach ($data as $key => $value) {
                    $outputData[$key]['event_unique_id']        = (String)$value['event_unique_id'];
                    $outputData[$key]['event_category']         = (String)$value['catname'];
                    $outputData[$key]['event_name']             = (String)$value['event_name'];
                    $outputData[$key]['event_address']          = (String)$value['event_address'];
                    $outputData[$key]['event_start_datetime']   = (String)$value['event_start_datetime'];
                    $outputData[$key]['event_end_datetime']     = (String)$value['event_end_datetime'];
                    $outputData[$key]['event_remaining']        = (String)$value['event_remaining'];
                    $outputData[$key]['EVENT_ORDERD_TICKETS']   = (String)is_null($value->EVENT_ORDERD_TICKETS)?'0':$value->EVENT_ORDERD_TICKETS;
                    $outputData[$key]['EVENT_TOTAL_TICKETS']    = (String)is_null($value->EVENT_TOTAL_TICKETS)?'0':$value->EVENT_TOTAL_TICKETS;
                    
                    $outputData[$key]['event_id']       = (String)$value['event_unique_id'];
                    $outputData[$key]['event_image']    = (String)getImage($value->event_image);
                    $outputData[$key]['id'] = (Int)$value->id;
                    $outputData[$key]['event_location'] = (String)$value->event_location;
                    $outputData[$key]['event_city'] = (String)$value->event_city;
                    $outputData[$key]['event_country'] = (String)$value->event_country;
                }
                $oData['events'] = $outputData;
            }
            /*$last_page = !is_null($eventData->lastPage())?$eventData->lastPage():'';
            $pagination['current_page']   = !is_null($eventData->currentPage())?$eventData->currentPage():'';
            $pagination['last_page']      = $last_page;
            $pagination['per_page']       = !is_null($eventData->perPage())?$eventData->perPage():'';
            $pagination['from']           = !is_null($eventData->firstItem())?$eventData->firstItem():'';
            $pagination['to']             = !is_null($eventData->lastItem())?$eventData->lastItem():'';
            $pagination['total']          = !is_null($eventData->total())?$eventData->total():'';
            $oData['paginate'] = $pagination;*/

            if (!$data->isEmpty()) {
                $message = 'User upcoming events';
            }else{
                $message    = "User upcoming events not found";
            }
            return $this->getSuccessResult($oData,$message,true);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }   
    
    public function checkeventqrcode(Request $request){
        $data = array();
       if (Auth::guard('api')->check()) {
           
            $eventuid=$request->eventid;
            $ticketcode=$request->qrcode;
            $user_id = Auth::guard('api')->user()->id;
            
            if (isset($ticketcode)) {
                $tickcode = orderTickets::where('ot_qr_code',$ticketcode)->first();
                if (is_null($tickcode)) {
                    $data['status'] = '0';
                    $message = 'Ticket invalide';
                    $response = false;
                    return $this->getSuccessResult($data,$message,$response);
                }else{
                    if($tickcode->ot_event_id != $eventuid){
                        $data['status'] = '0';
                        $message = 'ATTENTION ! Ticket n’est pas pour cet événement';
                        $response = false;
                        return $this->getSuccessResult($data,$message,$response);
                    }else{                        
                        if ($tickcode['ot_status'] == 1) {
                            $data['status'] = '0';
                            $message = 'ECHEC ! Ticket déjà scanné';
                            $response = false;
                            return $this->getSuccessResult($data,$message,$response);
                        }
                        else{
                            $tickcode  = orderTickets::where('ot_qr_code',$ticketcode)->update(['ot_status' => '1']);
							$tickcode2  = orderTickets::where('ot_qr_code',$ticketcode)->first();

                            $data['status'] = '1';
                            $message = 'SUCCES ! Ticket scanné avec succès ';
                            $response = true;
                            $data['tickets'] = $tickcode2;
                            return $this->getSuccessResult($data,$message,$response);
                        }   
                    }
                }
            }else{
                $data['status'] = '0';
                $message = 'Ticket invalide';
                $response = false;
                $data['tickets']="";
                return $this->getSuccessResult($data,$message,$response);
            }
       }
    }
    /* User upcoming events for api*/

    /* particular user past event */
    public function pastEvents() {
        if (Auth::guard('api')->check()) {
            $user_id    = Auth::guard('api')->user()->id;
            $eventData = $this->event_book->past_tikcets_events($user_id);
            $oData['events'] = array();
            if(!$eventData->isEmpty()){
                foreach ($eventData as $key => $value) {                    
                    $output[$key]['event_id']       = (String)$value->event_unique_id;
                    $output[$key]['event_name']     = (String)$value->event_name;
                    $output[$key]['event_image']    = (String)getImage($value->event_image);
                    $output[$key]['order_id']       = (String)$value->order_id;
                    $output[$key]['event_location'] = (String)$value->event_location;
                    $output[$key]['event_start_datetime'] = (String)$value->event_start_datetime;
                }
                $oData['events'] = $output;
            }
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
                $message = 'User past events';
            }else{
                $message    = "User past events not found";
            }
            return $this->getSuccessResult($oData,$message,true);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    /* particular user past event */

    /*API For Today Events */
    public function todayEvents(Request $request) {
        if (Auth::guard('api')->check()) {
            $input = $request->all();           
            $category_id = isset($input['category_id'])?$input['category_id']:'';
            $eventData   = $this->event->gettodayevent($category_id);
            $user_id     = Auth::guard('api')->user()->id;
            $book        =  $this->event_save->getBookListeve($user_id);

            $oData['events'] = array();
            if(!$eventData->isEmpty()){
                foreach ($eventData as $key => $value) {
                    $output[$key]['event_id']       = (String)$value->event_unique_id;
                    $output[$key]['event_name']     = (String)$value->event_name;
                    $output[$key]['event_image']    = (String)getImage($value->event_image);
                    $output[$key]['event_location'] = (String)$value->event_location;
                    $output[$key]['event_start_datetime'] = (String)$value->event_start_datetime;
                    if(in_array($value->event_unique_id,$book)){
                        $output[$key]['liked'] = 1;
                    }else{
                        $output[$key]['liked'] = 0;
                    }
                }
            $oData['events'] = $output;
            }
            $last_page = !is_null($eventData->lastPage())?$eventData->lastPage():'';
            $pagination['current_page']   = !is_null($eventData->currentPage())?$eventData->currentPage():'';
            $pagination['last_page']      = $last_page;
            $pagination['first_page_url'] = $eventData->url(1);
            $pagination['last_page_url']  = $eventData->url($last_page);
            $pagination['next_page_url']  = !is_null($eventData->nextPageUrl())?$eventData->nextPageUrl():'' ;
            $pagination['prev_page_url']  = !is_null($eventData->previousPageUrl())?$eventData->previousPageUrl():'';
            $pagination['per_page']       = !is_null($eventData->perPage())?$eventData->perPage():'';
            $pagination['from']           = !is_null($eventData->firstItem())?$eventData->firstItem():'';
            $pagination['to']             = !is_null($eventData->lastItem())?$eventData->lastItem():'';
            $pagination['total']          = !is_null($eventData->total())?$eventData->total():'';
            $oData['paginate'] = $pagination;

            if (!$eventData->isEmpty()) {
                $message = "Today's events";
            }else{
                $message    = "Today's events found";
            }
            return $this->getSuccessResult($oData,$message,true);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    /*API For Today Events */

    /*API for Tomorrow Events*/
    public function tomorrowEvents(Request $request) {
        if (Auth::guard('api')->check()) {
            $input = $request->all();           
            $category_id = isset($input['category_id'])?$input['category_id']:'';
            $eventData   = $this->event->gettomorrowevents($category_id);
            $user_id     = Auth::guard('api')->user()->id;
            $book        =  $this->event_save->getBookListeve($user_id);

            $oData['events'] = array();
            if(!$eventData->isEmpty()){
                foreach ($eventData as $key => $value) {
                    $output[$key]['event_id']       = (String)$value->event_unique_id;
                    $output[$key]['event_name']     = (String)$value->event_name;
                    $output[$key]['event_image']    = (String)getImage($value->event_image);
                    $output[$key]['event_location'] = (String)$value->event_location;
                    $output[$key]['event_start_datetime'] = (String)$value->event_start_datetime;
                    if(in_array($value->event_unique_id,$book)){
                        $output[$key]['liked'] = 1;
                    }else{
                        $output[$key]['liked'] = 0;
                    }
                }
            $oData['events'] = $output;
            }
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
                $message = "Tomorrow's events";
            }else{
                $message    = "Tomorrow's events found";
            }
            return $this->getSuccessResult($oData,$message,true);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    /*API for Tomorrow Events*/

    /*API for Thisweek Events*/
    public function thisweekEvents(Request $request) {
        if (Auth::guard('api')->check()) {
            $input = $request->all();           
            $category_id = isset($input['category_id'])?$input['category_id']:'';
            $eventData   = $this->event->getthisweekevents($category_id);
            $user_id     = Auth::guard('api')->user()->id;
            $book        =  $this->event_save->getBookListeve($user_id);

            $oData['events'] = array();
            if(!$eventData->isEmpty()){
                foreach ($eventData as $key => $value) {
                    $output[$key]['event_id']       = (String)$value->event_unique_id;
                    $output[$key]['event_name']     = (String)$value->event_name;
                    $output[$key]['event_image']    = (String)getImage($value->event_image);
                    $output[$key]['event_location'] = (String)$value->event_location;
                    $output[$key]['event_start_datetime'] = (String)$value->event_start_datetime;
                    if(in_array($value->event_unique_id,$book)){
                        $output[$key]['liked'] = 1;
                    }else{
                        $output[$key]['liked'] = 0;
                    }
                }
                $oData['events'] = $output;
            }
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
                $message = "This week events";
            }else{
                $message    = "This week events found";
            }
            return $this->getSuccessResult($oData,$message,true);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    /*API for Thisweek Events*/
/* ======================================================================================== */
/* ======================================================================================== */
/* ======================================================================================== */
    /* Category List*/
    public function getCategoryList() {
        if (Auth::guard('api')->check()) {
            $user_id     = Auth::guard('api')->user()->id;
            $categoryData = $this->event_category->get_Category_eventAPI();
            $output = array();
            if(!$categoryData->isEmpty()) {
                foreach ($categoryData as $key => $value) {
                    $output[$key]['category_id'] = (String)$value->id;
                    $output[$key]['category_name'] = (String)$value->category_name;
                    $output[$key]['child'] = array();
                    if(!empty($value->children)){
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
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    /* Category List*/
    /* Category Events */
    public function categorywiseevent(Request $request){
        if (Auth::guard('api')->check()) {
            $input = $request->all();           
            $category_id = isset($input['category_id'])?$input['category_id']:'';
            $eventData   = $this->event->getcategorywiseeventapi($category_id);
            $user_id     = Auth::guard('api')->user()->id;
            $book        =  $this->event_save->getBookListeve($user_id);

            $oData['events'] = array();
            if(!$eventData->isEmpty()){
                foreach ($eventData as $key => $value) {
                    $output[$key]['event_id']       = (String)$value->event_unique_id;
                    $output[$key]['event_name']     = (String)$value->event_name;
                    $output[$key]['event_image']    = (String)getImage($value->event_image);
                    $output[$key]['event_location'] = (String)$value->event_location;
                    $output[$key]['event_start_datetime'] = (String)$value->event_start_datetime;
                    if(in_array($value->event_unique_id,$book)){
                        $output[$key]['liked'] = 1;
                    }else{
                        $output[$key]['liked'] = 0;
                    }
                }
                $oData['events'] = $output;
            }
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
                $message = "Category's events";
            }else{
                $message    = "Category's events found";
            }
            return $this->getSuccessResult($oData,$message,true);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    /* Category Events */
/* ======================================================================================== */
/* ======================================================================================== */
/* ======================================================================================== */
    /* Event Bookmark */
    /* particular user saved events for api*/
    public function savedEvents() {
        if (Auth::guard('api')->check()) {
            $user_id    = Auth::guard('api')->user()->id;
            $eventData  = $this->event_save->saved_events($user_id);

            $oData['events'] = array();
            if(!$eventData->isEmpty()){
                foreach ($eventData as $key => $value) {
                    $output[$key]['event_id']       = (String)$value->event_unique_id;
                    $output[$key]['event_name']     = (String)$value->event_name;
                    $output[$key]['event_image']    = (String)getImage($value->event_image);
                    $output[$key]['event_location'] = (String)$value->event_location;
                    $output[$key]['event_start_datetime'] = (String)$value->event_start_datetime;
                }
                $oData['events'] = $output;
            }
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
                $message = "Saved Events";
            }else{
                $message    = "Saved Event not found";
            }
            return $this->getSuccessResult($oData,$message,true);

        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }

    public function savedBookmark(Request $request) {
        if (Auth::guard('api')->check()) {
            $input = $request->all();
            $user_id    = Auth::guard('api')->user()->id;
            $event_id   = $input['event_id'];

            $getData = $this->event_save->getData($event_id,$user_id);
            if(is_null($getData)){
                $insertdata['user_id']  = $user_id;
                $insertdata['event_id'] = $event_id;
                $this->event_save->createData($insertdata);
                $output = array('status' => '1');
                $message = "Event saved successfully.";
            }else{
                $this->event_save->removeData($event_id,$user_id);                
                $output = array('status' => '0');
                $message = "Event removed successfully.";
            }
            return $this->getSuccessResult($output,$message,true);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }    
/* ======================================================================================== */
/* ======================================================================================== */
/* ======================================================================================== */


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
}

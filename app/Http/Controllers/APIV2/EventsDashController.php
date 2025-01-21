<?php

namespace App\Http\Controllers\APIV2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\APIV2\UserController;
use App\ModalAPI\Event;
use App\ModalAPI\orderTickets;
use App\ModalAPI\EventTicket;
use Auth;
use App\ModalAPI\Booking;
use App\ModalAPI\Frontuser;

class EventsDashController extends UserController
{
 	
 	public function __construct()
    {
        $this->event = new Event;
        $this->orderTicket = new orderTickets;
        $this->eventTicket = new EventTicket;
    	$this->booking = new Booking;
    }

    public function liveEvent() {
        if (auth()->check()) {
            $id = Auth::user()->id;
            $data = $this->event->liveEvent($id);
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
            if (empty($outputData)) {
                return $this->getErrorMessage('Events not found!');
            }
            $message = 'Upcoming Events';
            $response = true;
            return $this->getSuccessResult($outputData,$message,$response);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }   
/* ================================================================================= */
    public function pastEvents() {
        if (auth()->check()) {
            $id = Auth::user()->id;
            $data = $this->event->pastEvent($id);
            $outputData = array();
            foreach ($data as $key => $value) {
                $outputData[$key]['event_unique_id']        = (String)$value['event_unique_id'];
                $outputData[$key]['event_category']         = $value['event_category'];
                $outputData[$key]['event_name']             = (String)$value['event_name'];
                $outputData[$key]['event_address']          = (String)$value['event_address'];
                $outputData[$key]['event_start_datetime']   = (String)$value['event_start_datetime'];
                $outputData[$key]['event_end_datetime']     = (String)$value['event_end_datetime'];
                $outputData[$key]['event_remaining']        = $value['event_remaining'];
                $outputData[$key]['EVENT_ORDERD_TICKETS']   = (String)is_null($value->EVENT_ORDERD_TICKETS)?'0':$value->EVENT_ORDERD_TICKETS;
                $outputData[$key]['EVENT_TOTAL_TICKETS']    = (String)is_null($value->EVENT_TOTAL_TICKETS)?'0':$value->EVENT_TOTAL_TICKETS;
            }
            if (empty($outputData)) {
                return $this->getErrorMessage('Events not found!');
            }
            $message = 'Past Events';
            $response = true;
            return $this->getSuccessResult($outputData,$message,$response);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }  
    
    public function myPastEvents() {
        if (Auth::guard('api')->check()) {
            $id = Auth::guard('api')->user()->id; 
            $data = $this->event->myPastEvent($id);
            $outputData = array();
            $oData['events'] = array();
            foreach ($data as $key => $value) {
                $outputData[$key]['event_unique_id']        = (String)$value['event_unique_id'];
                $outputData[$key]['event_category']         = $value['catname'];
                $outputData[$key]['event_name']             = (String)$value['event_name'];
                $outputData[$key]['event_address']          = (String)$value['event_address'];
                $outputData[$key]['event_start_datetime']   = (String)$value['event_start_datetime'];
                $outputData[$key]['event_end_datetime']     = (String)$value['event_end_datetime'];
                $outputData[$key]['event_remaining']        = $value['event_remaining'];
                $outputData[$key]['EVENT_ORDERD_TICKETS']   = (String)is_null($value->EVENT_ORDERD_TICKETS)?'0':$value->EVENT_ORDERD_TICKETS;
                $outputData[$key]['EVENT_TOTAL_TICKETS']    = (String)is_null($value->EVENT_TOTAL_TICKETS)?'0':$value->EVENT_TOTAL_TICKETS;
                
                $outputData[$key]['event_id']       = (String)$value['event_unique_id'];
                $outputData[$key]['event_image']    = (String)getImage($value->event_image);
                $outputData[$key]['id'] = (Int)$value->id;
                $outputData[$key]['event_location'] = (String)$value->event_location;
                $outputData[$key]['event_city'] = (String)$value->event_city;
                $outputData[$key]['event_country'] = (String)$value->event_country;                
            }
            if (empty($outputData)) {
                return $this->getErrorMessage('Events not found!');
            }
            $message = 'Past Events';
            $response = true;
            $oData['events'] = $outputData;
            return $this->getSuccessResult($oData,$message,$response);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
/* ================================================================================= */
    public function eventDashbord($event_id) {
        if (auth()->check()) {
            $data           = array();
            $orderTicket    = array();
            $grossIncome    = array();
            $eventData      = $this->event->eventByUid($event_id);
            if(!is_null($eventData)){
                $event_tickets      = $this->eventTicket->event_total_tickets($event_id);
                $eventOrderTickets  = $this->eventTicket->eventOrderTickets($event_id);
                $totalOrderTickss   = $this->orderTicket->totalOrderTickss($event_id);
                $totalChackInTickss = $this->orderTicket->totalChackInTickss($event_id);

                foreach ($eventOrderTickets as $key => $value) {
                    $chackIn = $value->NUMBER_OF_CHACKIN==null?0:$value->NUMBER_OF_CHACKIN;
                    $total_order = $value->NUMBER_OF_ORDER==null?0:$value->NUMBER_OF_ORDER;
                    $ticket_income = floatval($value->TICKE_PRICE)* intval($total_order);
                    $orderTicket[$key] = array(
                        'TICKE_TITLE'         => (String)$value->TICKE_TITLE,
                        'TICKE_QTY'           => (Integer)$value->TICKE_QTY,
                        'NUMBER_OF_ORDER'     => (Integer)$total_order,
                        'NUMBER_OF_CHACKIN'   => (Integer)$chackIn,
                    );
                    $grossIncome[$key] = $ticket_income; 
                }
                $eventgrossIncome = use_currency()->type.' - '.html_entity_decode(use_currency()->symbol).' '.number_format(array_sum($grossIncome),2);
                $data['event_gross_income']     = (String)$eventgrossIncome;
                $data['event_total_tickets']    = (String)$event_tickets->TOTAL_TICKETS;
                $data['total_order_tickets']    = (String)$totalOrderTickss->TOTAL_ORDER_TICKETS;
                $data['total_chackin_tickets']  = (String)$totalChackInTickss->TOTAL_CHACK_IN;
                $data['event_order_tickets']    = $orderTicket;
            }
            if (!empty($data)) {
                $message = 'Event Dashboard';
                $response = true;
                return $this->getSuccessResult($data,$message,$response);
            }
            return $this->getErrorMessage('Events not found!');
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
/* ================================================================================= */   
    public function orderTickets($event_id) {
        if (auth()->check()) {
            $data = $this->orderTicket->orderTicketsforapi($event_id);
            $data = array_flatten($data);
                
            if (empty($data)) {
                return $this->getErrorMessage('Order not found!');
            }
            $message = 'Event Order List';
            $response = true;
            return $this->getSuccessResult($data,$message,$response);
        }else{
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    
    public function myOrderTicketsScanned($event_id) {
        if (auth()->check()) {
            $data = $this->orderTicket->myOrderTicketsScannedforApi($event_id);
            $data = array_flatten($data);
                       
            if(!empty($data)){
                $outputData = array();
                foreach ($data as $key => $value) {  
                    $outputData[$key]['TICKET_TITLE']         = (String)$value->TICKET_TITLE;
                    $outputData[$key]['TICKET_PRICE']         = (String)$value->TICKET_PRICE;
                    $outputData[$key]['USER_FNAME']          = (String)$value->USER_FNAME;
                    $outputData[$key]['USER_LNAME']          = (String)$value->USER_LNAME;
                    $outputData[$key]['USER_EMAIL']          = (String)$value->USER_EMAIL;
                    $outputData[$key]['id']                  = (String)$value->id;
                    $outputData[$key]['ot_user_id']          = (String)$value->ot_user_id;
                    $outputData[$key]['gust_id']             = (String)$value->gust_id;
                    $outputData[$key]['ot_event_id']         = (String)$value->ot_event_id;
                    $outputData[$key]['ot_order_id']         = (String)$value->ot_order_id;
                    $outputData[$key]['ot_ticket_id']        = (String)$value->ot_ticket_id;    
                    
                    $outputData[$key]['ot_qr_code']          = (String)$value->ot_qr_code;
                    $outputData[$key]['ot_qr_image']         = (String)$value->ot_qr_image;
                    $outputData[$key]['ot_f_name']           = (String)$value->ot_f_name;
                    $outputData[$key]['ot_l_name']           = (String)$value->ot_l_name;  
                    
                    $outputData[$key]['ot_email']            = (String)$value->ot_email;
                    $outputData[$key]['ot_cellphone']        = (String)$value->ot_cellphone;
                    $outputData[$key]['ot_status']           = (String)$value->ot_status;
                    $outputData[$key]['delivred_status']     = (String)$value->delivred_status;                    
 
                    $outputData[$key]['created_at']          = (String)$value->created_at;
                    $outputData[$key]['ORDER_ON']            = (String)$value->ORDER_ON; 
                    
                    $x=unserialize($value->order_t_qty); 
                    $outputData[$key]['order_t_qty']         = $x[0];
                    $outputData[$key]['order_status']        = (String)$value->order_status;
                }
                //$oData['orders'] = $outputData;
                
            }else{
                return $this->getErrorMessage('Order not found!');
            }
            
            $message = 'Event Order List';
            $response = true;
            return $this->getSuccessResult($outputData,$message,$response);
        }else{
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }    
    
    public function userDatas($email){
        if (auth()->check()) {
                    $user = Auth::guard('frontuser')->user();
                    $udata = Frontuser::where('email',$email)->first();

                    $data['id']         = $udata->id;
                    $data['fullname']   = $udata->fullname;
                    $data['email']      = $udata->email;
                    $data['firstname']  = $udata->firstname;
                    $data['lastname']   = $udata->lastname;

                    $data['status']     = $udata->status;
                    $data['cellphone']  = $udata->cellphone;
                    $data['address']    = $udata->address;
                    $data['country']    = $udata->country;
                    
                    $rdate=date_create($udata->created_at);
                    $data['created_at']    = (String)date_format($rdate,'d M, Y  h:i A'); 
                    
                    $profile_pic        = getImage($udata->profile_pic);
                    $data['profile_pic']= $profile_pic;
                    
                    $ev=$this->event->select("*")->where("event_create_by", $udata->id)->count();
                    $data['nbevent'] = $ev;

                    $message = "User Datas";
                    return response()->json(['id' => $data['id'], 'firstname' => $data['firstname'],'lastname' => $data['lastname'],'fullname' => $data['fullname'],
                    'email' => $data['email'], 'profile_pic' => $data['profile_pic'], 'status' => $data['status'],'cellphone' => $data['cellphone'], 'address' => $data['address'], 'country' => $data['country'], 'nbevent'=>$data['nbevent'], 'created_at' => $data['created_at']],$this->successStatus);
        }else{
             $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
    
    public function myOrderTickets($event_id) {
        if (auth()->check()) {
            $oData['orders'] = array();
            $data = $this->orderTicket->myOrderTicketsforApi($event_id);
            $data = array_flatten($data);
           
            if(!empty($data)){
                $outputData = array();
                foreach ($data as $key => $value) {  
                    $outputData[$key]['TICKET_TITLE']         = (String)$value->TICKET_TITLE;
                    $outputData[$key]['TICKET_PRICE']         = (String)$value->TICKET_PRICE;
                    $outputData[$key]['USER_FNAME']          = (String)$value->USER_FNAME;
                    $outputData[$key]['USER_LNAME']          = (String)$value->USER_LNAME;
                    $outputData[$key]['USER_EMAIL']          = (String)$value->USER_EMAIL;
                    $outputData[$key]['id']                  = (String)$value->id;
                    $outputData[$key]['ot_user_id']          = (String)$value->ot_user_id;
                    $outputData[$key]['gust_id']             = (String)$value->gust_id;
                    $outputData[$key]['ot_event_id']         = (String)$value->ot_event_id;
                    $outputData[$key]['ot_order_id']         = (String)$value->ot_order_id;
                    $outputData[$key]['ot_ticket_id']        = (String)$value->ot_ticket_id;    
                    
                    $outputData[$key]['ot_qr_code']          = (String)$value->ot_qr_code;
                    $outputData[$key]['ot_qr_image']         = (String)$value->ot_qr_image;
                    $outputData[$key]['ot_f_name']           = (String)$value->ot_f_name;
                    $outputData[$key]['ot_l_name']           = (String)$value->ot_l_name;  
                    
                    $outputData[$key]['ot_email']            = (String)$value->ot_email;
                    $outputData[$key]['ot_cellphone']        = (String)$value->ot_cellphone;
                    $outputData[$key]['ot_status']           = (String)$value->ot_status;
                    $outputData[$key]['delivred_status']     = (String)$value->delivred_status;                    
 
                    $outputData[$key]['created_at']          = (String)$value->created_at;
                    $outputData[$key]['ORDER_ON']            = (String)$value->ORDER_ON; $x=unserialize($value->order_t_qty); 
                    $outputData[$key]['order_t_qty']         = $x[0];
                    $outputData[$key]['order_status']        = (String)$value->order_status;
                }
                //$oData['orders'] = $outputData;
                
            }else{
                return $this->getErrorMessage('Order not found!');
            }
            
            $message = 'Event Order List';
            $response = true;
            $oData['orders'] = $outputData;
            return $this->getSuccessResult($oData,$message,$response);
        }else{
            $message    = "Events oders tickets infos not found";
            return $this->getErrorMessage($message);
        }
    }    
    
    public function userAllList(){       
       if (auth()->check()) {
            $uid = Auth::user()->id;
            $data = $this->event->select('events.event_name', 'events.event_start_datetime', 
            'event_booking.user_id', 'event_booking.gust_id', 'event_booking.order_t_qty',       'ot_order_id','order_tickets.ot_f_name','order_tickets.ot_l_name','ot_email','events.event_image','order_tickets.ot_cellphone', 'order_tickets.created_at as ORDER_ON')
            ->leftjoin('order_tickets','order_tickets.ot_event_id','=','events.event_unique_id')
            //->leftjoin('order_payment','order_payment.payment_event_id','=','events.event_unique_id')
            ->leftjoin('event_booking','event_booking.event_id','=','events.event_unique_id')
            ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
            ->where('events.event_create_by',$uid)
            ->where('event_booking.order_status',1)
            ->groupBy('event_booking.order_id')
            ->orderBy('event_booking.created_at','desc')
            ->paginate(25);
           
            $data = array_flatten($data);
            $outputData = array();
            /**/
            if(!empty($data)){
                 
                foreach ($data as $key => $value) {  
                    $outputData[$key]['event_name']         = (String)$value->event_name;
                    
                    $rdate=date_create($value->event_start_datetime);                    
                    $outputData[$key]['event_start_datetime']         = (String)date_format($rdate,'d M, Y'); 
                    $outputData[$key]['user_id']          = (String)$value->user_id;
                    $outputData[$key]['gust_id']          = (String)$value->gust_id;
                    $x=unserialize($value->order_t_qty); 
                    $outputData[$key]['order_t_qty']          = $x[0];
                    $outputData[$key]['ot_order_id']           = (String)$value->ot_order_id;
                    $outputData[$key]['ot_f_name']          = (String)$value->ot_f_name;
                    $outputData[$key]['ot_l_name']             = (String)$value->ot_l_name;
                    $outputData[$key]['ot_email']         = (String)$value->ot_email;
                    $outputData[$key]['payment_gateway']         = (String)$value->payment_gateway;
                    $outputData[$key]['event_image']        = (String)getImage($value->event_image);
                    
                    $outputData[$key]['ot_cellphone']          = (String)$value->ot_cellphone;
                   
                    $rdate2=date_create($value->ORDER_ON);
                    $outputData[$key]['ORDER_ON'] = (String)date_format($rdate2,'d M, Y'); 
                }
                 
            }else{
                return $this->getErrorMessage('Contact not found!');
            }
            
            $message = 'Contact Attendee List';
            $response = true;
            return $this->getSuccessResult($outputData,$message,$response);
        }else{
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    
    }
    
    public function myOrderTicketsDetails($orderid) {
        if (auth()->check()) {
            $oData['orders'] = array();
            $data = $this->orderTicket->myOrderTicketsDetailsforApi($orderid);
            $data = array_flatten($data);
           
            if(!empty($data)){
                $outputData = array();
                foreach ($data as $key => $value) {  
                    $outputData[$key]['TICKET_TITLE']         = (String)$value->TICKET_TITLE;
                    $outputData[$key]['TICKET_PRICE']         = (String)$value->TICKET_PRICE;
                    $outputData[$key]['USER_FNAME']          = (String)$value->USER_FNAME;
                    $outputData[$key]['USER_LNAME']          = (String)$value->USER_LNAME;
                    $outputData[$key]['USER_EMAIL']          = (String)$value->USER_EMAIL;
                    $outputData[$key]['id']                  = (String)$value->id;
                    $outputData[$key]['ot_user_id']          = (String)$value->ot_user_id;
                    $outputData[$key]['gust_id']             = (String)$value->gust_id;
                    $outputData[$key]['ot_event_id']         = (String)$value->ot_event_id;
                    $outputData[$key]['ot_order_id']         = (String)$value->ot_order_id;
                    $outputData[$key]['ot_ticket_id']        = (String)$value->ot_ticket_id;    
                    
                    $outputData[$key]['ot_qr_code']          = (String)$value->ot_qr_code;
                    $outputData[$key]['ot_qr_image']         = (String)$value->ot_qr_image;
                    $outputData[$key]['ot_f_name']           = (String)$value->ot_f_name;
                    $outputData[$key]['ot_l_name']           = (String)$value->ot_l_name;  
                    
                    $outputData[$key]['ot_email']            = (String)$value->ot_email;
                    $outputData[$key]['ot_cellphone']        = (String)$value->ot_cellphone;
                    $outputData[$key]['ot_status']           = (String)$value->ot_status;
                    $outputData[$key]['delivred_status']     = (String)$value->delivred_status;                    
 
                    $outputData[$key]['created_at']          = (String)$value->created_at;
                    $rdate=date_create($value->ORDER_ON);
                    $outputData[$key]['ORDER_ON']            = (String)date_format($rdate,'d M, Y  h:i A'); 
                    $x=unserialize($value->order_t_qty); 
                    $outputData[$key]['order_t_qty']         = $x[0];
                    $outputData[$key]['order_status']        = (String)$value->order_status;
                }
                //$oData['orders'] = $outputData;
                
            }else{
                return $this->getErrorMessage('Order not found!'.$orderid);
            }
            
            $message = 'Event Order Details';
            $response = true;
            $oData['orders'] = $outputData;
            return $this->getSuccessResult($oData,$message,$response);
        }else{
            $message    = "Events oders tickets infos not found";
            return $this->getErrorMessage($message);
        }
    }        
    
   public function  eventAttendee($eventid){
       
       if (auth()->check()) {
            $data = $this->booking->contactDetailAttends($eventid);
             $data = array_flatten($data);
            /**/
            if(!empty($data)){
                $outputData = array();
                foreach ($data as $key => $value) {  
                    $outputData[$key]['id']         = (String)$value->id;
                    $outputData[$key]['event_id']         = (String)$value->event_id;
                    $outputData[$key]['user_id']          = (String)$value->user_id;
                    $outputData[$key]['gust_id']          = (String)$value->gust_id;
                    $outputData[$key]['ot_f_name']           = (String)$value->ot_f_name;
                    $outputData[$key]['ot_l_name']          = (String)$value->ot_l_name;
                    $outputData[$key]['ot_email']             = (String)$value->ot_email;
                    $outputData[$key]['ot_cellphone']             = (String)$value->ot_cellphone;
                    
                    $profile_pic = getImage($value->profile_pic);
             
                    $outputData[$key]['profile_pic'] = (String)$profile_pic;
                }
                 
            }else{
                return $this->getErrorMessage('Contact not found!');
            }
            
            $message = 'Contact Attendee List';
            $response = true;
            return $this->getSuccessResult($outputData,$message,$response);
        }else{
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
       
      
   }
/* ================================================================================= */
    public function ticketCode($ticketcode,$eventuid) {
        $data = array();
        if (auth()->check()) {  
            if (isset($ticketcode)) {
                $tickcode  = orderTickets::where('ot_qr_code',$ticketcode)->first();
                if (is_null($tickcode)) {
                    $data['status'] = '0';
                    $message = 'Your Request is not Existes.';
                    $response = false;
                    return $this->getSuccessResult($data,$message,$response);
                }else{
                    if($tickcode->ot_event_id != $eventuid ){
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
                            $data['status'] = '1';
                            $message = 'SUCCES ! Ticket scanné avec succès ';
                            $response = true;
                            return $this->getSuccessResult($data,$message,$response);
                        }   
                    }
                }
            }
        }else{
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }


    
    
    //Event List
    public function eventlist() {

        if (auth()->check()) {

            $id = Auth::user()->id;
            $data = $this->event->selectData();
            $data = array_flatten($data);
            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            return response()->json($this->getSuccessResult($data),200);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }

    }
    
}


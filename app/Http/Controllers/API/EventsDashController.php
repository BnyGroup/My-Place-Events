<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;
use App\ModalAPI\Event;
use App\ModalAPI\orderTickets;
use App\ModalAPI\EventTicket;
use Auth;

class EventsDashController extends UserController
{
 	
 	public function __construct()
    {
        $this->event = new Event;
        $this->orderTicket = new orderTickets;
        $this->eventTicket = new EventTicket;
    }

    public function liveEvent() {

        if (auth()->check()) {

            $id = Auth::user()->id;
            $data = $this->event->liveEvent($id);
            
            foreach ($data as $key => $value) {
                if($value['EVENT_ORDERD_TICKETS'] == null){                    
                    $data[$key]['EVENT_ORDERD_TICKETS'] = 0;
                }else{
                    $data[$key]['EVENT_ORDERD_TICKETS'] = $value['EVENT_ORDERD_TICKETS'];
                }
            }
            $data = array_flatten($data);
            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            return response()->json($this->getSuccessResult($data),200);

        } else {

            return response()->json($this->getErrorMessage('462'));
        }

    }

 	public function pastEvents()
 	{
        if (auth()->check()) {

            $id = Auth::user()->id;
            $data = $this->event->pastEvent($id);

            $datas = array();
            foreach ($data as $key => $value) {
                $datas = $value;
                $datas['EVENT_ORDERD_TICKETS'] = is_null($value->EVENT_ORDERD_TICKETS)?0:$value->EVENT_ORDERD_TICKETS;
                $datas['EVENT_TOTAL_TICKETS'] = is_null($value->EVENT_TOTAL_TICKETS)?0:$value->EVENT_TOTAL_TICKETS;
            }
            $data = array_flatten($data);
            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }

            return response()->json($this->getSuccessResult($data),200);

        } else {

            return response()->json($this->getErrorMessage('462'));
        }
 	}  

    public function eventDash($event_id)
    {
        if (auth()->check()) {
            //$id = Auth::user()->id;
            //$event_data = $this->event->eventByUid($event_id);

            $event_tickets = $this->eventTicket->event_total_tickets($event_id);
            $eventOrderTickets = $this->eventTicket->eventOrderTickets($event_id);
            
            $totalOrderTickss = $this->orderTicket->totalOrderTickss($event_id);
            $totalChackInTickss = $this->orderTicket->totalChackInTickss($event_id);

           
            //$chackdInTickets = $this->eventTicket->chackdInTickets($event_id);
            $orderTicket = array();
            $grossIncome = array();
           
            foreach ($eventOrderTickets as $key => $value) {
                $chackIn = $value->NUMBER_OF_CHACKIN==null?0:$value->NUMBER_OF_CHACKIN;
                $total_order = $value->NUMBER_OF_ORDER==null?0:$value->NUMBER_OF_ORDER;

                $ticket_income = floatval($value->TICKE_PRICE)* intval($total_order);

                $orderTicket[$key] = array(
                    'TICKE_TITLE'         => $value->TICKE_TITLE,
                    'TICKE_QTY'           => $value->TICKE_QTY,
                    'NUMBER_OF_ORDER'     => $total_order,
                    'NUMBER_OF_CHACKIN'   => $chackIn,
                );
                $grossIncome[$key] = $ticket_income; 
            }
            
            $eventgrossIncome = use_currency()->type.' - '.html_entity_decode(use_currency()->symbol).' '.number_format(array_sum($grossIncome),2);
         

            $data['event_gross_income'] = $eventgrossIncome;
            $data['event_total_tickets'] = $event_tickets->TOTAL_TICKETS;
            $data['total_order_tickets'] = $totalOrderTickss->TOTAL_ORDER_TICKETS;
            $data['total_chackin_tickets'] = $totalChackInTickss->TOTAL_CHACK_IN;
            $data['event_order_tickets'] = $orderTicket;
            

            


            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            return response()->json($this->getSuccessResult($data),200);

        } else {

            return response()->json($this->getErrorMessage('462'));
        }
        
    }

    public function orderTickets($event_id)
    {
        if (auth()->check()) {
            // $id = Auth::user()->id;
            $data = $this->orderTicket->orderTicketsforapi($event_id);
            $data = array_flatten($data);
           
            if (empty($data)) {
                return response()->json(['status' => ['code' => 108 ,'msg' => 'Event order not booked.']]);
            }
            return response()->json($this->getSuccessResult($data),200);

        }
        return response()->json($this->getErrorMessage('462'));
    }

    public function ticketCode($ticketcode,$eventuid)
    {
        if (auth()->check()) {  
            if (isset($ticketcode)) {
                $tickcode  = orderTickets::where('ot_qr_code',$ticketcode)->first();

                if (is_null($tickcode)) {
                    return response()->json(['status' => ['code' => 108 ,'msg' => 'Your Request is not Existes.']]);
                }else{
                    if($tickcode->ot_event_id != $eventuid ){
                        return response()->json(['status' => ['code' => 108 ,'msg' => 'This ticktes not for this event.']]);
                    }else{                        
                        if ($tickcode['ot_status'] == 1) {
                            return response()->json(['status' => ['code' => 108 ,'msg' => 'You are already Checked In.']]);
                        }
                        else{
                            $tickcode  = orderTickets::where('ot_qr_code',$ticketcode)->update(['ot_status' => '1']);
                            return response()->json(['status' => ['code' => 200 ,'msg' => 'You are Check In Successfully.']],200);
                        }   
                    }
                }
            }
        }
        return response()->json($this->getErrorMessage('462'));
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

            return response()->json($this->getErrorMessage('462'));
        }

    }
    
}


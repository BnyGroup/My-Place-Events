<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\EventCategory;
use App\Event;
use App\EventTicket;
use App\Organization;
use App\Booking;
use App\orderTickets;
use App\orderPayment;
use App\Refund;
use Carbon\Carbon;
use Illuminate\Routing\RouteCollection;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use Illuminate\Support\Facades\Input;

class OrderController extends FrontController {
    public function __construct() {
    	parent::__construct();
    	$this->event = new Event;
        $this->refund = new Refund;
    	$this->event_ticket = new EventTicket;
    	$this->event_category = new EventCategory;
    	$this->organization = new Organization;
    	$this->ticket_booking = new Booking;
    	$this->order_tickets = new orderTickets;
    	$this->order_payment = new orderPayment;
	}
    public function orderList() {
		$bookingdata = $this->ticket_booking->getOrder();
	}
	public function orderView($order_id) {
		$bookingdata = $this->ticket_booking->getOrderData($order_id);
        $refund = $this->refund->finData($order_id);
		return view('theme.booking.view-order',compact('bookingdata','refund'));
	}


    public function sessionOrder() {
//        $session_orderId = $this->session::get('order_id');
        $session_orderId = \Session::get('order_id');
         
        $response = array();
        if(is_array($session_orderId) && !empty($session_orderId)){
            foreach ($session_orderId as $order_key => $ord_id) {
                $bookingdata    = $this->ticket_booking->getOrderData($ord_id);
                //dd($bookingdata);
                if($bookingdata!=null){
    //                $orderSessionTime = (strtotime($bookingdata->BOOKING_ON) + env('BOOKING_TIME', '900')) * 1000;
                    $orderSessionTime = (strtotime(gmdate('Y-m-d H:i:s')) + env('BOOKING_TIME', '900')) * 1000;
                    $orderProcessingTime = $orderSessionTime + env('BOOKING_PROCESSING_TIME', '600') * 1000;
                    $delay = 60 * 1000;

                    if($orderSessionTime + $delay < time()*1000 ){
                        if($bookingdata['order_status'] == 0){

                            $order_ticket_id    = unserialize($bookingdata['order_t_id']);
                            $order_ticket_qty   = unserialize($bookingdata['order_t_qty']);

                            // foreach ($order_ticket_id as $key => $value) {
                            //     $ticket_update = $this->event_ticket->incres_ticket_qty($value,$order_ticket_qty[$key]);
                            // }

                            /*
                            if ($order_ticket_id) {
                               foreach ($order_ticket_id as $key => $value) {
                                $ticket_update = $this->event_ticket->incres_ticket_qty($value,$order_ticket_qty[$key]);
                                }
                            }
                            */

                            $input['client_token']  = str_shuffle(csrf_token());
                            $input['order_status']  = '2';
                            $this->ticket_booking->updateData($input,$ord_id);
                            $this->order_tickets->deleteOrder($ord_id);

                            \session::forget('order_id.' . $order_key);

                            $response[] = $ord_id.' - This order is cancled.';
                        }

                        if ($bookingdata['order_status'] == 5 && $orderProcessingTime < time()*1000) {
                            $input['client_token']  = str_shuffle(csrf_token());
                            $input['order_status']  = '2';
                            $this->ticket_booking->updateData($input,$ord_id);
                            $this->order_tickets->deleteOrder($ord_id);

                            \session::forget('order_id.' . $order_key);

                            $response[] = $ord_id.' - This order is cancled.';
                        }
                    }
                    else{
                       // $response[] = $ord_id.' - This order is process.';
                    }
                }
            }
        }else{
            $response[] = 'Sorry no any booking available';
        }
        return response()->json($response);
    }

    public function removeUserSessionOrder()
    {
        $bookingdata    = $this->ticket_booking->getUserPandingOrder();
        if(is_array($bookingdata) && !empty($bookingdata)){
            foreach ($bookingdata as $order_id) {
                //$orderSessionTime = (strtotime($order_id['BOOKING_ON']) + env('BOOKING_TIME', '600')) * 1000;
                //if($orderSessionTime < time()*1000 ){
                    $order_ticket_id    = unserialize($order_id['order_t_id']);
                    $order_ticket_qty   = unserialize($order_id['order_t_qty']);
                    foreach ($order_ticket_id as $key => $value) {
                        $ticket_update = $this->event_ticket->incres_ticket_qty($value,$order_ticket_qty[$key]);
                    }
                    $input['client_token']  = str_shuffle($order_id['client_token']);
                    $input['order_status']  = '2';
                    $this->ticket_booking->updateData($input,$order_id['order_id']);
                    $this->order_tickets->deleteOrder($order_id['order_id']);
                //}
                //$session_orderId = $this->session::get('order_id');
                //$orderKey = array_search($order_id['order_id'], $session_orderId);
                //$this->session::forget('order_id.' . $orderKey);
            }
        }
    }

    

    public function removeCancleOrder()
    {
        $bookingdata    = $this->ticket_booking->getPandingOrder();
        if(is_array($bookingdata) && !empty($bookingdata)){
            foreach ($bookingdata as $order_id) {
                $orderSessionTime = (strtotime($order_id['BOOKING_ON']) + env('BOOKING_TIME', '600')) * 1000;
                if($orderSessionTime < time()*1000 ){
                    $order_ticket_id    = unserialize($order_id['order_t_id']);
                    $order_ticket_qty   = unserialize($order_id['order_t_qty']);
                    foreach ($order_ticket_id as $key => $value) {
                        $ticket_update = $this->event_ticket->incres_ticket_qty($value,$order_ticket_qty[$key]);
                    }
                    $input['client_token']  = str_shuffle($order_id['client_token']);
                    $input['order_status']  = '2';
                    $this->ticket_booking->updateData($input,$order_id['order_id']);
                    $this->order_tickets->deleteOrder($order_id['order_id']);
                }
                /*$session_orderId = $this->session::get('order_id');*/
                $session_orderId = \Session::get('order_id');
                if(is_array($session_orderId) && !empty($session_orderId)){
                    $orderKey = array_search($order_id['order_id'], $session_orderId);
//                    $this->session::forget('order_id.'.$orderKey);
                    \Session::forget('order_id.'.$orderKey);
                }
                
            }
        }
    }

    // public function removeCancleOrder()
    // {
    //     $bookingdata    = $this->ticket_booking->getPandingOrder();
    //     if(is_array($bookingdata) && !empty($bookingdata)){
    //         foreach ($bookingdata as $order_id) {
    //             $order_ticket_id    = unserialize($order_id['order_t_id']);
    //             $order_ticket_qty   = unserialize($order_id['order_t_qty']);
    //             foreach ($order_ticket_id as $key => $value) {
    //                 $ticket_update = $this->event_ticket->incres_ticket_qty($value,$order_ticket_qty[$key]);
    //             }
    //             $input['client_token']  = str_shuffle($order_id['client_token']);
    //             $input['order_status']  = '2';
    //             $this->ticket_booking->updateData($input,$order_id['order_id']);
    //             $this->order_tickets->deleteOrder($order_id['order_id']);
    //             /*$session_orderId = $this->session::get('order_id');*/
    //             $session_orderId = \Session::get('order_id');
    //             if(is_array($session_orderId) && !empty($session_orderId)){
    //                 $orderKey = array_search($order_id['order_id'], $session_orderId);
    // //                    $this->session::forget('order_id.'.$orderKey);
    //                 \Session::forget('order_id.'.$orderKey);
    //             }
    //         }
    //     }
    // }

    public function revmoveOrder($order_id) {
        /*$session_orderId = $this->session::get('order_id');*/
        $session_orderId = \Session::get('order_id');
        $key = array_search($order_id, $session_orderId);
        /*$this->session::forget('order_id.' . $key);*/
        \Session::forget('order_id.' . $key);
        echo $order_id;
        /*return redirect()->route('order.cancel',$bookingdata->order_id);*/
        // return redirect()->route('order.cancel',$order_id);
    }

    public function livraison(){

    }
}

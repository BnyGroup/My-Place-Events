<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Event;
use App\Booking;
use App\EventTicket;
use App\orderTickets;

class EventManageController extends AdminController
{
    public function __construct() {
    	parent::__construct();
        $this->events  = new  Event; 
    	$this->booking  = new  Booking; 
        $this->event_ticket  = new  EventTicket; 
        $this->orderTickets  = new  orderTickets; 
    }

    public function events_list($id)
    {	
    	$data = $this->events->orgWiseEvents($id);
    	return view('Admin.soldearning.eventslist',compact('data'));
    }

    public function order_erniing($event_id)
    {        
        $data = $this->booking->getOrderEvents($event_id);
        //dd($data);
    	return view('Admin.soldearning.order',compact('data'));
    }
    public function manageEventDashboard($id)
    {
        $event = Event::where('event_unique_id',$id)->first();
        $event_tickets = $this->event_ticket->event_total_tickets($id);
        $eventOrderTickets = $this->event_ticket->eventOrderTickets($id);
        $totalOrderTickss = $this->orderTickets->totalOrderTickss($id);
        $totalChackInTickss = $this->orderTickets->totalChackInTickss($id);
        $tickets = EventTicket::where('event_id', $id)->get();
        return view('Admin.soldearning.manageEvent',compact('event','event_tickets','eventOrderTickets','totalOrderTickss','totalChackInTickss','tickets'));
    }
}

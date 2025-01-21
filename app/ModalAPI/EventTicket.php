<?php

namespace App\ModalAPI;

use DB;
use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    protected $table = 'event_tickets';
 	protected $fillable = [
        'ticket_id', 'event_id', 'ticket_title', 'ticket_description', 'ticket_desc_status', 'ticket_qty', 'ticket_remaning_qty',
        'ticket_type', 'ticket_status', 'ticket_services_fee', 'ticket_price_buyer', 'ticket_price_actual', 'ticket_commission'
     ];

    /*============================ API DATA ==========================*/
    public function ticket_by_id($id)
    {
        return static::where("ticket_id",$id)->first();
    }

    public function incres_ticket_qty($id, $input)
    {
        return static::where('ticket_id',$id)->increment('ticket_remaning_qty', $input);
    }

    public function getsingle_event_ticket($event_id)
    {
        return static::select('event_tickets.ticket_title','event_tickets.ticket_description','ticket_remaning_qty','event_tickets.ticket_price_buyer','event_tickets.ticket_type','event_tickets.ticket_qty','event_tickets.ticket_id')
            ->where('event_tickets.event_id',$event_id)
            ->get();
    }

    public function event_total_tickets($event_id){
        return static::select(DB::raw('sum(ticket_qty) as TOTAL_TICKETS'))
            ->where('event_id',$event_id)->first();
    }

      public function eventOrderTickets($event_id)
    {
        return static::select('event_tickets.ticket_title as TICKE_TITLE','event_tickets.ticket_price_buyer as TICKE_PRICE','event_tickets.ticket_qty as TICKE_QTY','event_tickets.event_id as eid','ticket_remaning_qty','ticket_id','event_tickets.id','event_tickets.ticket_price_actual as TICKE_PRICE_ACTUAL',
                        DB::raw("(SELECT COUNT(order_tickets.ot_ticket_id) FROM order_tickets
                        WHERE order_tickets.ot_ticket_id = event_tickets.ticket_id AND event_tickets.event_id=order_tickets.ot_event_id AND event_tickets.event_id='$event_id' AND order_tickets.delivred_status=1
                        GROUP BY order_tickets.ot_ticket_id) as NUMBER_OF_ORDER"),
                        DB::raw("(SELECT COUNT(order_tickets.ot_ticket_id) FROM order_tickets
                        WHERE order_tickets.ot_ticket_id = event_tickets.ticket_id AND order_tickets.ot_status = 1
                        GROUP BY order_tickets.ot_ticket_id) as NUMBER_OF_CHACKIN"))
            ->where('event_tickets.event_id',$event_id)->get();
    }
    
    /*============================ API DATA ==========================*/

}

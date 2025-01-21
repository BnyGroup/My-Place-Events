<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class orderTickets extends Model
{
    protected $table = 'order_tickets';
 	protected $fillable = [ 'ot_user_id','gust_id','ot_event_id','ot_order_id','ot_ticket_id','ot_qr_code','ot_qr_image','ot_f_name','ot_l_name','ot_email' ];

    /*============================ API DATA ==========================*/

 	public function insertData($input) {
    	return static::create(array_only($input,$this->fillable));
    }

    public function orderTickets($order_id){

    	return static::select('events.*','event_tickets.ticket_title as TICKE_TITLE','event_tickets.ticket_price_buyer as TICKE_PRICE', 'frontusers.firstname as USER_FNAME', 'frontusers.lastname as USER_LNAME', 'frontusers.email as USER_EMAIL', 'order_tickets.*' ,'order_tickets.created_at as ORDER_ON')            
            ->leftjoin('event_tickets','order_tickets.ot_ticket_id','=','event_tickets.ticket_id')
            ->leftjoin('events','order_tickets.ot_event_id','=','events.event_unique_id')
            ->leftjoin('frontusers','order_tickets.ot_user_id','=','frontusers.id')
            ->where('order_tickets.ot_order_id',$order_id)
            ->where('order_tickets.delivred_status',1)
            ->get();
    }

    public function deleteOrder($order_id) {
        $get_image = static::select('order_tickets.ot_qr_image')->where('ot_order_id',$order_id)->get()->toarray();
        $path = 'upload/ticket-qr/';
        foreach ($get_image as $image) {
            if(isset($image['ot_qr_image']) && $image['ot_qr_image'] != ''){
                if(File::exists(public_path($path))){
                    File::delete(public_path($path.$image['ot_qr_image']));
                }
            }
        }
        return static::where('ot_order_id',$order_id)->delete();
    }

    public function userWiseOrd($id)
    { 
          return static::select('order_tickets.ot_order_id','order_tickets.ot_ticket_id','order_tickets.ot_qr_code','order_tickets.ot_qr_image',
            'order_tickets.ot_f_name','order_tickets.ot_l_name','order_tickets.ot_email',
            'event_name','event_start_datetime','event_end_datetime','event_org_name','event_description','event_location',
            'event_tickets.ticket_title','event_tickets.ticket_description')
            ->leftjoin('events','events.event_unique_id','=','order_tickets.ot_event_id')
            ->leftjoin('event_tickets','event_tickets.ticket_id','=','order_tickets.ot_ticket_id')
            ->where('ot_order_id',$id)
			 ->where('order_tickets.delivred_status',1) 
            /*->where('ot_status',0)*/
            ->get();
    }

    public function totalOrderTickss($event_id)
    {
        return static::select(DB::raw('count(id) as TOTAL_ORDER_TICKETS'))
            ->where('ot_event_id',$event_id)
			->where('order_tickets.delivred_status',1)
			->first();
    }

    public function totalChackInTickss($event_id)
    {
        return static::select(DB::raw('count(id) as TOTAL_CHACK_IN'))
            ->where('ot_status', 1)
            ->where('ot_event_id',$event_id)->first();
    }

    public function orderTicketsforapi($event_id){
        return static::select('event_tickets.ticket_title as TICKE_TITLE','order_tickets.ot_order_id','order_tickets.ot_ticket_id','order_tickets.ot_qr_code','order_tickets.ot_f_name','order_tickets.ot_l_name','order_tickets.ot_email','order_tickets.ot_status','order_tickets.created_at as ORDER_ON')
            ->join('event_tickets','order_tickets.ot_ticket_id','=','event_tickets.ticket_id')
            ->join('events','order_tickets.ot_event_id','=','events.event_unique_id')
            ->join('frontusers','order_tickets.ot_user_id','=','frontusers.id')
            ->where('order_tickets.ot_event_id',$event_id)
			->where('order_tickets.delivred_status',1)
			->get();
    }
    
    public function myOrderTicketsforApi($event_id){
        /*return static::select('event_tickets.ticket_title as TICKE_TITLE','order_tickets.ot_order_id','order_tickets.ot_ticket_id','order_tickets.ot_qr_code','order_tickets.ot_f_name','order_tickets.ot_l_name','order_tickets.ot_email','order_tickets.ot_status','order_tickets.created_at as ORDER_ON')
            ->join('event_tickets','order_tickets.ot_ticket_id','=','event_tickets.ticket_id')
            ->join('events','order_tickets.ot_event_id','=','events.event_unique_id')
            ->join('frontusers','order_tickets.ot_user_id','=','frontusers.id')
            ->where('order_tickets.ot_event_id',$event_id)
			->where('order_tickets.delivred_status',1)
			->get();*/
        
         return DB::table("order_tickets")->select('event_tickets.ticket_title as TICKET_TITLE','event_tickets.ticket_price_buyer as TICKET_PRICE', 'frontusers.firstname as USER_FNAME', 'frontusers.lastname as USER_LNAME', 'frontusers.email as USER_EMAIL', 'order_tickets.*' ,'order_tickets.created_at as ORDER_ON','event_booking.order_t_qty',
            'event_booking.order_status as order_status')
            ->leftjoin('event_tickets','order_tickets.ot_ticket_id','=','event_tickets.ticket_id')
            ->leftjoin('events','order_tickets.ot_event_id','=','events.event_unique_id')
            ->leftjoin('frontusers','order_tickets.ot_user_id','=','frontusers.id')
            ->leftjoin('event_booking','event_booking.order_id','=','order_tickets.ot_order_id')
            ->where('order_tickets.ot_event_id',$event_id)
			->where('event_booking.order_status',1)
	        ->where('order_tickets.delivred_status',1)
            ->get();
    }    

    public function myOrderTicketsScannedforApi($event_id){
 
         return DB::table("order_tickets")->select('event_tickets.ticket_title as TICKET_TITLE','event_tickets.ticket_price_buyer as TICKET_PRICE', 'frontusers.firstname as USER_FNAME', 'frontusers.lastname as USER_LNAME', 'frontusers.email as USER_EMAIL', 'order_tickets.*' ,'order_tickets.created_at as ORDER_ON','event_booking.order_t_qty',
            'event_booking.order_status as order_status')
            ->leftjoin('event_tickets','order_tickets.ot_ticket_id','=','event_tickets.ticket_id')
            ->leftjoin('events','order_tickets.ot_event_id','=','events.event_unique_id')
            ->leftjoin('frontusers','order_tickets.ot_user_id','=','frontusers.id')
            ->leftjoin('event_booking','event_booking.order_id','=','order_tickets.ot_order_id')
            ->where('order_tickets.ot_event_id',$event_id)
			->where('event_booking.order_status',1)
	        ->where('order_tickets.delivred_status',1)
            ->where('order_tickets.ot_status', 1)
            ->get();
        
    }     
    
    public function myOrderTicketsDetailsforApi($orderid){
         
         return DB::table("order_tickets")->select('event_tickets.ticket_title as TICKET_TITLE','event_tickets.ticket_price_buyer as TICKET_PRICE', 'frontusers.firstname as USER_FNAME', 'frontusers.lastname as USER_LNAME', 'frontusers.email as USER_EMAIL', 'order_tickets.*' ,'order_tickets.created_at as ORDER_ON','event_booking.order_t_qty',
            'event_booking.order_status as order_status')
            ->leftjoin('event_tickets','order_tickets.ot_ticket_id','=','event_tickets.ticket_id')
            ->leftjoin('events','order_tickets.ot_event_id','=','events.event_unique_id')
            ->leftjoin('frontusers','order_tickets.ot_user_id','=','frontusers.id')
            ->leftjoin('event_booking','event_booking.order_id','=','order_tickets.ot_order_id')
            ->where('order_tickets.ot_order_id',$orderid)
			->where('event_booking.order_status',1)
	        ->where('order_tickets.delivred_status',1)
            ->get();
    }  
    
    /*============================ API DATA ==========================*/

}

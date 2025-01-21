<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Booking extends Model
{
    protected $table = 'event_booking';
 	protected $fillable = [
        'event_id', 'user_id', 'order_id', 
        'order_tickets', 'order_amount','gust_id','order_status', 'order_commission',
        'order_t_id', 'order_t_title', 'order_t_qty', 'order_t_price', 'order_t_fees', 'order_t_commission', 
        'client_token','manual_attend_vendor'
    ];

    /*============================ API DATA ==========================*/
    public function insertData($input) {
    	return static::create(array_only($input,$this->fillable));
    }

    public function getDataAPI($token){
        return static::select('event_booking.*','events.event_name','event_booking.created_at as BOOKING_ON','organizations.organizer_name','events.event_start_datetime','events.event_end_datetime')
            ->join('events','event_booking.event_id','=','events.event_unique_id')
            ->join('organizations','organizations.id','=','events.event_org_name')
            ->where('client_token',$token)->first();
    }

    public function getOrderData($booking_id) {
        return static::select('event_booking.*','events.*','event_booking.updated_at as upat','organizations.url_slug as org_slug', 'organizations.organizer_name as org_name', 'frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as user_email', 'event_booking.created_at as BOOKING_ON','order_tickets.ot_email')
            ->leftjoin('events','event_booking.event_id','=','events.event_unique_id')
            ->leftjoin('organizations','organizations.id','=','events.event_org_name')
            ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
            ->leftjoin('order_tickets', function ($join) {
                $join->on('order_tickets.ot_order_id', '=', 'event_booking.order_id')
                    ->whereNotNull('event_booking.gust_id')
                    ->groupBy('order_tickets.ot_order_id');
            })
            ->where('order_id',$booking_id)
            ->first();
    }

    public function updateData($input,$orderId){

        return static::where('order_id',$orderId)->update(array_only($input,$this->fillable));
    }

    public function bookTheevents($id)
    {
        $start  = \Carbon\Carbon::now();
        return static::select('event_booking.order_id','events.event_unique_id','events.event_name','events.event_start_datetime','events.event_location','events.event_name','event_image','order_tickets')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->where('event_booking.user_id',$id)
            ->where('event_booking.order_status',1)
            ->where('events.event_start_datetime','>=', $start)
            ->orderBy('event_start_datetime','asc')
            ->limit(5)
            ->get();
            // ->appends(request()->query());
    }

    public function pastEventsByApi($id)
   {
       $start  = \Carbon\Carbon::now();
        return static::select('event_booking.order_id','events.event_unique_id','events.event_name','events.event_start_datetime','events.event_location','events.event_name','event_image','order_tickets')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->where('event_booking.user_id',$id)
            ->where('event_booking.order_status',1)
            ->where('events.event_start_datetime','<', $start)
            ->orderBy('event_start_datetime','desc')            
            ->limit(5)
            ->get();
   }

   /* Booking Upcoming Events */

    public function upcoming_tikcets_events($user_id) {
        $datas= Carbon::now();
        return static::select('event_booking.user_id','event_booking.order_id','event_booking.order_tickets',
            'event_category.category_name',
            'events.event_unique_id','events.event_name','events.event_location',
            'events.event_start_datetime','events.event_image',
            'frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as mail')
        ->join('events','events.event_unique_id','=','event_booking.event_id')
        ->join('event_category','event_category.id','=','events.event_category')
        ->join('frontusers','frontusers.id','=','event_booking.user_id')
        ->where('events.event_start_datetime','>=',$datas)
        ->where('event_booking.user_id',$user_id)
        ->where('event_booking.order_status',1)
        ->paginate(10);
    }
    /*Book past event for api*/
    public function past_tikcets_events($user_id) {
        $datas= Carbon::now();
        return static::select('event_booking.user_id','event_booking.order_id','event_booking.order_tickets',
            'event_category.category_name',
            'events.event_unique_id','events.event_name','events.event_location',
            'events.event_start_datetime','events.event_image',
            'frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as mail')
        ->join('events','events.event_unique_id','=','event_booking.event_id')
        ->join('event_category','event_category.id','=','events.event_category')
        ->join('frontusers','frontusers.id','=','event_booking.user_id')
        ->where('events.event_start_datetime','<=',$datas)
        ->where('event_booking.user_id',$user_id)
        ->paginate(10);
    }

    /*============================ API DATA ==========================*/
    
    
    public function contactDetailAttends($event_id)
    {
        return static::select('event_booking.*','ot_order_id','order_tickets.ot_f_name','order_tickets.ot_l_name','ot_email','order_payment.payment_gateway','frontusers.profile_pic','order_tickets.ot_cellphone')
            ->leftjoin('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
            ->leftjoin('order_payment','order_payment.payment_order_id','=','event_booking.order_id')
            ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
            ->where('event_booking.event_id',$event_id)
            ->where('event_booking.order_status',1)
            ->groupBy('order_tickets.ot_order_id')
            ->orderBy('created_at','desc')
            ->paginate(20);
    }
    
     
     
    
   /* public function EventsAllList($uid)
    {
        return static::select('event.*', 'event_booking.*','ot_order_id','order_tickets.ot_f_name','order_tickets.ot_l_name','ot_email','order_payment.payment_gateway','frontusers.profile_pic','order_tickets.ot_cellphone')
            ->leftjoin('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
            ->leftjoin('order_payment','order_payment.payment_order_id','=','event_booking.order_id')
            ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
            ->leftjoin('event_booking','event_booking.ievent_id','=','event.event_unique_id')
            ->where('event.event_create_by',$uid)
            ->where('event_booking.order_status',1)
            ->groupBy('order_tickets.ot_order_id')
            ->orderBy('event.created_at','desc')
            ->paginate(20);
    } */   
}

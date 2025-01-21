<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\ModalAPI\ImageUpload;
use App\ModalAPI\orderTickets;

class Event extends Model
{
	protected $table = 'events';
 	protected $fillable = [
        'event_unique_id', 'event_slug','refund_policy','event_qrcode', 'event_qrcode_image', 'event_create_by', 'event_category',
        'event_name', 'event_description', 'event_location', 'map_display', 'event_address', 'event_start_datetime', 'event_end_datetime', 
        'event_image', 'event_url', 'event_org_name', 'event_facebook','short_url', 'evetn_twitter', 'event_instagaram', 'event_status', 'event_remaining','event_code','event_link_slug','event_latitude','event_longitude','event_city','event_state','event_country'];

    
    /*============================ API DATA ==========================*/
        public function getfeatureevent() {
            $datas= Carbon::now();
            $output = static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','events.event_slug');
            $output->where('event_end_datetime','>=',$datas);
            return $output->paginate(15);
        }



         /*select single  Event for api*/
    public function getsingle_event($id) {
        $datas= Carbon::now();
        return static::select('events.id','events.event_unique_id','events.event_slug','events.event_name','events.event_image','events.event_start_datetime','events.event_end_datetime','events.event_address','events.event_description',
         'events.event_location','organizations.organizer_name','organizations.about_organizer','organizations.url_slug','event_category.category_name',
         DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id
                GROUP BY event_tickets.event_id) as event_max_price"),
        DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id
                GROUP BY event_tickets.event_id) as event_min_price"),
        DB::raw("(SELECT sum(event_tickets.ticket_qty) FROM event_tickets
            WHERE event_tickets.event_id = events.event_unique_id ) as EVENT_TOTAL_TICKETS"),
        DB::raw("(SELECT sum(event_booking.order_tickets) FROM event_booking
            WHERE event_booking.event_id = events.event_unique_id AND event_booking.order_status = 1) as EVENT_ORDERD_TICKETS"))
        ->join('event_category','event_category.id','=','events.event_category')        
        ->join('event_tickets','event_tickets.event_id','=','events.event_unique_id')
        ->join('organizations','organizations.id','=','events.event_org_name')
        ->where('events.event_unique_id',$id)
        ->first();
    }
    public function geteventscanned($event_id) {
        return orderTickets::select(DB::raw('count(id) as TOTAL_SCANNED'))
            ->where('ot_status', 1)
            ->where('ot_event_id',$event_id)->first();
    }
    
    /*Get Today Event API*/
    public function gettodayevent($cid) {
        $start= Carbon::today();
        $end = Carbon::today()->addHours(23)->addMinutes(59);
        return static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','event_category.id')
        ->join('event_category','event_category.id','=','events.event_category')
        ->where(function($query) use ($cid){
            if(isset($cid) && intval($cid)){
                $query->where('event_category.id',$cid);
            }
        })
        ->whereBetween('event_start_datetime',[$start,$end])
        ->paginate(15);
    }
    /*Get Tomorrow Event API*/
    public function gettomorrowevents($cid) {
        $start  = Carbon::today()->addHours(24);
        $end    = Carbon::today()->addHours(47)->addMinutes(59);
        return static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','event_category.id')
        ->join('event_category','event_category.id','=','events.event_category')
        ->where(function($query) use ($cid){
            if(isset($cid) && intval($cid)){
                $query->where('event_category.id',$cid);
            }
        })
        ->whereBetween('event_start_datetime', [$start, $end])
        ->paginate(15);
    }
    /*Get This Week API*/
    public function getthisweekevents($cid) {
       $start  = Carbon::now()->startOfweek();
         $end    = Carbon::now()->endOfweek();
        return static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','event_category.id')
        ->join('event_category','event_category.id','=','events.event_category')
        ->where(function($query) use ($cid){
            if(isset($cid) && intval($cid)){
                $query->where('event_category.id',$cid);
            }
        })
        ->whereBetween('event_end_datetime', [$start, $end] )
        ->paginate(15);
    }
    /*Get category wise API */
    public function getcategorywiseeventapi($id) {
        $datas= Carbon::now();
        return static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','event_category.id','event_category.category_name','event_category.category_slug')
        ->join('event_category','event_category.id','=','events.event_category')
        ->where('event_end_datetime','>=',$datas)        
        ->where('event_category',$id)
        ->paginate(15);        
    }

    public function get_single_event_data($event_id) {
        return static::select('events.id','events.event_unique_id','events.event_name',
            'events.event_start_datetime','events.event_end_datetime',
            'events.event_location', 'events.event_address',
            'organizations.organizer_name')
        ->join('organizations','organizations.id','=','events.event_org_name')
        ->where('events.event_unique_id',$event_id)
        ->first();
    }

    public function myliveEvent($id) {
        $datas = Carbon::now()->subDay(1);
        return static::select('events.id','event_unique_id','event_name','event_location','event_address','event_start_datetime', 'event_end_datetime','event_image', 'event_org_name', 'event_status', 'event_remaining','event_category.category_name as catname',
            DB::raw("(SELECT sum(event_tickets.ticket_qty) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id ) as EVENT_TOTAL_TICKETS"),
            DB::raw("(SELECT sum(event_booking.order_tickets) FROM event_booking
                WHERE event_booking.event_id = events.event_unique_id AND event_booking.order_status = 1) as EVENT_ORDERD_TICKETS"))
        ->join('event_category','event_category.id','=','events.event_category')
        //->where('event_start_datetime','>=',$datas)
        ->where('event_end_datetime','>=',$datas)
        ->where('event_create_by',$id)
        ->get();
    }

    public function liveEvent($id) {
        $datas = Carbon::now()->subDay(1);
        return static::select('id','event_unique_id','event_category','event_name','event_location','event_address','event_start_datetime', 'event_end_datetime','event_image', 'event_org_name', 'event_status', 'event_remaining',
            DB::raw("(SELECT sum(event_tickets.ticket_qty) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id ) as EVENT_TOTAL_TICKETS"),
            DB::raw("(SELECT sum(event_booking.order_tickets) FROM event_booking
                WHERE event_booking.event_id = events.event_unique_id AND event_booking.order_status = 1 ) as EVENT_ORDERD_TICKETS"))
        //->where('event_start_datetime','>=',$datas)
        ->where('event_end_datetime','>=',$datas)
        ->where('event_create_by',$id)
        ->get();
    }	

    public function pastEvent($id)
    {
        $datas= Carbon::now();
        return static::select('id','event_unique_id','event_category','event_name','event_location','event_address','event_start_datetime', 'event_end_datetime','event_image', 'event_org_name', 'event_status', 'event_remaining',
            DB::raw("(SELECT sum(event_tickets.ticket_qty) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_booking.order_status=1 ) as EVENT_TOTAL_TICKETS"),
            DB::raw("(SELECT sum(event_booking.order_tickets) FROM event_booking
                WHERE event_booking.event_id = events.event_unique_id AND event_booking.order_status=1 ) as EVENT_ORDERD_TICKETS"))
        ->where('event_end_datetime','<=',$datas)
        ->where('event_create_by',$id)
        ->get();
    }
    
    public function myPastEvent($id) {
        $datas = Carbon::now()->subDay(1);
        return static::select('events.id','event_unique_id','event_name','event_location','event_address','event_start_datetime', 'event_end_datetime','event_image', 'event_org_name', 'event_status', 'event_remaining','event_category.category_name as catname',
            DB::raw("(SELECT sum(event_tickets.ticket_qty) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id ) as EVENT_TOTAL_TICKETS"),
            DB::raw("(SELECT sum(event_booking.order_tickets) FROM event_booking
                WHERE event_booking.event_id = events.event_unique_id AND event_booking.order_status = 1) as EVENT_ORDERD_TICKETS"))
        ->join('event_category','event_category.id','=','events.event_category')
        ->where('event_end_datetime','<=',$datas)
        ->where('event_create_by',$id)
        ->get();
    }

    public function SelectData() {
        $datas = Carbon::now();
        return static::select('id','event_unique_id','event_name','event_slug','event_image')
            ->where('event_end_datetime','>=',$datas)
            ->take(10)
            ->get();   
    }

    public function eventByUid($event_id) {
        return static::select('id','event_unique_id','events.event_create_by','events.event_name','events.event_location','events.event_start_datetime','events.event_end_datetime','events.event_org_name','events.event_status')
        ->where('event_unique_id',$event_id)
        ->first();
    }
    
    public function upcoming_events($user_id) {
        $datas= Carbon::now();
        return static::select('events.*','organizations.*','event_category.category_name',
            'events.event_unique_id','events.event_name','events.event_location','events.event_start_datetime','events.event_image',
             DB::raw("(SELECT COUNT(*) FROM order_tickets
                WHERE order_tickets.ot_event_id = events.event_unique_id AND order_tickets.delivred_status=1) as EVENT_TOTAL_TICKETS"),
            'frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as mail')
        ->join('organizations','organizations.id','=','events.event_org_name')
        ->join('event_category','event_category.id','=','events.event_category')
        ->join('frontusers','frontusers.id','=','organizations.user_id')
        ->where('events.event_end_datetime','>=',$datas)
        ->where('organizations.user_id',$user_id)
        ->where('events.event_status',1)
        ->paginate(15);
    }
    

    /*============================ API DATA ==========================*/
}

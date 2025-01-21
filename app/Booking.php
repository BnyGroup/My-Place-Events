<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;
use Bavix\Wallet\Interfaces\Product;
use Bavix\Wallet\Interfaces\Customer;


// Tentative de reservation
class Booking extends Model implements Product
{
    use HasWallet, HasWallets;

    protected $table = 'event_booking';
 	protected $fillable = [
        'event_id','gadget_id', 'user_id', 'order_id',
        'order_tickets', 'order_amount','gust_id','order_status', 'order_commission',
        'order_t_id', 'order_t_title', 'order_t_qty', 'order_t_price', 'order_t_fees', 'order_t_commission',
        'client_token','manual_attend_vendor', 'createinvoice','discount','discount_type','discount_code'
    ];

    /* Wallet */
    public function canBuy(Customer $customer, bool $force = false): bool
    {
        /**
         * If the service can be purchased once, then
         *  return !$customer->paid($this);
         */
        return true;
    }

    public function getAmountProduct(): int
    {
        return $this->order_amount;
    }

    public function getMetaProduct(): ?array
    {
        return [
            'title' => $this->order_id,
            'description' => $this->event_name,
        ];
    }

    public function getUniqueId(): string
    {
        return (string)$this->getKey();
    }
/* Fin Wallet */


    public function insertData($input) {
    	return static::create(array_only($input,$this->fillable));
    }

    public function updateData($input,$orderId){

        return static::where('order_id',$orderId)->update(array_only($input,$this->fillable));
    }


    public function updateOrderStatus($status, $orderId){
        DB::table('event_booking')
         ->where('order_id', $orderId)
         ->limit(1)
         ->update(array('order_status' => $status));
     }

    public function singleOrder($order_id){
        return static::select('event_booking.*','events.*')
            ->join('events','event_booking.event_id','=','events.event_unique_id')
            ->where('order_id',$order_id)->first();
    }

    public function getOrder()
    {
         return static::select('event_booking.*','events.*','event_booking.created_at as BOOKING_ON')
            ->join('events','event_booking.event_id','=','events.event_unique_id')
            ->where('order_status','1')->get();
    }

    public function CountOrder()
    {
         return static::select('event_booking.*','events.*','event_booking.created_at as BOOKING_ON')
            ->join('events','event_booking.event_id','=','events.event_unique_id')
            ->where('order_status','1')->count();
    }
    
    public function getPandingOrder()
    {
         return static::select('event_booking.*','event_booking.created_at as BOOKING_ON')->where('order_status','0')->get()->toArray();
    }

    public function getUserPandingOrder()
    {
        $user_id = auth()->guard('frontuser')->user()->id;
         return static::select('event_booking.*','event_booking.created_at as BOOKING_ON')
                ->where('order_status','0')
                ->where('user_id',$user_id)
                ->get()->toArray();
    }

    public function getData($booking_id) {
        return static::select('event_booking.*','events.*','event_booking.created_at as BOOKING_ON','event_tickets.*')
			->join('events','event_booking.event_id','=','events.event_unique_id')
            ->leftjoin('event_tickets','event_tickets.event_id','=','event_booking.event_id')    
			->where('client_token',$booking_id)->first();
    }

    public function getDataAPI($token){
        return static::select('event_booking.*','events.event_name','event_booking.created_at as BOOKING_ON','organizations.organizer_name','events.event_start_datetime','events.event_end_datetime')
            ->join('events','event_booking.event_id','=','events.event_unique_id')
            ->join('organizations','organizations.id','=','events.event_org_name')
            ->where('client_token',$token)->first();
    }

    public function getOrderData($booking_id) {
        return static::select('event_booking.*','events.*','event_booking.updated_at as upat','organizations.url_slug as org_slug',
            'organizations.organizer_name as org_name', 'frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as user_email',
            'event_booking.created_at as BOOKING_ON','order_tickets.ot_email', 'order_tickets.ot_cellphone', 'order_tickets.moreinfos', 'order_tickets.id as orderid', 'frontusers.cellphone' ,'event_category.category_name' )
            ->leftjoin('events','event_booking.event_id','=','events.event_unique_id')
            ->leftjoin('event_category','event_category.id','=','events.event_category')
            ->leftjoin('organizations','organizations.id','=','events.event_org_name')
            ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
            ->leftjoin('order_tickets', function ($join) {
                $join->on('order_tickets.ot_order_id', '=', 'event_booking.order_id')
                    ->whereNotNull('event_booking.user_id')
                    ->groupBy('order_tickets.ot_order_id');
            })
            ->where('order_id',$booking_id)
            ->first();
    }
	
	public function getOrderDataAll($booking_id) {
        return static::select('event_booking.*','events.*','event_booking.updated_at as upat','organizations.url_slug as org_slug',
            'organizations.organizer_name as org_name', 'frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as user_email',
            'event_booking.created_at as BOOKING_ON','order_tickets.ot_email', 'order_tickets.ot_cellphone', 'order_tickets.moreinfos', 'order_tickets.id as orderid','frontusers.cellphone','event_category.category_name' )
            ->leftjoin('events','event_booking.event_id','=','events.event_unique_id')
            ->leftjoin('event_category','event_category.id','=','events.event_category')
            ->leftjoin('organizations','organizations.id','=','events.event_org_name')
            ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
            ->leftjoin('order_tickets', function ($join) {
                $join->on('order_tickets.ot_order_id', '=', 'event_booking.order_id')
                    ->whereNotNull('event_booking.user_id')
                    ->groupBy('order_tickets.ot_order_id');
            })
            ->where('order_id',$booking_id)
            ->get();
    }
	
    public function getOrderDataGuest($booking_id) {
        return static::select('event_booking.*','events.*','event_booking.updated_at as upat','organizations.url_slug as org_slug',
            'organizations.organizer_name as org_name', 'guest_user.guest_id as user_id', 'guest_user.user_name as fnm','guest_user.guest_email as user_email',
            'event_booking.created_at as BOOKING_ON','order_tickets.ot_email', 'order_tickets.ot_cellphone', 'order_tickets.moreinfos', 'order_tickets.id as orderid', 'guest_user.cellphone','event_category.category_name' )
            ->leftjoin('events','event_booking.event_id','=','events.event_unique_id')
            ->leftjoin('event_category','event_category.id','=','events.event_category')
            ->leftjoin('organizations','organizations.id','=','events.event_org_name')
            ->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
            ->leftjoin('order_tickets', function ($join) {
                $join->on('order_tickets.ot_order_id', '=', 'event_booking.order_id')
                    ->whereNotNull('event_booking.gust_id')
                    ->groupBy('order_tickets.ot_order_id');
            })
            ->where('order_id',$booking_id)
            ->first();
    }	

    public function getOrderDataByToken($token){
        return static::select('event_booking.*','events.*','event_booking.updated_at as upat','organizations.url_slug as org_slug', 'organizations.organizer_name as org_name', 'frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as user_email', 'event_booking.created_at as BOOKING_ON','order_tickets.ot_email')
            ->leftjoin('events','event_booking.event_id','=','events.event_unique_id')
            ->leftjoin('organizations','organizations.id','=','events.event_org_name')
            ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
            ->leftjoin('order_tickets', function ($join) {
                $join->on('order_tickets.ot_order_id', '=', 'event_booking.order_id')
                    ->whereNotNull('event_booking.gust_id')
                    ->groupBy('order_tickets.ot_order_id');
            })
            ->where('client_token',$token)
            ->first();
    }



    public function deleteBooking($order_id)
    {
        return static::where('order_id',$order_id)->delete();
    }

    public function getOrderlist($id)
    {
        $start  = \Carbon\Carbon::now();
        return static::select('event_booking.*','events.*')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->where('event_booking.user_id',$id)
            ->where('event_booking.order_status',1)
            ->where('events.event_start_datetime','>=', $start)
            ->paginate(15);
    }
    public function getOrderpast($id)
    {
        $start  = \Carbon\Carbon::now();
        return static::select('event_booking.*','events.*')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->where('event_booking.user_id',$id)
            ->where('event_booking.order_status',1)
            ->where('events.event_start_datetime','<=', $start)
            ->paginate(15);
    }

    public function upCounts($id)
    {
        $start  = \Carbon\Carbon::now();
        return static::select('event_booking.*','events.*')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->where('event_booking.user_id',$id)
            ->where('event_booking.order_status',1)
            ->where('events.event_start_datetime','>=', $start)
            ->count();
    }
    public function pastCounts($id)
    {
        $start  = \Carbon\Carbon::now();
        return static::select('event_booking.*','events.*')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->where('event_booking.user_id',$id)
            ->where('event_booking.order_status',1)
            ->where('events.event_start_datetime','<=', $start)
            ->count();
    }
    public function getDataWthid()
    {
        return static::select('event_booking.*','events.event_name as enm','frontusers.firstname as fnm','frontusers.lastname as lnm','event_booking.updated_at as upat','order_payment.payment_method as METHOD',
            'order_payment.payment_gateway as GATEWAY','guest_user.guest_email as GUEST_EMAIL','guest_user.cellphone as GUEST_CELLPHONE','guest_user.user_name as GUEST_USERNAME','frontusers.cellphone as USER_CELLPHONE',
            'frontusers.email as USER_EMAIL','order_payment.payment_number as PAYMENT_NUMBER')
        ->leftjoin('order_payment','order_payment.payment_order_id','=','event_booking.order_id')
        ->leftjoin('events','events.event_unique_id','=','event_booking.event_id')
        ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
        ->leftjoin('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')        
        ->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
        /*->leftjoin('order_payment', function ($join) {
            $join->on('order_payment.payment_order_id', '=', 'event_booking.order_id')
                ->where('order_payment.payment_status', 1)
                ->orWhere('order_payment.payment_status', null);
                //->groupBy('order_tickets.ot_order_id');
        })*/
        ->orderBy('created_at', 'DESC')
        //->where("event_booking.order_status","1")
        //->orwhere("order_payment.payment_status", "1")
        /*->orWhere(function ($query) {
                return $query->where('order_payment.payment_status', 1)
                    ->orWhere('order_payment.payment_status', NULL);
            })*/
        ->get();
    }

    /*public function getDataforDashNew()
    {
        return static::select('event_booking.*','events.event_name as ename','events.created_at as EVENT_CREATED_AT','order_tickets.delivred_status as delivred_status')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->join('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
            ->orderBy('id','desc')
            //->take(7)
            ->get();
    }*/

    public function getEventbook($id)
    {
        // return static::select('event_booking.*','frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as mail')
        // ->join('frontusers','frontusers.id','=','event_booking.user_id')
        // ->where('order_status','1')
        // ->where('event_id',$id)
        // ->get();

        return static::select('event_booking.*','frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as mail','guest_user.user_name','guest_user.guest_email')
        ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
        ->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
        ->where('event_booking.event_id',$id)
        ->orderBy('event_booking.created_at','desc')
        ->where('event_booking.order_status','<>',2)
        ->get();
    }
    public function getDataforDash()
    {
        return static::select('event_booking.*','events.event_name as ename','events.created_at as EVENT_CREATED_AT','order_tickets.delivred_status as delivred_status')
        ->join('events','events.event_unique_id','=','event_booking.event_id')
        ->join('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
        ->orderBy('id','desc')
        ->take(7)
        ->get();
    }

    public function getDataforDashThree()
    {
        $fixedDate = Carbon::create(2020, 11, 01, 0, 0, 0, 'GMT');
        return static::select('event_booking.*','events.event_name as ename','events.created_at as EVENT_CREATED_AT','order_tickets.delivred_status as delivred_status','order_tickets.ot_cellphone as ORDER_TICKETS_CELLPHONE')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->join('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
            ->where('event_booking.created_at','>=',$fixedDate)
            ->orderBy('id','desc')
            ->get();
    }

    public function getDataforDashLevelTwo()
    {
        $date = Carbon::now()->subDays(7);
        $fixedDate = Carbon::create(2020, 01, 29, 0, 0, 0, 'GMT');;
        return static::select('event_booking.*','events.event_name as ename','events.created_at as EVENT_CREATED_AT','order_tickets.delivred_status as delivred_status',
            'frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as EMAIL', 'frontusers.cellphone as CELLPHONE'/*,'guest_user.user_name as GUEST_NAME',
            'guest_user.guest_email as GUEST_EMAIL','guest_user.cellphone as GUEST_CELLPHONE'*/)
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->join('frontusers','frontusers.id','=','event_booking.user_id')
            //->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
            ->join('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
            ->where('events.created_at','>=',$fixedDate)
            ->where('order_status',0)
            ->get();
    }

    public function getDataToDelivery(){
        return static::select('event_booking.*','events.*','event_booking.updated_at as upat','organizations.url_slug as org_slug', 'organizations.organizer_name as org_name',
            'frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as user_email', 'frontusers.cellphone as cellphone','event_booking.created_at as BOOKING_ON',
            'order_tickets.ot_email','events.event_name as event_name','guest_user.cellphone as guest_cellphone','guest_user.guest_email as guest_email','frontusers.cellphone as user_cellphone')
            ->leftjoin('events','event_booking.event_id','=','events.event_unique_id')
            ->leftjoin('organizations','organizations.id','=','events.event_org_name')
            ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
            ->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
            /*->leftjoin('order_tickets', function ($join) {
                $join->on('order_tickets.ot_order_id', '=', 'event_booking.order_id')
                    //->whereNotNull('event_booking.gust_id')
                    ->groupBy('order_tickets.ot_order_id');
            })*/
            ->leftjoin('order_tickets','order_tickets.ot_order_id', '=', 'event_booking.order_id')
            ->where('order_status',4)
            ->orderBy('event_booking.created_at', 'DESC')
            ->get();
    }

    public function getDataToDeliveryPaid(){
        return static::select('event_booking.*','events.*','event_booking.updated_at as upat','organizations.url_slug as org_slug', 'organizations.organizer_name as org_name',
            'frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as user_email', 'frontusers.cellphone as cellphone','event_booking.created_at as BOOKING_ON',
            'order_tickets.ot_email','events.event_name as event_name','order_payment.payment_gateway as payment_gateway','event_booking.updated_at as updated_date','guest_user.cellphone as guest_cellphone',
            'guest_user.guest_email as guest_email','frontusers.cellphone as user_cellphone')
            ->leftjoin('events','event_booking.event_id','=','events.event_unique_id')
            ->leftjoin('organizations','organizations.id','=','events.event_org_name')
            ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
            ->leftjoin('order_payment','order_payment.payment_order_id','=','event_booking.order_id')
            ->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
            ->leftjoin('order_tickets', function ($join) {
                $join->on('order_tickets.ot_order_id', '=', 'event_booking.order_id')
                    //->whereNotNull('event_booking.gust_id')
                    ->groupBy('order_tickets.ot_order_id');
            })
            ->where('order_status',1)
            ->where('payment_gateway','LIVRAISON')
            ->get();
    }





/* ==================================================================================== */
/* ==================================================================================== */
/* ==================================================================================== */
/* ===================================== API CODE ===================================== */
/* ==================================================================================== */
/* ==================================================================================== */
/* ==================================================================================== */
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

    public function contactDetailAttends($uid,$event_id)
    {

        return static::select('event_booking.*','ot_order_id','order_tickets.ot_f_name','order_tickets.ot_l_name','ot_email','order_payment.payment_gateway')
                    ->leftjoin('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
                    ->leftjoin('order_payment','order_payment.payment_order_id','=','event_booking.order_id')
                    // ->where('event_booking.manual_attend_vendor',$uid)
                    ->where('event_booking.event_id',$event_id)
                    ->where('event_booking.order_status',1)
                    ->groupBy('order_tickets.ot_order_id')
                    ->orderBy('created_at','desc')
                    ->paginate(20);
    }



    public function priceChange($unique_id)
    {
       return static::select('*')
       ->where('event_id','=',$unique_id)
       ->first();
    }

    public function getOrderEvents($event_id)
    {
        return static::where('event_id',$event_id)
        ->where('order_status',1)
        //->where('order_paymets',1)
        ->orderBy('created_at','desc')->get();
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

    /*Book upcoming event for api*/
    /* public function upcoming_event($user_id) {
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
        ->paginate(10);
    }*/

}

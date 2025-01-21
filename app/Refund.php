<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = ['event_id','order_id','user_id','refund_status','transation_date','reject_note','event_ower_id'];

    public function createData($input)
    {
    	return static::create(array_only($input,$this->fillable));
    }

    public function finData($order_id)
    {
    	return static::where('order_id',$order_id)->first();
    }
    public function pendingList()
    {
    	return static::select('refunds.*','events.event_name','event_booking.order_tickets','event_booking.order_amount','order_payment.stripe_id')
    			->leftjoin('events','events.event_unique_id','=','refunds.event_id')
    			->leftjoin('event_booking','event_booking.order_id','=','refunds.order_id')
                ->leftjoin('order_payment','order_payment.payment_order_id','=','refunds.order_id')
    			->where('refund_status','Pending')
    			->get();
    }

    public function acceptList()
    {
        return static::select('refunds.*','events.event_name','event_booking.order_tickets','event_booking.order_amount','order_payment.stripe_id')
                ->leftjoin('events','events.event_unique_id','=','refunds.event_id')
                ->leftjoin('event_booking','event_booking.order_id','=','refunds.order_id')
                ->leftjoin('order_payment','order_payment.payment_order_id','=','refunds.order_id')
                ->where('refund_status','Accept')
                ->get();
    }
    public function rejectList()
    {
        return static::select('refunds.*','events.event_name','event_booking.order_tickets','event_booking.order_amount','order_payment.stripe_id')
                ->leftjoin('events','events.event_unique_id','=','refunds.event_id')
                ->leftjoin('event_booking','event_booking.order_id','=','refunds.order_id')
                ->leftjoin('order_payment','order_payment.payment_order_id','=','refunds.order_id')
                ->where('refund_status','Reject')
                ->get();
    }

    public function pendingListEventWise($id)
    {
        return static::select('refunds.*','events.event_name','event_booking.order_tickets','event_booking.order_amount','order_payment.stripe_id')
                ->leftjoin('events','events.event_unique_id','=','refunds.event_id')
                ->leftjoin('event_booking','event_booking.order_id','=','refunds.order_id')
                ->leftjoin('order_payment','order_payment.payment_order_id','=','refunds.order_id')
                ->orderBy('refunds.transation_date','desc')
                ->where('refund_status','Pending')
                ->where('refunds.event_id',$id)
                ->paginate(15);
    }

    public function acceptListEventWise($id)
    {
        return static::select('refunds.*','events.event_name','event_booking.order_tickets','event_booking.order_amount','order_payment.stripe_id')
                ->leftjoin('events','events.event_unique_id','=','refunds.event_id')
                ->leftjoin('event_booking','event_booking.order_id','=','refunds.order_id')
                ->leftjoin('order_payment','order_payment.payment_order_id','=','refunds.order_id')
                ->orderBy('refunds.transation_date','desc')
                ->where('refund_status','Accept')
                ->where('refunds.event_id',$id)
                ->paginate(15);
    }
    public function rejectListEventWise($id)
    {
        return static::select('refunds.*','events.event_name','event_booking.order_tickets','event_booking.order_amount','order_payment.stripe_id')
                ->leftjoin('events','events.event_unique_id','=','refunds.event_id')
                ->leftjoin('event_booking','event_booking.order_id','=','refunds.order_id')
                ->leftjoin('order_payment','order_payment.payment_order_id','=','refunds.order_id')
                ->orderBy('refunds.transation_date','desc')
                ->where('refund_status','Reject')
                ->where('refunds.event_id',$id)
                ->paginate(15);
    }
}

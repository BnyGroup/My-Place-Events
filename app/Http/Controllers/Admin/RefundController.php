<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Refund;
use App\orderTickets;
use App\EventTicket;
use App\Booking;
use \Carbon\Carbon;
use Mail;
use Validator;

class RefundController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->refund = new Refund;
	}

	public function pending()
	{
		$data = $this->refund->pendingList();
		return view('Admin.refund.index',compact('data'));
	}
	public function accept()
	{
		$data = $this->refund->acceptList();
		return view('Admin.refund.accept',compact('data'));
	}
	public function reject()
	{
		$data = $this->refund->rejectList();
		return view('Admin.refund.reject',compact('data'));
	}

	public function refundPayment(Request $request)
	{
		// dd($input);
		$input = $request->all();
		// if(isset($_POST['stripeToken'])):
		// dd(floatval($input['pay']));
			\Stripe\Stripe::setApiKey(config('services.stripe.secret'));
			// $refund = \Stripe\Refund::create([
			//     'charge' => $input['charge_id'],
			//     'amount' => number_format($input['pay'], 2, '', ''),
			// ]);
			$refund = \Stripe\Refund::create([
				  "charge" => $input['charge_id'],
				  // "reverse_transfer" => true,
				  // "refund_application_fee" => false,
			]);
		
		// endif;
		$this->removeOrder($input['order_id']);
		return redirect()->back()->with('success','Refund successfully paid.');
	}

	public function removeOrder($orderid)
	{
		$data = orderTickets::where('ot_order_id',$orderid)->get();
		$path = public_path('/upload/ticket-qr/');

		$dataTikid = [];
		$dataTikco = [];
		foreach ($data as $key => $value) {
			if (\File::exists($path.'/'.$value->ot_qr_image)) {
				\File::delete($path.'/'.$value->ot_qr_image);
			}
			$dataTikid[$key] = ($value->ot_ticket_id);
			$dataTikco[$key] = ($value->ot_ticket_id);
		}

		$pdf = $data[0]->ot_order_id.'-'.$data[0]->ot_event_id.'.pdf';

		$path1 = public_path('/upload/ticket-pdf/');
		if (\File::exists($path1.'/'.$pdf)) {
				\File::delete($path1.'/'.$pdf);
		}

		$valur = array_values(array_count_values($dataTikid));
		$tkey = array_values(array_unique($dataTikco));
		foreach ($valur as $keys => $values) {
			EventTicket::where('ticket_id',$tkey[$keys])->increment('ticket_remaning_qty',$values);
		}
		orderTickets::where('ot_order_id',$orderid)->delete();
		Refund::where('order_id',$orderid)->update(['refund_status' => 'Accept','transation_date' => Carbon::now()]);
		Booking::where('order_id',$orderid)->update(['order_status' => 3]);

		$datas = Booking::select('event_booking.user_id','event_booking.order_amount','event_booking.order_tickets','event_booking.order_id','events.event_name')
				->join('events','events.event_unique_id','=','event_booking.event_id')
				->where('event_booking.order_id',$orderid)
				->first();

		$userdata = (object) $datas;

		 try {
	        Mail::send('Admin.refund.mail',['userdata'=>$userdata],function($message) use ($userdata)
	        {
	            $message->from(siteSetting()->site_email,siteSetting()->title);
	            $message->to(user_data($userdata->user_id)->email);
	            $message->subject('Refund successfully');
	        });
        }catch (\Exception $e) {
            return redirect()->back()->with('success','Refund paid successfully but email are not send.');
        }
		return;
	}

	public function RejectReason(Request $request)
	{
		$input = $request->all();

    	$validator = Validator::make($input, [
    	   'reject_reason' => 'required',
        ]);
    	if($validator->passes()){

    		Refund::where('order_id',$input['order_id'])->update(['refund_status' => 'Reject','transation_date' => Carbon::now(),'reject_note' => $input['reject_reason']]);

    		$userdata = (object) $input;

	    	try {
	    		Mail::send('Admin.refund.reject-mail',['userdata'=>$userdata],function($message) use ($userdata){
		            $message->from(siteSetting()->site_email,siteSetting()->title);
		            $message->to(user_data($userdata->user_id)->email);
		            $message->subject('Refund Reject');
		        });
	        }catch (\Exception $e) {
    			return response()->json(['success' => 'Refund cancel successfully but email are not send.']);
	        }
    		return response()->json(['success' => 'Refund cancel successfully.']);
    	}
    	return response()->json(['error' => $validator->errors()->all()]);
	}
}

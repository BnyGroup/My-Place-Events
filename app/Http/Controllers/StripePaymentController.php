<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\Http\Requests;
use App\Booking;
use App\OrderPayment;
use App\Refund;
use \Carbon\Carbon;

class StripePaymentController extends FrontController
{
    public function __construct() {
	    parent::__construct();
		$this->ticket_booking = new Booking;
		$this->order_payment = new OrderPayment;
		$this->refund = new Refund;
	}

	public function paymentDone(Request $request){
		$requestData = $request->all();
		$order_data = json_decode($requestData['order_data']);
		$bookingdata	= $this->ticket_booking->singleOrder($order_data->event_booking_id);

		//dd($request, $_POST['stripeToken'], $requestData, $order_data->event_booking_id);

		/* CHACKED REQUES STATUS */
		if(isset($_POST['stripeToken'])) {

			\Stripe\Stripe::setApiKey(config('services.stripe.secret'));
			$token = $_POST['stripeToken'];
			try {
				$charge = \Stripe\Charge::create([
				    'amount' => number_format($bookingdata->order_amount, 2, '', ''),
				    'currency' => config('services.stripe.currency'),
				    'description' => 'Charge for - '.$_POST['stripeEmail'],
				    'source' => $token,
				]);
			} catch (\Stripe\Error\Card $e) {
	        	$body = $e->getJsonBody();
	            $err  = $body['error'];
	        } catch (\Stripe\Error\RateLimit $e) {
	           	$body = $e->getJsonBody();
	            $err  = $body['error'];
	        } catch (\Stripe\Error\InvalidRequest $e) {
	            $body = $e->getJsonBody();
	            $err  = $body['error'];
	        } catch (\Stripe\Error\Authentication $e) {
	            $body = $e->getJsonBody();
	            $err  = $body['error'];
	        } catch (\Stripe\Error\ApiConnection $e) {
	            $body = $e->getJsonBody();
	            $err  = $body['error'];
	        } catch (\Stripe\Error\Base $e) {
	            $body = $e->getJsonBody();
	            $err  = $body['error'];
	        } catch (Exception $e) {
	            $body = $e->getJsonBody();
	            $err  = $body['error'];
	        }
		}
		/* CHACKED REQUES STATUS */
		$order_payment['payment_user_id']		= $bookingdata->user_id;
	    $order_payment['payment_order_id']		= $bookingdata->order_id;
	    $order_payment['payment_event_id']		= $bookingdata->event_id;
	    $order_payment['payment_amount']		= $bookingdata->order_amount;
	    $order_payment['payment_currency']		= config('services.stripe.currency');
	    $order_payment['payment_gateway']		= 'stripe-payment';
		if(isset($charge->status) && $charge->status == 'succeeded'){
			$order_payment['stripe_id']			= $charge->id;
		    $order_payment['payment_status']	= 'Done';
	    }else{			    	
	    	$order_payment['failure_code']		= $err['code'];
	    	$order_payment['failure_message']	= $err['message'];
	    	$order_payment['payment_status']	= 'Error';
	    }
		$data = $this->order_payment->insertData($order_payment);

		if( isset($err) ){
			return redirect()->route('order.cancel',$bookingdata->order_id)->with('error',$err['message']);
		}
		return redirect()->route('ticket.oderdone', $order_data->event_booking_id);
		// dd($err, $bookingdata->order_id,$order_data->event_booking_id);
	}

	public function refundRequest(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::guard('frontuser')->user()->id;
        $input['order_id'] = $input['orderid'];
        $input['refund_status'] = 'Pending';
        $input['transation_date'] = Carbon::now();
        $this->refund->createData($input);
        $success = 'Your request successfully submitted.';
        return response()->json($success);
    }

}

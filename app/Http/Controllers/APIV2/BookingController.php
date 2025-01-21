<?php
namespace App\Http\Controllers\APIV2;
use PDF;
use Mail;
use File;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\APIV2\UserController;
use App\ModalAPI\orderTickets;
use App\ModalAPI\EventTicket;
use App\ModalAPI\Organization;
use App\ModalAPI\Booking;
use App\ModalAPI\Bookmark;
use App\ModalAPI\OrderPayment;
use Carbon\Carbon;
use Illuminate\Routing\RouteCollection;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use Illuminate\Support\Facades\Input;
use Response;

class BookingController extends UserController
{
 	public function __construct(){
 		$this->ticket_booking = new Booking;
 		$this->event_ticket = new EventTicket;
 		$this->organization = new Organization;
 		$this->order_tickets = new orderTickets;
 		$this->bookmark = new Bookmark;
 	}
 	public function orderBook(Request $request){
 		$input = $request->all();
 		if (Auth::guard('api')->check()) {
 			$user_id    = Auth::guard('api')->user()->id;
			$client_token		= str_shuffle(str_random(45));
			$bookingOrder_id	= generate_booking_code($input['event_id']);

			$bookingData['event_id'] 		= $input['event_id'];
			$bookingData['user_id']			= $user_id;
			$bookingData['order_id']		= $bookingOrder_id;
			$bookingData['client_token']	= $client_token;

			if($input['total_ticket'] == 0){
				return redirect()->back();
			}
			$order_t_id = array();
			$order_t_title = array();
			$order_t_price = array();
			$order_t_fees = array();
			$order_t_qty = array();

			foreach ($input['ticket_type_qty'] as $key => $value) {
				if($value != 0){
					$quanty		= $input['ticket_type_qty'][$key];
					$ticket_id 	= $input['ticket_id'][$key];				
					$ticket 	= $this->event_ticket->ticket_by_id($ticket_id);

					if($ticket->ticket_qty >= $quanty){
						$order_t_id[]			= $ticket_id;
						$order_t_title[]		= $ticket->ticket_title;
						$order_t_price[]		= number_format(floatval($ticket->ticket_price_actual),2, '.', '');
						$order_t_fees[]			= number_format(floatval($ticket->ticket_price_buyer) - floatval($ticket->ticket_price_actual),2, '.', '');
						$order_t_commission[]	= number_format(floatval($ticket->ticket_commission),2, '.', '');
						$order_t_qty[]			= $quanty;
						$order_commission[]		= floatval($ticket->ticket_commission) * intval($quanty);
					}
					$ticketId = $ticket->ticket_id;				
				}
			}
			/*tickets data*/
			$bookingData['order_tickets']	= $input['total_ticket'];
			$bookingData['order_amount']	= number_format($input['total_amount'],2, '.', '');
			$bookingData['order_commission']	= number_format(array_sum($order_commission),2, '.', '');
			/*serialize data*/
			$bookingData['order_t_id']		= serialize($order_t_id);		
			$bookingData['order_t_title']	= serialize($order_t_title);		
			$bookingData['order_t_qty']		= serialize($order_t_qty);		
			$bookingData['order_t_price']	= serialize($order_t_price);		
			$bookingData['order_t_fees']	= serialize($order_t_fees);
			$bookingData['order_t_commission']	= serialize($order_t_commission);
			$data = $this->ticket_booking->insertData($bookingData);
			if(!is_null($data->id)){
				$message = 'Book your Ticket';
				$output['token'] = $data->client_token;
				return $this->getSuccessResult($output,$message,true);
			}else{
				$message = "Ticket not booked";
            	return $this->getErrorMessage($message);
			}
 		}else{
 			$message = "User not Login";
            return $this->getErrorMessage($message);
 		}
 	}
 	public function register(Request $request) {
 		if (Auth::guard('api')->check()) {
	 		$input = $request->all();
 			$token = $input['token'];
			$bookingdata	= $this->ticket_booking->getDataAPI($token);

			if(!is_null($bookingdata)){
				$output['event']['event_id']				= $bookingdata->event_id;
				$output['event']['event_name']				= $bookingdata->event_name;
				$output['event']['organizer_name']			= $bookingdata->organizer_name;
				$output['event']['event_start_datetime']	= $bookingdata->event_start_datetime;
				$output['event']['event_end_datetime']		= $bookingdata->event_end_datetime;

				$output['order_data']['user_id']		= $bookingdata->user_id;
				$output['order_data']['gust_id']		= $bookingdata->gust_id;
				$output['order_data']['order_id']		= $bookingdata->order_id;
				$output['order_data']['booking_on']		= $bookingdata->BOOKING_ON;
				
				$output['order_ticket']['order_tickets']		= $bookingdata->order_tickets;
				$output['order_ticket']['order_amount']		= $bookingdata->order_amount;
				$output['order_ticket']['order_commission']	= $bookingdata->order_commission;
				// $output['order_ticket']['stripe_charges']		= $bookingdata->stripe_charges;


				$otid = unserialize($bookingdata->order_t_id);
				$ottit = unserialize($bookingdata->order_t_title);
				$oty = unserialize($bookingdata->order_t_qty);
				$otp = unserialize($bookingdata->order_t_price);
				$otf = unserialize($bookingdata->order_t_fees);

				$output['ticket_data']['order_t_id']	= $otid;
				$output['ticket_data']['order_t_title']	= $ottit;
				$output['ticket_data']['order_t_qty']	= $oty;
				$output['ticket_data']['order_t_price']	= $otp;
				$output['ticket_data']['order_t_fees']	= $otf;


				$message = 'Event Booking data';				
				return $this->getSuccessResult($output,$message,true);
			}else{
				$message = "Booking data not found";
            	return $this->getErrorMessage($message);
			}
		}else{
			$message = "User not Login";
            return $this->getErrorMessage($message);
		}
	}
	public function orderStore(Request $request) {
		if (Auth::guard('api')->check()) {
	 		$input = $request->all();
			$bookingdata = $this->ticket_booking->getOrderData($input['order_id']);

			if($bookingdata->order_status == 2){
				$data = $this->orderCancel($bookingdata->order_id);
				return response()->json($data);
			}


			$oderTickets['ot_order_id']	= $input['order_id'];
			$oderTickets['ot_event_id']	= $input['event_id'];
			$oderTickets['ot_user_id']	= $input['user_id'];

			$ticket_id = $input['ticket_id'];
			foreach($ticket_id as $key => $ticket) {
				$oderTickets['ot_ticket_id']	= $ticket;			
				$oderTickets['ot_f_name']		= $input['fname_on_ticket'][$key];
				$oderTickets['ot_l_name']		= $input['lname_on_ticket'][$key];
				$oderTickets['ot_email']		= $input['email_on_ticket'][$key];

				$path = 'upload/ticket-qr';
				if (!is_dir(public_path($path))) {
		            File::makeDirectory(public_path($path),0777,true);
		        }
				$booking_code	=  generate_ticket_code($ticket);
				$qr_img 		= 'Ticket-QR-'.time().'-'.str_random(4).'.png';
				$qr_path		= public_path($path).'/'.$qr_img;
				$qrcode 		= new BaconQrCodeGenerator;
				$qrCode			= $qrcode->format('png')->size(500)
									->encoding('UTF-8')->errorCorrection('H')
									->margin(1)->generate($booking_code, $qr_path);	
				$oderTickets['ot_qr_code']		= $booking_code;
				$oderTickets['ot_qr_image']		= $qr_img;
				$data = $this->order_tickets->insertData($oderTickets);
			}

			$output['event_id'] = $bookingdata->event_id;
			$output['user_id'] = $bookingdata->user_id;
			$output['gust_id'] = $bookingdata->gust_id;
			$output['order_id'] = $bookingdata->order_id;
			$output['order_amount'] = $bookingdata->order_amount;
			$output['event_name'] = $bookingdata->event_name;
			$output['BOOKING_ON'] = $bookingdata->BOOKING_ON;

			if(floatval($bookingdata->order_amount) <= 0){
				$message = "Order Saved";
				return $this->getSuccessResult($output,$message,true);
			}else{
				$message = "Order Saved";
				return $this->getSuccessResult($output,$message,true);
			}
		}else{
			$message = "User not Login";
            return $this->getErrorMessage($message);
		}
	}
	public function orderDone(Request $request) {
		if (Auth::guard('api')->check()) {
			$dats = $request->all();
			$order_id = $dats['payment_order_id'];
			$input['client_token']	= str_shuffle(csrf_token());
			$input['order_status']	= '1';
			$this->ticket_booking->updateData($input,$order_id);
			$orderData	= $this->ticket_booking->getOrderData($order_id);
			if($orderData->order_amount > 0){
				if(isset($_POST['stripeToken'])) {
	                $s_token        = $_POST['stripeToken'];
	                $s_amount       = number_format(($orderData->order_amount), 2, '', '');
	                $s_currency     = use_currency()->type;
	                $s_description  = 'Charge for - '.$_POST['stripeEmail'];
	                $this->paymentController = new PaymentController();
	                $payment_status = $this->paymentController->stripeCharges($s_token, $s_amount, $s_currency, $s_description);
	                
	                if($payment_status->response == false){
	                	$message = $payment_status->data['message'];
						return $this->getSuccessResult(array(),$message,false);
	                }

				}
			}
			$path = 'upload/ticket-pdf/';
			if (!is_dir(public_path($path))) {
	            File::makeDirectory(public_path($path),0777,true);
	        }
	        $pdf_save_path = $path . $order_id . '-' . $orderData->event_id .'.pdf';
			$bookingdata = $this->order_tickets->orderTickets($order_id);
			view()->share('bookingdata',$bookingdata);		
			$pdf = PDF::loadView('theme.pdf.pdfview');
			$pdf->setOptions( [
				'dpi' 			=> 150,
				'defaultFont' 	=> 'monospace',
				'isPhpEnabled' 	=> true,
				'isRemoteEnabled' => true,
				'isHtml5ParserEnabled' => true,
				'setIsRemoteEnabled'=>true,	
		 	]);
			$pdf->setPaper('a4','portrait')->setWarnings(false);
			$pdf->save('public/'.$pdf_save_path);
			//return $pdf->stream();
			$pdf_path = public_path().$pdf_save_path;
			$mail = array($orderData->user_email);
			$mailsendmessge= "";
			try {
				Mail::send('theme.pdf.mail',['orderData'=>$orderData],function($message) use ($mail,$pdf_path) {
					$message->from(frommail(), forcompany());
					$message->to($mail);
					$message->subject(trans('words.msg.e_tic_ord'));
					$message->attach($pdf_path);
				});
			} catch (\Exception $e) {
				$mailsendmessge = "<span class='text-danger'>( <b>Note : </b> Mail not Send smtp error)</span>";
			}
	    	if (! empty($dats)) {
    			OrderPayment::create($dats);
	    	}
	        if (! is_null($order_id)) {
		        	$data = $this->orderSuccess($order_id);
		        	$message = "Order Done" . $mailsendmessge;
					return $this->getSuccessResult($data,$message,true);
			}else{
				$message = "Order Not Done";
        		return $this->getErrorMessage($message);
			}
			$message = "Order Not Done";
    		return $this->getErrorMessage($message);
		}else{
			$message = "User not Login";
            return $this->getErrorMessage($message);
		}
	}
	public function orderSuccess($order_id){
		$bookingdata	= $this->ticket_booking->getOrderData($order_id);
		if (! empty($bookingdata)) {
			$data = array();
			$data['order_id'] 			=  $bookingdata->order_id;
			$data['event_id']		 	=  $bookingdata->event_id;
			$data['event_name'] 		=  $bookingdata->event_name;
			$data['event_start_date'] 	=  $bookingdata->event_start_datetime;
			$data['event_end_date'] 	=  $bookingdata->event_end_datetime;
			$data['total_ticket'] 		=  $bookingdata->order_tickets;
			$data['pdf_link'] 			=  asset('/upload/ticket-pdf/'.($bookingdata->order_id.'-'.$bookingdata->event_id).'.pdf');
			$data['mail_send_ticket'] 	=  $bookingdata->user_email;
			return $data;
		}
		$message = "Order data not found";
		return $this->getErrorMessage($message);
	}
	public function orderCancel(Request $request)	{
		if (Auth::guard('api')->check()) {
			$inputs = $request->all();
			$order_id = $inputs['order_id'];
			$bookingdata	= $this->ticket_booking->getOrderData($order_id);
			$order_ticket_id	= unserialize($bookingdata->order_t_id);
			$order_ticket_qty	= unserialize($bookingdata->order_t_qty);
			foreach ($order_ticket_id as $key => $value) {
				$ticket_update = $this->event_ticket->incres_ticket_qty($value,$order_ticket_qty[$key]);
			}
			$input['client_token']	= str_shuffle(csrf_token());
			$input['order_status']	= '2';
			$this->ticket_booking->updateData($input,$order_id);
			$this->order_tickets->deleteOrder($order_id);

				$data = array();
				$data['order_id'] 			=  $bookingdata->order_id;
				$data['event_id']		 	=  $bookingdata->event_id;
				$data['event_name'] 		=  $bookingdata->event_name;
				$data['event_start_date'] 	=  $bookingdata->event_start_datetime;
				$data['event_end_date'] 	=  $bookingdata->event_end_datetime;
				$data['total_ticket'] 		=  $bookingdata->order_tickets;
			if (! empty($bookingdata)) {
				$message = "Order Cancel";
				return $this->getSuccessResult($data,$message,true);
			}else{
				$message = "Somthin Wrong";
        		return $this->getErrorMessage($message);
			}
			$message = "Somthin Wrong";
    		return $this->getErrorMessage($message);
		} else {
			$message = "User not Login";
            return $this->getErrorMessage($message);
		}
	}

	/* Order Summery */
	public function orderSummery($order_id) {
		if (Auth::guard('api')->check()) {
			$bookingdata = $this->ticket_booking->getOrderData($order_id);
			if (!is_null($bookingdata)) {
				$tickets 	= unserialize($bookingdata->order_t_id);
				$ttitle		= unserialize($bookingdata->order_t_title);
				$tqty		= unserialize($bookingdata->order_t_qty);
				$tprice		= unserialize($bookingdata->order_t_price);
				$tfees		= unserialize($bookingdata->order_t_fees);
				$data = array();

				foreach($tickets as $key => $ticket){
					// $data['test'] = (string)123.4;
					$data['ticket_title'][$key] 	= (string) $ttitle[$key];
					$data['ticket_price'][$key] 	= (floatval($tprice[$key]) == 0 )?'Free':(string)(floatval($tprice[$key]) + floatval($tfees[$key]));
					$data['tickets_qty'][$key]  	= (string)$tqty[$key];
					$data['ticket_sub_total'][$key] = (floatval($tprice[$key]) == 0 )?'Free':(string)((floatval($tprice[$key]) + floatval($tfees[$key]) ) * intval($tqty[$key]));
				}
				$data['event_name'] 		= (string)$bookingdata->event_name;
				$data['total_tickets'] 		= (string)$bookingdata->order_tickets;
				$data['event_start_date']	= (string)$bookingdata->event_start_datetime;
				$data['event_end_date'] 	= (string)$bookingdata->event_end_datetime;
				$data['total_amount'] 		= (string)$bookingdata->order_amount;
				$data['order_id'] 			= (string)$bookingdata->order_id;
				$data['organization_link'] 	= (string)route('org.detail',$bookingdata->org_slug);
				$data['pdf_link'] 			= (string)asset('/upload/ticket-pdf/'.$bookingdata->order_id.'-'.$bookingdata->event_id.'.pdf');
				
				if (!empty($data)) {
					$message = 'Order Summery';
					return $this->getSuccessResult($data,$message,true);
				}
			}else{
				$message = "Order not found";
	            return $this->getErrorMessage($message);
			}
		}else{
			$message = "User not Login";
            return $this->getErrorMessage($message);
		}
	}

	public function upcomingOrder(){
		if (Auth::guard('api')->check()) {
			$id = auth()->user()->id;
			$book = $this->bookmark->saved_events($id);
			$data = $this->ticket_booking->bookTheevents($id);
			
			if(!$data->isEmpty()){
				foreach ($data as $key => $value) {
					$data[$key] = $value;
					$data[$key]['event_image'] = getImage($value->event_image);
					$ordertik[$key] = $value->order_tickets;
				}

            	$output['likes']	= count($book);
            	$output['ticket']	= !empty($ordertik)?array_sum($ordertik):0;
            	$output['orders']	= $data;
            	$message = 'Upcoming Orders';
				return $this->getSuccessResult($output,$message,true);
            }else{
            	$message = "Upcoming order not found";
	            return $this->getErrorMessage($message);
            }
		}else{
			$message = "User not Login";
            return $this->getErrorMessage($message);
		}
	}
	
	/* Past Order Data */	
	public function pastOrder() {
		if (Auth::guard('api')->check()) {
			$id = auth()->user()->id;
			$data = $this->ticket_booking->pastEventsByApi($id);
			if(!$data->isEmpty()){
				foreach ($data as $key => $value) {
					$data[$key] = $value;
					$data[$key]['event_image'] = getImage($value->event_image);
				}
				$output		= $data;
				$message 	= 'Past Orders';
				return $this->getSuccessResult($output,$message,true);
			} else {
            	$message = "Past order not found";
	            return $this->getErrorMessage($message);
            }
		}else{
			$message = "User not Login";
            return $this->getErrorMessage($message);
		}
	}	

	/* Order Tickets Data */
	public function ordTickets($order_id){
		if (Auth::guard('api')->check()) {
			$data = array();
			$datas = $this->order_tickets->userWiseOrd($order_id);
			$path = 'upload/ticket-qr';

			if(!$datas->isEmpty()){
				foreach ($datas as $key => $value) {
					$data[$key]= $value;
					$data[$key]['ot_qr_image'] 			=  asset('/'.$path.'/'.$value->ot_qr_image);
					$data[$key]['event_org_name'] 		= orgDetails($value->event_org_name)->Name;
					$data[$key]['ticket_title']			=	! is_null($value->ticket_title)?$value->ticket_title:'';
					$data[$key]['ticket_description']	=	! is_null($value->ticket_description)?$value->ticket_description:'';
				}
				$output		= $data;
				$message 	= 'Order Tickets';
				return $this->getSuccessResult($output,$message,true);
            }else{
            	$message = "Tickets not found";
	            return $this->getErrorMessage($message);
            }
		}else{
			$message = "User not Login";
            return $this->getErrorMessage($message);
		}
	}	
}


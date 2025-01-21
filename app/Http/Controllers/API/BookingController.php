<?php
namespace App\Http\Controllers\API;

use PDF;
use Mail;
use File;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;
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
 		// return response()->json($input);
 		if (auth()->check()) {
			$client_token		= str_shuffle(str_random(45));
			$bookingOrder_id	= generate_booking_code($input['event_id']);

			$bookingData['event_id'] 		= $input['event_id'];
			$bookingData['user_id']			= Auth::user()->id;
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
				// $ticket_update = $this->event_ticket->decres_ticket_qty($ticketId, intval($quanty));
				//$ticket_data['ticket_remaning_qty']	= intval($ticket->ticket_remaning_qty) - intval($quanty);
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
				return response()->json($this->getSuccessResult(['token' => $data->client_token]),200);
			}else{
				return response()->json($this->noContent());
			}
 		}else{
 			return response()->json($this->getErrorMessage('462'));
 		}
 	}
 	public function register($token) {
 		if (auth()->check()) {
			$bookingdata	= $this->ticket_booking->getDataAPI($token);
			if(is_null($bookingdata)){
	 		 	return response()->json($this->notFound());
	 		}			
			if(! is_null($bookingdata)){
				$otid = unserialize($bookingdata->order_t_id);
				$ottit = unserialize($bookingdata->order_t_title);
				$oty = unserialize($bookingdata->order_t_qty);
				$otp = unserialize($bookingdata->order_t_price);
				$otf = unserialize($bookingdata->order_t_fees);

				$bookingdata['order_t_id'] = $otid;
				$bookingdata['order_t_title'] = $ottit;
				$bookingdata['order_t_qty'] = $oty;
				$bookingdata['order_t_price'] = $otp;
				$bookingdata['order_t_fees'] = $otf;
				return response()->json($this->getSuccessResult($bookingdata),200);
			}else{
				return response()->json($this->noContent());
			}

		}else{
			return response()->json($this->getErrorMessage('462'));
		}
	}
	public function orderStore(Request $request) {
		$input = $request->all();
		if(auth()->check()){	
			$bookingdata = $this->ticket_booking->getOrderData($input['order_id']);
			if($bookingdata->order_status == 2){
				$data = $this->orderCancel($bookingdata->order_id);
				return response()->json($data);
			}

			$organization = $this->organization->findDataId($bookingdata->event_org_name);
			$oderTickets['ot_order_id']	= $input['order_id'];
			$oderTickets['ot_event_id']	= $input['event_id'];
			$oderTickets['ot_user_id']	= $input['user_id'];

			$ordData = $this->order_tickets->countTickets($input['order_id']);
			if(isset($ordData) && $ordData != 0 ){
				$this->order_tickets->deleteOrder($input['order_id']);
			}

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
			if(floatval($bookingdata->order_amount) <= 0){
				return response()->json($this->getSuccessResult($bookingdata),200);
			}else{
				if (! empty($bookingdata)) {
					return response()->json($this->getSuccessResult($bookingdata),200);
				}else{
					return response()->json($this->noContent());
				}
			}
		}else{
			return response()->json($this->getErrorMessage('462'));
		}
	}
	public function payments(Request $request,$orders_id) {
		if(auth()->check()){
			$dats = $request->all();
			$input['client_token']	= str_shuffle(csrf_token());
			$input['order_status']	= '1';
			$this->ticket_booking->updateData($input,$orders_id);
			$orderData	= $this->ticket_booking->getOrderData($orders_id);
			if($orderData->order_amount > 0){
			}
			if(isset($_POST['stripeToken'])) {
                $s_token        = $_POST['stripeToken'];
                $s_amount       = number_format(($orderData->order_amount), 2, '', '');
                $s_currency     = use_currency()->type;
                $s_description  = 'Charge for - '.$_POST['stripeEmail'];
                $this->paymentController = new PaymentController();
                $payment_status = $this->paymentController->stripeCharges($s_token, $s_amount, $s_currency, $s_description);
			}	
			$path = 'upload/ticket-pdf/';
			if (!is_dir(public_path($path))) {
	            File::makeDirectory(public_path($path),0777,true);
	        }
	        $pdf_save_path = $path . $orders_id . '-' . $orderData->event_id .'.pdf';
			$bookingdata = $this->order_tickets->orderTickets($orders_id);
			view()->share('bookingdata',$bookingdata);		
			$pdf = PDF::loadView('theme.pdf.pdfview');
			$pdf->setOptions(
				[
					'dpi' 			=> 150,
					'defaultFont' 	=> 'sans-serif',
					'isPhpEnabled' 	=> true,
					'isRemoteEnabled' => true,
					'isHtml5ParserEnabled' => true,
					'setIsRemoteEnabled'=>true,	
			 	]
			);
			$pdf->setPaper('a4','portrait')->setWarnings(false);
			$pdf->save('public/'.$pdf_save_path);
			//return $pdf->stream();
			$pdf_path = public_path().$pdf_save_path;
			$mail = array($orderData->user_email);        
	    	Mail::send('theme.pdf.mail',['orderData'=>$orderData],function($message) use ($mail,$pdf_path)
	        {
	            $message->from(frommail(), forcompany());
	            $message->to($mail);
	            $message->subject(trans('words.msg.e_tic_ord'));
	            $message->attach($pdf_path);
	        });
	    	if (! empty($dats)) {
    			OrderPayment::create($dats);
	    	}
	        if (! is_null($orders_id)) {
		        	$data = $this->orderSuccess($orders_id);
					return response()->json($this->getSuccessResult($data),200);
				}else{
					return response()->json($this->noContent());
				}
			return response()->json($this->getErrorMessage('462'));
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
		}else{
			return response()->json($this->noContent());
		}
		return response()->json($this->getErrorMessage('462'));
	}
	public function orderCancel($order_id)	{
		if(auth()->check()){
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
				return response()->json($this->getSuccessResult($data),200);
			}else{
				return response()->json($this->noContent());
			}
			return response()->json($this->getErrorMessage('462'));
		}
	}

	public function ordBook(){
		if (auth()->check()) {
			$id = auth()->user()->id;
			$book = $this->bookmark->saved_events($id);
			$data = $this->ticket_booking->bookTheevents($id);
			
			foreach ($data as $key => $value) {
				$data[$key] = $value;
				$data[$key]['event_image'] = getImage($value->event_image);
				$ordertik[$key] = $value->order_tickets;
			}

			// $data = array_flatten($data);			
            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            $result['status'] = ['code' => 200, 'msg' =>''];
            $result['likes']  = count($book);
            $result['ticket'] = !empty($ordertik)?array_sum($ordertik):0;	
        	$result['result'] = $data;
            return response()->json($result,200);
		}else{
			return response()->json($this->getErrorMessage('462'));
		}
	}
	public function ordTickets($order_id){
		if (auth()->check()) {
			$data = array();
			$datas = $this->order_tickets->userWiseOrd($order_id);			
			$path = 'upload/ticket-qr';
			foreach ($datas as $key => $value) {
				$data[$key]= $value;
				$data[$key]['ot_qr_image'] =  asset('/'.$path.'/'.$value->ot_qr_image);
				// $data[$key]['ot_qr_image'] =  getQrImage($value->ot_qr_image);
				$data[$key]['event_org_name'] = orgDetails($value->event_org_name)->Name;
				$data[$key]['ticket_title']			=	! is_null($value->ticket_title)?$value->ticket_title:'';
				$data[$key]['ticket_description']	=	! is_null($value->ticket_description)?$value->ticket_description:'';
			}
			// $data = array_flatten($data);
            if (empty($data)) {        	 	
            	$msg = array('status'=>array('code'=> 204,'msg' => "No Tickets Found"));
        		return $msg;                
            }
			return Response::json($this->getSuccessResult($data),200);
		}else{
			return response()->json($this->noContent());
		}
	}
	public function orderSummery($order_id)
	{
		if (auth()->check()) {
			$bookingdata = $this->ticket_booking->getOrderData($order_id);
			if (is_null($bookingdata)) {
				return response()->json($this->noContent());
			}			
			$tickets 	= unserialize($bookingdata->order_t_id);
			$ttitle		= unserialize($bookingdata->order_t_title);
			$tqty		= unserialize($bookingdata->order_t_qty);
			$tprice		= unserialize($bookingdata->order_t_price);
			$tfees		= unserialize($bookingdata->order_t_fees);
			$data = array();

			foreach($tickets as $key => $ticket){
				// $data['test'] = (string)123.4;
				$data['ticket_title'][$key] =  $ttitle[$key];
				$data['ticket_price'][$key] = (floatval($tprice[$key]) == 0 )?'Free':(string)(floatval($tprice[$key]) + floatval($tfees[$key]));
				$data['tickets_qty'][$key]  = $tqty[$key];
				$data['ticket_sub_total'][$key] = (floatval($tprice[$key]) == 0 )?'Free':(string)((floatval($tprice[$key]) + floatval($tfees[$key]) ) * intval($tqty[$key]));
			}
				$data['event_name'] = $bookingdata->event_name;
				$data['total_tickets'] = (string)$bookingdata->order_tickets;
				$data['event_start_date'] = $bookingdata->event_start_datetime;
				$data['event_end_date'] = $bookingdata->event_end_datetime;
				$data['total_amount'] = $bookingdata->order_amount;
				$data['order_id'] = $bookingdata->order_id;
				$data['organization_link'] = route('org.detail',$bookingdata->org_slug);
				$data['pdf_link'] = asset('/upload/ticket-pdf/'.$bookingdata->order_id.'-'.$bookingdata->event_id.'.pdf');
			if (empty($data)) {
				return response()->json($this->noContent());
			}
			return response()->json($this->getSuccessResult($data),200);
		}else{
			return response()->json($this->getErrorMessage('462'));
		}
	}
	public function pastEvents() {
		if (auth()->check()) {
			$id = auth()->user()->id;
			$data = $this->ticket_booking->pastEventsByApi($id);
			foreach ($data as $key => $value) {
				$data[$key] = $value;
				$data[$key]['event_image'] = getImage($value->event_image);
			}
			// dd($data);
			// dd($data->getFrom());
			// $data = array_flatten($data);
            if (empty($data)) {
                return response()->json($this->noContent());
            }
            return response()->json($this->getSuccessResult($data),200);
		}else{
			return response()->json($this->getErrorMessage('462'));
		}
	}	
}


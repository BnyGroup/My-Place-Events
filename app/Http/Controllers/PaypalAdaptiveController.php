<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\Http\Requests;
use App\Booking;
use App\OrderPayment;

 use Paypal;
 use PayPal\Core\PPHttpConfig;
 use PayPal\Service\AdaptivePaymentsService;
 use PayPal\Types\AP\FundingConstraint;
 use PayPal\Types\AP\FundingTypeInfo;
 use PayPal\Types\AP\FundingTypeList;
 use PayPal\Types\AP\PayRequest;
 use PayPal\Types\AP\Receiver;
 use PayPal\Types\AP\ReceiverList;
 use PayPal\Types\AP\SenderIdentifier;
 use PayPal\Types\AP\PaymentDetailsRequest;
 use PayPal\Types\Common\PhoneNumberType;
 use PayPal\Types\Common\RequestEnvelope;



class PaypalAdaptiveController extends FrontController
{
     private $_apiContext;
   	 public function __construct() {
   	 	parent::__construct();
   	 	$this->ticket_booking = new Booking;
   	 	$this->order_payment = new OrderPayment;

         $this->_apiContext = array(
            'mode'               => config('services.paypal.mode'),
             'acct1.UserName'    => config('services.paypal.user_name'),
             'acct1.Password'    => config('services.paypal.password'),
             'acct1.Signature'   => config('services.paypal.signature'),
             "acct1.AppId"       => config('services.paypal.app_id'),

             'http.ConnectionTimeOut'    => 30,
             'log.LogEnabled'            => true,
             'log.FileName'              => storage_path('logs/paypal.log'),
             'log.LogLevel'              => 'FINE'
         );
     }

    /**
     * Redirect to Paypal.
     */
     public function redirect($option, $payKey = '')
     {
         //     'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-5KA63182B5063103D'
         $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=';
         if ($option == 'approved') {
             $url .= '_ap-payment&paykey='.$payKey;
         } elseif ($option == 'pre-approved') {
             $url .= '_ap-preapproval&preapprovalkey='.$payKey;
         }
         return $url;
     }

    /**
     * Ask Paypal for a token
     */
     public function adaptiveChackout(Request $request){

     	$order_data = json_decode($request->input('order_data'));
     	$order_data->event_booking_id;
     	$bookingdata	= $this->ticket_booking->singleOrder($order_data->event_booking_id);
     	if(!isset($bookingdata) && empty($bookingdata)){
     		\App::abort(404, 'Somthing is wrong! Please try again.');
     	}
         if($bookingdata->order_status == 2)
             return redirect()->route('order.cancel',$bookingdata->order_id);

         $input_order['order_status']  = '3';
         $this->ticket_booking->updateData($input_order,$bookingdata->order_id);
         /* ================================================= */
         $requestEnvelope    = ['errorLanguage' => 'en_US'];
         $cancelUrl          = route('order.cancel',$bookingdata->order_id);
         $returnUrl          = route('adaptive.getDone',$bookingdata->order_id);
         $currencyCode       = config('services.paypal.currency');
         $memo               = "Adaptive Payment - chained Payment";
         $actionType         = "PAY"; /*CREATE*/
         $feesPayer          = "PRIMARYRECEIVER";

         $trackingId         = uniqid().time();

    //     /* ================================================= */

         $orderAmount = number_format($bookingdata->order_amount,2);
         $commission = number_format($orderAmount*(event_commission()/100),2);
         $agent_amount = number_format($orderAmount-$commission,2);
         //dd($orderAmount, event_commission(), $commission, $agent_amount);
         // Your request
         $paypalId = UserPaypalEmail($bookingdata->event_create_by);
         if(!isset($paypalId) && empty($paypalId)){
             $_POST['receiverEmail']     = [config('services.paypal.reciverEmail')];
             $_POST['receiverAmount']    = [$orderAmount];
             $_POST['receiverPrimary']   = [true];
         }else{
             $_POST['receiverEmail']     = [config('services.paypal.reciverEmail'),$paypalId->value];
             $_POST['receiverAmount']    = [$orderAmount,$agent_amount];
             $_POST['receiverPrimary']   = [true,false];
         }

         $receiver = [];
         for ($i = 0; $i < count($_POST['receiverEmail']); ++$i) {
             // Parallel Payments
             $receiver[$i]           = new Receiver();
             $receiver[$i]->email    = $_POST['receiverEmail'][$i];
             $receiver[$i]->amount   = $_POST['receiverAmount'][$i];
             $receiver[$i]->primary  = $_POST['receiverPrimary'][$i];
             $receiver[$i]->invoiceId = $bookingdata->order_id;
         }

         $receiverList   = new ReceiverList($receiver);
         //dd($receiverList);
         $payRequest     = new PayRequest(new RequestEnvelope("en_US"), $actionType, $cancelUrl, $currencyCode, $receiverList, $returnUrl);
         if ($memo != "") {
             $payRequest->memo = $memo;
         }
         if($feesPayer != "") {
             $payRequest->feesPayer = $feesPayer;
         }
         if(isset($trackingId) && $trackingId != "") {
             $payRequest->trackingId  = $trackingId;
         }

         $config     = $this->_apiContext;
         $service    = new AdaptivePaymentsService($config);

         try {
             /* wrap API method calls on the service object with a try catch */
             $response = $service->Pay($payRequest);
             //dd($response);
             $ack = strtoupper($response->responseEnvelope->ack);
             if ($ack == "SUCCESS") {
                 $payKey = $response->payKey;
                 \session(['pay_key' => $payKey]);
                 $payPalURL =  $this->redirect('approved', $response->payKey);
                 return redirect()->to( $payPalURL );
             }else{
                 return redirect($cancelUrl);
             }
         } catch (Exception $ex) {
             dd($ex);
         }
     }

     public function getDone($order_id, Request $request) {

         $requestEnvelope = new RequestEnvelope("en_US");
         $paymentDetailsReq = new PaymentDetailsRequest($requestEnvelope);
         //dd($request->session()->get('pay_key'));
         if ($request->session()->get('pay_key') != "") {
             $paymentDetailsReq->payKey = $request->session()->get('pay_key');
         }
         $service = new AdaptivePaymentsService($this->_apiContext);
         $response = $service->PaymentDetails($paymentDetailsReq);
         //dd($response);
         $bookingdata    = $this->ticket_booking->singleOrder($order_id);

         $order_payment['payment_user_id']       = $bookingdata->user_id;
         $order_payment['payment_order_id']      = $bookingdata->order_id;
         $order_payment['payment_event_id']      = $bookingdata->event_id;
         $order_payment['payment_amount']        = $bookingdata->order_amount;
         $order_payment['payment_currency']      = config('services.paypal.currency');
         $order_payment['payment_status']        = 'Done';
         $order_payment['payment_gateway']       = 'paypal-adaptive-payment';

         $data = $this->order_payment->insertData($order_payment);
         return redirect()->route('ticket.oderdone', $order_id);
     }
}

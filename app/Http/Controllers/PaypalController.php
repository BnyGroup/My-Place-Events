<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\Http\Requests;
use App\Booking;
use App\OrderPayment;
use App\Organization;
use App\Prestataire;
use App\SouscPrestataire;
use App\Http\Controllers\CinetPay;
use Carbon\Carbon;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;

use URL;

class PaypalController extends FrontController
{
    private $_api_context;

   	public function __construct() {
   		parent::__construct();
   		$this->ticket_booking = new Booking;
   		$this->order_payment = new OrderPayment;
        $this->organization = new Organization;
        $this->prestataires = new Prestataire;
        $this->souscprestataires = new SouscPrestataire;

        /** setup PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function payPremium() {
    	return view('payPremium');
    }

    public function getCheckout(Request $request) {

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


        $this->getDone($bookingdata->order_id,$request);

        //return response()->json(['success' => 1,'done' => route('getDone',$bookingdata->order_id)]);

         $payer = new Payer();
         $payer->setPaymentMethod('paypal');

         $amount = new Amount();
         $amount->setCurrency(config('services.paypal.currency'))
         ->setTotal(intval($bookingdata->order_amount));

         $transaction = new Transaction();
         $transaction->setAmount(intval($bookingdata->order_amount))
             ->setDescription('Order Id : '.$bookingdata->order_id.' - Pay Amount : '.$bookingdata->order_amount);

         $redirect_urls = new RedirectUrls();
         $redirect_urls->setReturnUrl(route('getDone',$bookingdata->order_id))
             ->setCancelUrl(route('order.cancel',$bookingdata->order_id));

         $payment = new Payment();
         $payment->setIntent('Sale')
             ->setPayer($payer)
             ->setRedirectUrls($redirect_urls)
             ->setTransactions(array($transaction));

         try {
             $response = $payment->create($this->_api_context);
             dd($response);

//         }catch (\PayPal\Exception\PPConnectionException $ex) {
         }catch (\PayPal\Exception\PayPalConnectionException $ex) {
             if (\Config::get('app.debug')) {
                 \Session::put('error','Connection timeout');
                 return \Redirect::route('payment.status');
             } else {
                 \Session::put('error','Some error occur, sorry for inconvenient');
                 return \Redirect::route('payment.status');
             }
         }
         foreach($payment->getLinks() as $link) {
             if($link->getRel() == 'approval_url') {
                 $redirect_url = $link->getHref();
                 break;
             }
         }
         \Session::put('paypal_payment_id', $payment->getId());

         if(isset($redirect_url)) {
             return \Redirect::away($redirect_url);
         }
         \Session::put('error','Unknown error occurred');
         return \Redirect::route('payment.status');
	}


	public function getDone($order_id, Request $request) {

		$bookingdata	= $this->ticket_booking->singleOrder($order_id);

	     /*$id = $request->get('paymentId');
	     $token = $request->get('token');
	     $payer_id = $request->get('PayerID');

	     $payment = new getById($id, $this->_apiContext);
	     $paymentExecution = new PaymentExecution();
	   	 $paymentExecution->setPayerId($payer_id);
	     $executePayment = $payment->execute($paymentExecution, $this->_apiContext);
	     echo $executePayment->state;
	   	 dd($executePayment); */

	    $order_payment['payment_user_id']		= $bookingdata->user_id;
	    $order_payment['payment_order_id']		= $bookingdata->order_id;
	    $order_payment['payment_event_id']		= $bookingdata->event_id;
	    $order_payment['payment_amount']		= $bookingdata->order_amount;
	    $order_payment['payment_currency']		= config('services.paypal.currency');
	    $order_payment['payment_status']		= 'Done';
	    $order_payment['payment_gateway']		= 'paypal-checkout';

		$data = $this->order_payment->insertData($order_payment);
	    return redirect()->route('ticket.oderdone', $order_id);
	}

	public function getCancel($order_id) {
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
		return view('theme.booking.cancel', compact('bookingdata'));
		//echo "Cancel";
	    //return redirect()->route('payPremium');
	}

//    public function returnDirectPay(Request $request){

        //$bookingdata	= $this->ticket_booking->singleOrder($order_id);
       /* $data = $request->all();
        dd( $request);
        $order_payment['payment_user_id']		= $bookingdata->user_id;
        $order_payment['payment_order_id']		= $bookingdata->order_id;
        $order_payment['payment_event_id']		= $bookingdata->event_id;
        $order_payment['payment_amount']		= $bookingdata->order_amount;
        $order_payment['payment_currency']		= config('services.paypal.currency');
        $order_payment['payment_status']		= 'Done';
        $order_payment['payment_gateway']		= 'paypal-checkout';

        $data = $this->order_payment->insertData($order_payment);
        return redirect()->route('ticket.oderdone', $order_id);

    }*/

  /*  public function returnDirectPay2(Request $request){

        //$bookingdata	= $this->ticket_booking->singleOrder($order_id);
        $data = $request->all();

        dd('xa MARCHE');
        /*$order_payment['payment_user_id']		= $bookingdata->user_id;
        $order_payment['payment_order_id']		= $bookingdata->order_id;
        $order_payment['payment_event_id']		= $bookingdata->event_id;
        $order_payment['payment_amount']		= $bookingdata->order_amount;
        $order_payment['payment_currency']		= config('services.paypal.currency');
        $order_payment['payment_status']		= 'Done';
        $order_payment['payment_gateway']		= 'paypal-checkout';

        $data = $this->order_payment->insertData($order_payment);
        //return redirect()->route('ticket.oderdone', $order_id);

    }*/



    public function createOrder($order_id){
        $bookingdata	= $this->ticket_booking->getOrderData($order_id);
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');

        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $order_id,
                "amount" => [
                    "value" => "0.01",
                    "currency_code" => "EUR"
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('pp.cancel'),
                "return_url" => route('pp.return')
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $client = PayPalClient::client();
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //dd($response);
            print_r($response);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
        return redirect()->route('pp.capture',['order_id' => $order_id]);

    }

    public function captureOrder($order_id){
        $request = new OrdersCaptureRequest("APPROVED-ORDER-ID");
        $request->prefer('return=representation');

        try {
            // Call API with your client and get a response for your call
            $client = PayPalClient::client();
            dd($client);
            $response = $client->execute($request);


            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            dd($response, $order_id);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function getOrder($eventOrderId, $orderId){
        // 3. Call PayPal to get the transaction details
        $client = PayPalClient::client();
        $response = $client->execute(new OrdersGetRequest($orderId));
        /**
         *Enable the following line to print complete response as JSON.
         */
        //print json_encode($response->result);
        print "Status Code: {$response->statusCode}\n";
        print "Status: {$response->result->status}\n";
        print "Order ID: {$response->result->id}\n";
        print "Intent: {$response->result->intent}\n";
        print "Links:\n";
        foreach($response->result->links as $link)
        {
            print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
        }
        // 4. Save the transaction in your database. Implement logic to save transaction to your database for future reference.
        print "Gross Amount: {$response->result->purchase_units[0]->amount->currency_code} {$response->result->purchase_units[0]->amount->value}\n";

        $bookingdata	= $this->ticket_booking->singleOrder($eventOrderId);


        $payment_completed = 0;
        $organization	= $this->organization->findDataId($bookingdata->event_org_name);
        $orderSessionTime = NULL;
        if (\Session::has('order_id')){
            $orderUid = array_column(\Session::get('order_id'), 'order_uid');
            if(in_array($bookingdata->order_id, \Session::get('order_id'))) {
                $orderSessionTime = (strtotime($bookingdata->BOOKING_ON) + env('BOOKING_TIME', '600')) * 1000;
            }
        }
        if($response->statusCode >= 200 && $response->statusCode < 400){
            $payment_completed = 1;
            $order_payment['payment_user_id']		= $bookingdata->user_id;
            $order_payment['payment_order_id']		= $bookingdata->order_id;
            $order_payment['payment_event_id']		= $bookingdata->event_id;
            $order_payment['payment_amount']		= $bookingdata->order_amount;
            $order_payment['payment_currency']		= config('services.paypal.currency');
            $order_payment['payment_status']		= 'Done';
            $order_payment['payment_gateway']		= 'paypal-checkout';
            $data = $this->order_payment->insertData($order_payment);
        }//else{
            //return route('')
        //}
        return view('theme.booking.ticket-payment',compact('bookingdata','organization','paypalId','orderSessionTime','payment_completed'));

        //return redirect()->route('index');
        // To print the whole response body, uncomment the following line
        // echo json_encode($response->result, JSON_PRETTY_PRINT);
    }

    public function prestatairePayment($paypalOrderId){

        $client = PayPalClient::client();
        $response = $client->execute(new OrdersGetRequest($paypalOrderId));
        dd($response);
        print "Status Code: {$response->statusCode}\n";
        print "Status: {$response->result->status}\n";
        print "Order ID: {$response->result->id}\n";
        print "Intent: {$response->result->intent}\n";
        print "Links:\n";
        foreach($response->result->links as $link)
        {
            print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
        }

        $idFront = auth()->guard('frontuser')->user()->id;
        $idPrest = $response->result->purchase_units[0]->amount->reference_id;
        $iinput = array();
        $iinput['id_frontuser'] = $idFront;
        $iinput['id_prestataire'] = $idPrest;
        $iinput['formule'] = $response->result->purchase_units[0]->amount->description;
        $iinput['montant'] = $response->result->purchase_units[0]->amount->value;
        $iinput['status'] = 0;
        $iinput['payment_id'] = $idFront.'-'.$idPrest.'-'.$paypalOrderId;
        $iinput['payment_gateway'] = 'PAYPAL';
        $this->souscprestataires->insertData($iinput);

        $prestataires = Prestataire::where('id',$idPrest)->first();
        if($response->statusCode >= 200 && $response->statusCode < 400) {
            $souscPrestataires = SouscPrestataire::where('payment_id',$iinput['payment_id'])->first();
            $formuleService = FormuleService::where('id_service',3)->first();

            if($iinput['montant']%$formuleService->montant_service != 0)
            {
                $this->souscprestataires->deleteLastUpdate($idFront);
                return redirect()->route('pre.index')->with('erreur', 'Erreur lors du paiement, veullez reessayer');
            }

            if($souscPrestataires->formule != $iinput['montant']/$formuleService->montant_service){
                $this->souscprestataires->deleteLastUpdate($idFront);
                return redirect()->route('pre.index')->with('erreur', 'Erreur lors du paiement, veullez reessayer');
            }
            $input['status'] = 1;
            //$input['payment_expire'] = $paymentDate->addMonth($souscPrestataires->formule);
            $input['payment_trans_status'] = 'SUCCES';
            $input['payment_amount'] = $iinput['montant'];
            /*$input['payment_phone_prefixe'] = $cpm_phone_prefixe;*/
            /*$input['payment_phone_number'] = $cel_phone_num;*/
            /*$input['payment_ipn_ack'] = $cpm_ipn_ack;*/
            $input['payment_designation'] = 'Paiement-'.Carbon::now()  ;
            $input['payment_buyer_name'] = $prestataires->pseudo;
            $input['payment_date'] = Carbon::now();

            $this->souscprestataires->updateLastData($idPrest, $input);
            Prestataire::where('id',$idPrest)->update('status',2);

            return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
        }else{
            $input['payment_trans_status'] = 'ECHEC';
            $input['payment_date'] = Carbon::now();
            $input['payment_buyer_name'] = $prestataires->pseudo;
            $this->souscprestataires->updateLastData($idPrest, $input);
            return redirect()->route('pre.index')->with('error', 'Un problème est survenu, veuillez contacter l\'administrateur');
        }

        //$this->souscprestataires->insertData($iinput);
    }
    public function cancelUrl(){
        $id = auth()->guard('frontuser')->user()->id;
        $this->souscprestataires->deleteLastUpdate($id);
        return redirect()->route('pre.index')->with('erreur', 'vous avez annulé votre transaction');
    }
}

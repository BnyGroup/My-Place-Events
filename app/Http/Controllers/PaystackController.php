<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\PaystackPayment;
use App\GuestUser;
use App\EventTicket;
use App\orderTickets;
use App\FormuleService;
use App\Frontuser;
use App\AluPayment;
use App\StoreRegularise;
use App\Booking;
use App\Prestataire;
use App\SouscPrestataire;
use App\PrestataireCategory;
use App\OrderPayment;
use App\Refund;
use App\ALaUne;
use App\Event;
use App\Slider;
use App\Commande;
use Carbon\Carbon;
use Paystack;
use Mail;


class PaystackController extends FrontController
{
    /**
     * Return URL.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->ticket_booking = new Booking;
        $this->order_payment = new OrderPayment;
        $this->refund = new Refund;
        $this->guest_user= new GuestUser;
        $this->event_ticket = new EventTicket;
        $this->order_tickets = new orderTickets;
        $this->ticket_controller = new TicketController;
        $this->souscprestataires = new SouscPrestataire;
        $this->alupayment = new AluPayment;
        $this->commande = new Commande;
    }

    public function send_message_to_admin($mailtoadmin){

        $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com');
        try {
            Mail::send('Admin.mail.message-to-admin',['orderData'=>$mailtoadmin],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Messsage à l\'admin');
            });
        } catch (\Exception $e) {
            dd($e);
            //return redirect()->route('index');
        }
    }

    public function send_message_to_admin_for_ticket_paid($mailtoadmin, Event $event){
        $event_create_by = Frontuser::where('id', $event->event_create_by)->first();

        $orderData = $mailtoadmin;
        //dd($orderData);
        $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com','christelle.abeu@myplace-events.com',$event_create_by->email);
        try {
            Mail::send('Admin.mail.message_ticket_paid',['orderData'=>$orderData],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Ticket(s) acheté(s) sur My Place Events');
            });
        } catch (\Exception $e) {
            dd($e);
            //return redirect()->route('index');
        }
    }

    public function send_simple_message($destinataire,$text){
        $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com',$destinataire, 'christelle.abeu@myplace-events.com');
        try {
            Mail::send('Admin.mail.message-to-admin',['orderData'=>$text],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('message');
            });
        } catch (\Exception $e) {
            dd($e);
            //return redirect()->route('index');
        }
    }

    public function redirectToGateway(Request $request)
    {
        $this->ticket_booking->updateData(['order_status' => 5], $request->input('orderID'));
        
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'Le jeton de paie a expiré. Veuillez actualiser la page et réessayer.', 'type'=>'error']);
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        //dd($paymentDetails);

            // dd($paymentDetails);
            // Now you have the payment details,
            // you can store the authorization_code in your db to allow for recurrent subscriptions
            // you can then redirect or do whatever you want
            //   [ 'email','amount', 'status', 'trans_id','ref_id'];

            $payment=new PaystackPayment();

            $payment->email=$paymentDetails['data']['customer']['email'];
            $payment->order_id=$paymentDetails['data']['metadata']['order_id'];
            $payment->status=$paymentDetails['data']['status'];
            $payment->amount=$paymentDetails['data']['amount']/100;
            $payment->trans_id=$paymentDetails['data']['id'];
            $payment->ref_id=$paymentDetails['data']['reference'];

            $order_payment = [];
        switch ($paymentDetails['data']['metadata']['designation']) {
            case 'event_ticket':
                $bookingdata = $this->ticket_booking->singleOrder($paymentDetails['data']['metadata']['order_id']);
                if ($bookingdata->user_id != 0):
                    $order_payment['payment_user_id'] = $bookingdata->user_id/*auth()->guard('frontuser')->user()->id*/
                    ;
                    $order_payment['payment_guest_id'] = null;
                else:
                    $order_payment['payment_user_id'] = 0;
                    $order_payment['payment_guest_id'] = $bookingdata->gust_id;
                endif;
                $order_payment['payment_order_id'] = $bookingdata->order_id;
                $order_payment['payment_event_id'] = $bookingdata->event_id;
                $order_payment['payment_currency'] = 'XOF';
                $order_payment['payment_gateway'] = 'PAYSTACK';
                $order_payment['payment_method'] = $paymentDetails['data']['channel'];
                $order_payment['payment_number'] = $paymentDetails['data']['customer']['phone'];

                $designation = 1;
                break;
//            case 'prestataire' :
//                $dispatchIdTrans = explode('-',$paymentData['cpm_trans_id']);
//                $url_slug = $dispatchIdTrans[0].'-'.$dispatchIdTrans[1];
//                $prestataire = Prestataire::where('url_slug',$url_slug)->first();
//                $order_payment['id_transaction'] = $paymentData['cpm_trans_id'];
//                $order_payment['id_frontuser'] = $prestataire->id_frontusers;
//                $order_payment['id_prestataire'] = $prestataire->id;
//                $order_payment['payment_gateway'] = 'CINETPAY';
//                $order_payment['payment_method'] = $paymentData["payment_method"];
//                $order_payment['payment_number'] = $paymentData["cel_phone_num"];
//
//                $designation = 2;
//                break;
//            case 'Tête de liste':
//                $dispatchIdTrans = explode('-',$paymentData['cpm_trans_id']);
//                $idTdl = $dispatchIdTrans[1];
//                $alu = ALaUne::where('id',$idTdl)->first();
//                $frontuser = Frontuser::where('id',$alu->id_frontuser);
//
//                $order_payment['id_transaction'] = $paymentData['cpm_trans_id'];
//                $order_payment['id_frontuser'] = $alu->id_frontuser;
//                $order_payment['id_alu'] = $alu->id;
//                $order_payment['payment_gateway'] = 'CINETPAY';
//                $order_payment['payment_method'] = $paymentData["payment_method"];
//                $order_payment['payment_number'] = $paymentData["cel_phone_num"];
//                $order_payment['payment_designation'] = $paymentData["cpm_designation"];
//
//
//                $designation = 3;
//
//                break;
//            case 'Slider':
//                $dispatchIdTrans = explode('-',$paymentData['cpm_trans_id']);
//                $idSlider = $dispatchIdTrans[1];
//                $alu = ALaUne::where('id',$idSlider)->first();
//                $frontuser = Frontuser::where('id',$alu->id_frontuser);
//
//                $order_payment['id_transaction'] = $paymentData['cpm_trans_id'];
//                $order_payment['id_frontuser'] = $alu->id_frontuser;
//                $order_payment['id_alu'] = $alu->id;
//                $order_payment['payment_method'] = $paymentData["payment_method"];
//                $order_payment['payment_number'] = $paymentData["cel_phone_num"];
//                $order_payment['payment_designation'] = $paymentData["cpm_designation"];
//
//                $designation = 4;
//                break;

            default :
                break;
        }
        // paiement valide
        if ($paymentDetails['status']) {
            if (isset($designation)):
                if($designation == 1){
                    $montant_reel = $bookingdata->order_amount + arrondi_entier_sup(0.04*$bookingdata->order_amount);
                    $montant_paye = $paymentDetails['data']['amount'] / 100;
//                    dd($montant_paye, $montant_reel, $montant_reel != $montant_paye);
                   
                        //pour les bon paiement
                        $order_payment['payment_state'] = 1;
                        $order_payment['payment_amount'] = number_format($montant_paye,0,',',' ');
                        $order_payment['payment_status'] = 'SUCCESS';
                     
                    $succes_paiement = 1;
                }
                // Pour les prestataires
//                if($designation  == 2){
//                    if($paymentData["cpm_amount"]>=montant_prix_unitaire_prestataire()){
//                        if($paymentData["cpm_amount"]%montant_prix_unitaire_prestataire() != 0){
//                            //Mauvais paiement
//                            $order_payment['formule'] = null;
//                            $order_payment['montant'] = $paymentData["cpm_amount"];
//                            $order_payment['status'] = 2;
//                            $order_payment['payment_trans_status'] = 'MONTANT INCORRECT';
//                            $order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];
//                            $succes_paiement = 2;
//                        }else{
//                            //pour les bon paiement
//                            $order_payment['formule'] = $paymentData["cpm_amount"]/montant_prix_unitaire_prestataire();
//                            $order_payment['status'] = 1;
//                            $order_payment['montant'] = $paymentData["cpm_amount"];
//                            $order_payment['payment_trans_status'] = 'SUCCESS';
//                            $order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];
//                            $succes_paiement = 1;
//                        }
//                    }
//                }
//                if($designation  == 3 || $designation  == 4){
//                    if($paymentData["cpm_amount"]%montant_prix_unitaire_tdl() != 0){
//                        $order_payment['formule'] = null;
//                        $order_payment['montant'] = $paymentData["cpm_amount"];
//                        $order_payment['status'] = 0;
//
//                        $succes_paiement = 2;
//                    }else{
//                        //pour les bon paiement
//                        $order_payment['formule'] = $paymentData["cpm_amount"]/montant_prix_unitaire_prestataire();
//                        $order_payment['status'] = 1;
//                        $order_payment['montant'] = $paymentData["cpm_amount"];
//                        //$order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];
//
//                        $succes_paiement = 1;
//                    }
//                }
            endif;
        }
        // traitement operation dans la bdd
        if (isset($designation)){
            if($designation == 1){
                if ($this->order_payment->no_repeat_payment($bookingdata->order_id)):
                    if ($succes_paiement):
                        //dd($paymentData['cpm_trans_id']);
                        /*return redirect()->route('ticket.oderdone',$paymentData['cpm_trans_id'])*/
                        $this->ticket_controller->orderDone($paymentDetails['data']['metadata']['order_id']);
                        $user = Frontuser::where('id',$bookingdata->user_id)->first();
                        if($user == null) $user = GuestUser::where('guest_id',$bookingdata->gust_id)->first();
                        $event = Event::where('event_unique_id',$bookingdata->event_id)->first();
                        $message = ['user'=>$user, 'event'=>$event, 'bookingdata'=>$bookingdata];
                        $this->send_message_to_admin_for_ticket_paid($message, $event);
                    endif;
                    $data = $this->order_payment->insertData($order_payment);
                    if($succes_paiement != 1):
//                        $cinetpayTrack['designation'] = $paymentData['cpm_designation'];
//                        $cinetpayTrack['payment_method'] = $paymentData['payment_method'];
//                        $cinetpayTrack['telephone'] =  "(.".$paymentData['cpm_phone_prefixe'].") ".$paymentData['cel_phone_num'];
//                        $cinetpayTrack['num_transaction'] =  $paymentData['cpm_trans_id'];
//                        $cinetpayTrack['code_erreur'] =  $paymentData['cpm_trans_status'];
//                        $cinetpayTrack["message"] = $paymentData['cpm_error_message'];
//                        $cinetpayTrack["data_track"] = null;
                        //dd($id_transaction);
//                        $this->cinetpay_track->insertData($cinetpayTrack);
                        return $this->paystack_annulation($paymentDetails['data']['metadata']['order_id']);
                    endif;
                endif;
            }
//            if($designation == 2){
//                if ($this->souscprestataires->no_repeat_payment($paymentData['cpm_trans_id'])):
//                    //dd($paymentData['cpm_trans_id']);
//                    if ($succes_paiement == 1):
//                        $count = $this->souscprestataires->count_sousc_number($prestataire->id);
//                        if($prestataire->status == 3){
//                            Prestataire::where('id',$prestataire->id)->update(['status'=>2]);
//                        }
//                        $message = "Le paiement de la commande <strong>" . $paymentData['cpm_trans_id']. "</strong> s'est éffectué avec succès !<br> Détails : ".$paymentData['cpm_designation'];
//                        $this->send_message_to_admin($message);
//                        $data = $this->souscprestataires->insertData($order_payment);
//                    elseif($succes_paiement == 2):
//                        $message = "Il y a une incohérance dans le paiment n<strong>".$paymentData['cpm_trans_id']."</strong><br>Veuillez contacter l'adminitrateur si vous pensez qu'il s'agit d'une erreur";
//                        $this->send_simple_message($prestataire->adresse_mail,$message);
//                    endif;
//                    if($count>=1 && $prestataire->status == 2){
//                        $data = $this->souscprestataires->insertData($order_payment);
//                        $this->prestataire_controller->AddNewDateExpire($paymentData['cpm_trans_id']);
//                        Prestataire::where('id',$prestataire->id)->update(['status'=>1]);
//                        return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
//                    }elseif($count>=1 && $prestataire->status == 1){
//                        $data = $this->souscprestataires->insertData($order_payment);
//                        $this->AddNewDateExpire($paymentData['cpm_trans_id']);
//                        return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
//                    }else{
//                        $data = $this->souscprestataires->insertData($order_payment);
//                    }
//                endif;
//            }
//            if($designation == 3 || $designation == 4){
//                if ($this->alupayment->no_repeat_payment($paymentData['cpm_trans_id'])):
//                    //dd($paymentData['cpm_trans_id']);
//                    if ($succes_paiement == 1):
//                        if($alu->status_service == 0){
//                            $formule = ($designation == 3)?$paymentData["cpm_amount"]/montant_prix_unitaire_tdl():($designation == 4)?$paymentData["cpm_amount"]/montant_prix_unitaire_slider():"";
//                            $date_fin = Carbon::now()->addWeeks(/*$formule*/1)->format('Y-m-d H:i:s');
//                            ALaUne::where('id',$alu->id)->update(['status_service'=>2,'id_last_transaction'=>$id_transaction]);
//                        }
//                        $message = "Le paiement de la commande <strong>" . $paymentData['cpm_trans_id']. "</strong> s'est éffectué avec succès !<br> Détails : ".$paymentData['cpm_designation'];
//                        $this->send_message_to_admin($message);
//                        $data = $this->alupayment->insertData($order_payment);
//                    elseif($succes_paiement == 2):
//                        $message = "Il y a une incohérance dans le paiment n<strong>".$paymentData['cpm_trans_id']."</strong><br>Veuillez contacter l'adminitrateur si vous pensez qu'il s'agit d'une erreur";
//                        $this->send_simple_message($frontuser->email,$message);
//                    endif;
//                    if($alu->status_service == 1){
//                        $data = $this->alupayment->insertData($order_payment);
//                        ALaUne::where('id',$alu->id)->update(['id_last_transaction'=>$id_transaction]);
//                        $this->prestataire_controller->AddNewDateExpireAlu($paymentData['cpm_trans_id']);
//                        return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
//                    }else{
//                        $data = $this->alupayment->insertData($order_payment);
//                    }
//                endif;
//            }
        }

        if($payment->save())
        {
            return redirect()->route('order.success', $paymentDetails['data']['metadata']['order_id']);
        }
        return $this->paystack_annulation($paymentDetails['data']['metadata']['order_id']);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }

    public function paystack_annulation($order_id){
        //dd($order_id);
        $bookingdata = $this->ticket_booking->getOrderData($order_id);
        $prestataire = $this->souscprestataires->getDataByIdTransaction($order_id);
        $slide_bool = stristr($order_id,"SLIDE");
        $tdl_bool = stristr($order_id,"TDL");

        //dd($bookingdata,$prestataire);
        if($bookingdata == null && $prestataire != null){
            //$id = auth()->guard('frontuser')->user()->id;
            $this->souscprestataires->deletePayment($order_id);
            return redirect()->route('pre.index')->with('erreur', 'vous avez annulé votre transaction');
        }elseif($bookingdata == null && $prestataire == null) {
            if(!$slide_bool){
                return redirect()->route('alu.index')->with('$error','le paiement a echoué');
            }
            if(!$tdl_bool){
                return redirect()->route('alu.index')->with('$error','le paiement a echoué');
            }
            return redirect()->route('pre.index')->with('erreur', 'vous avez annulé votre transaction');
        }elseif($bookingdata != null && $prestataire == null){
            //$session_orderId = Session::get('order_id');
            $session_orderId = \Session::get('order_id');

            if (isset($session_orderId))
                $key = array_search($order_id, $session_orderId);

            /*
            if (session()->has('order_id')) {
               $key = array_search($order_id, $session_orderId);
            }else{
                $key = $order_id;
            }
            */
            if(isset($key) && $key != '')
                \Session::forget('order_id.' . $key);

            $order_ticket_id	= unserialize($bookingdata->order_t_id);
            $order_ticket_qty	= unserialize($bookingdata->order_t_qty);

            foreach ($order_ticket_id as $key => $value) {
                $ticket_update = $this->event_ticket->incres_ticket_qty($value,$order_ticket_qty[$key]);
            }
            $input['client_token']	= str_shuffle(csrf_token());
            $input['order_status']	= '2';
            $this->ticket_booking->updateData($input,$order_id);
            $this->order_tickets->deleteOrder($order_id);
            $this->ticket_booking->deleteBooking($order_id);
            return view('theme.booking.cancel', compact('bookingdata'));
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //

        return View('form');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
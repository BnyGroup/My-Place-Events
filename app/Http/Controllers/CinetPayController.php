<?php
 
namespace App\Http\Controllers;

//require_once __DIR__ . '../vendor/autoload.php';
use App\ALaUne;
use App\Event;
use App\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\FrontController;
use App\Booking;
use App\OrderPayment;
use App\Refund;
use App\GuestUser;
use App\EventTicket;
use App\orderTickets;
//use CinetPay\CinetPay;
use App\Http\Controllers\CinetPay;
//use App\Http\Controllers\Guichet;
//use App\Http\Controllers\Commande;
use Mail;
use App\Http\Controllers\TicketController;
use App\Prestataire;
use App\SouscPrestataire;
use App\PrestataireCategory;
use App\FormuleService;
use App\Frontuser;
use App\AluPayment;
use App\StoreRegularise;
use App\CinetpayTrack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gabievi\Promocodes\Facades\Promocode;
use Illuminate\Support\Facades\DB;
use Helper; 
//use Gabievi\Promocodes\Models\Promocode;
use App\Http\Controllers\CinetPayNew;
use App\Commande;
//use App\Organization;
//use App\Http\Controllers\PrestataireController;

use Illuminate\Support\Facades\Log;


class CinetPayController extends FrontController
{

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
        $this->cinetpay_track = new CinetpayTrack;
        $this->commande = new Commande;
        //$this->commande = new Commande;
        //$this->prestataire_controller = new \App\Http\Controllers\PrestataireController;

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
        $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com','christelle.abeu@myplace-events.com', $event_create_by->email);
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
        $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com', $destinataire, 'christelle.abeu@myplace-events.com');
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

    public function generate_cinetpay_form_old(Request $request){

        $formData = $request->all();
        
        $frontuser = Frontuser::where('id', $order_data->user_id)->first();

        $order_data = json_decode($request->input('order_data'));
        //dd($order_data->designation);
        $bookingdata	= $this->ticket_booking->getOrderData($request->input('order_id'));
        //dd($bookingdata);

        if ($request->has('wallet')) {
                //Paiement avec Wallet
                try {
                    $myWallet = $frontuser->getWallet('default');
                    $myWallet->pay($bookingdata);
                    
                    //Gain de points  Bonus lors d'un payement
                    $myWalletBonus = $frontuser->getWallet('bonus');
                    $deposit = ($this->arrondi_entier_sup($bookingdata->order_amount))*0.001;

                    if ($myWalletBonus != null) {
                    $myWalletBonus->deposit($deposit);
                    } else {
                        $walletBonus = $frontuser->createWallet([
                        'name' => 'My Bonus',
                        'slug' => 'bonus',
                        ]);
                    $walletBonus->deposit($deposit);
                    } 

                    $bonus = $myWalletBonus->balance;
                    if ($bonus >= 100) {
                        //Recharche Wallet E-dari dès que Point bonus superieur aou égale a 100
                        $result = (int)($bonus/100);
                        $myWallet->deposit($result*5000);
                        $myWalletBonus->withdraw($result*100);
                        
                        //Mail de récompense Wallet E-Dari
                        $bookingdata = $this->ticket_booking->getOrderData($request->input('order_id'));
                        $mail = (isset($bookingdata->user_email))?array($bookingdata->user_email):array(guestUserData($bookingdata->gust_id)->email);
                        $mailMessage = '';

                        $lastAmountFromDefaultWallet = $frontuser->transactions
                            ->where('wallet_id', $frontuser->getWallet('default')->id)
							->where('type', 'deposit')
                            ->reverse()
                            ->first()->amount;

                    try {
                            Mail::send('theme.pdf.bonus',['bookingdata'=>$bookingdata,'lastAmountFromDefaultWallet' => $lastAmountFromDefaultWallet],function($message) use ($mail) {
                                $message->from(frommail(), forcompany());
                                $message->to($mail);
                                $message->bcc(['charlene.valmorin@gmail.com','contact@myplace-events.com','christelle.abeu@myplace-events.com']);
                                $message->subject(trans('words.msg.e_tic_ord1'));
                            });
                        }catch (\Exception $e) {
                            $mailMessage = ", Mail Sending Fail !";
                        }
                    }

                    $this->wallet_notification($formData, $bookingdata, $request);
                    return redirect()
                    ->route('order.success', $bookingdata->order_id);

                } catch (\Exception $e) {
                    //dd($e);
                    return redirect()
                    ->route('order.cancel', $bookingdata->order_id);
                }
        }

        if ($request->has('cinetpay')) {
            //dd($formData);
            if(isset($formData['designation']) && $formData['designation'] == 'prestataire'){
                $this->validate($request,[
                    'url_slug'		        => 'required',
                    'identifiant_payeur'    => 'required',
                    'formule'               => 'required',
                    'montant'               => 'required',
                    'pu'                    => 'required',
                ]);
                $prestataire = Prestataire::where('url_slug',$formData['url_slug'])->first();
                $count = $this->souscprestataires->count_sousc_number($prestataire->id);

                $id_transaction = $formData['url_slug'].'-'.date('Hi').$count; // Identifiant du Paiement
                $description_du_paiement = $formData['designation']/*sprintf('Mon produit de ref %s', $id_transaction)*/; // Description du Payment
                $identifiant_du_payeur = $formData['identifiant_payeur']." <br> Détails prestataire : Pseudo <b>$prestataire->pseudo</b> | Nombre de Paiment <b>$count</b> | "; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
                $montant_a_payer = montant_prix_unitaire_prestataire()*$formData['formule']/*mt_rand(100, 200)*/; // Montant à Payer : minimun est de 100 francs sur CinetPay
                $buyer_name = $formData['url_slug'];
                //dd($count,$prestataire,$id_transaction);

            }elseif($request->input('order_data') !== null){
                $order_data = json_decode($request->input('order_data'));

                $id_transaction = $bookingdata->order_id; // Identifiant du Paiement
                $description_du_paiement = $order_data->designation/*sprintf('Mon produit de ref %s', $id_transaction)*/; // Description du Payment
                $identifiant_du_payeur = $order_data->identifiant_payeur; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
                $montant_a_payer = $order_data->amount/*mt_rand(100, 200)*/; // Montant à Payer : minimun est de 100 francs sur CinetPay
                $buyer_name = '-';
                //dd($order_data);
            }elseif(isset($formData['designation']) && $formData['designation'] == 'Slider'){
                $this->validate($request,[
                    'slug'  => 'required'
                ]);

                $slider = ALaUne::where('slug',$formData['slug'])->first(); // occurance du Slider
                $frontuser = Frontuser::where('id',$slider->id_frontuser)->first();
                $count = $this->alupayment->count_sousc_number($slider->id_frontuser,$slider->id);
                $id_transaction = "SLIDER".date('Hi').$count.'-'.$slider->id; // Identifiant du Paiement
                $description_du_paiement = $formData['designation'];/*sprintf('Mon produit de ref %s', $id_transaction)*/; // Description du Payment
                $identifiant_du_payeur = $frontuser->fisrtname.' '.$frontuser->lastname." <br>Nombre de Paiment <strong>$count</strong> <br> Identifiant Paiment : ".$id_transaction; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
                $montant_a_payer = (montant_prix_unitaire_slider()*$slider->duree_service == $slider->montant)?$slider->montant:montant_prix_unitaire_slider();/*mt_rand(100, 200)*/; // Montant à Payer : minimun est de 100 francs sur CinetPay
                $buyer_name = '-';

            }elseif(isset($formData['designation']) && $formData['designation'] == 'Tête de liste'){
                $this->validate($request,[
                    'slug'  => 'required'
                ]);

                $tdl = ALaUne::where('slug',$formData['slug'])->first(); // occurance du Slider
                $frontuser = Frontuser::where('id',$tdl->id_frontuser)->first();
                $count = $this->alupayment->count_sousc_number($tdl->id_frontuser,$tdl->id);
                $id_transaction = "TDL".date('Hi').$count.'-'.$tdl->id; // Identifiant du Paiement
                $description_du_paiement = $formData['designation'];/*sprintf('Mon produit de ref %s', $id_transaction)*/; // Description du Payment
                $identifiant_du_payeur = $frontuser->fisrtname.' '.$frontuser->lastname." <br>Nombre de Paiment <strong>$count</strong> <br> Identifiant Paiment : ".$id_transaction; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
                $montant_a_payer = (montant_prix_unitaire_slider()*$tdl->duree_service == $tdl->montant)?$tdl->montant:montant_prix_unitaire_slider();/*mt_rand(100, 200)*/; // Montant à Payer : minimun est de 100 francs sur CinetPay
                $buyer_name = '-';
            }

            //dd($order_data);
            $apiKey = "12225072435af2f658189760.36336854"; // Remplacez ce champs par votre APIKEY
            $site_id = "332112"; // Remplacez ce champs par votre SiteID
            $date_transaction = date("Y-m-d H:i:s"); // Date Paiement dans votre système
            //$formName = "Event_Payment"; // nom du formulaire CinetPay
            $notify_url = route('cinetpay.notification'); // Lien de notification CallBack CinetPay (IPN Link)
            $return_url = route('cinetpay.return'); // Lien de retour CallBack CinetPay
            $cancel_url = route('cinetpay.delete', $id_transaction); // Lien d'annulation CinetPay
            //dd($notify_url,$return_url,$cancel_url);

            /*// Configuration du bouton
            $btnType = 2;//1-5xwxxw
            $btnSize = 'large'; // 'small' pour reduire la taille du bouton, 'large' pour une taille moyenne ou 'larger' pour  une taille plus grande*/

            //Paramétrage du panier CinetPay et affichage du formulaire
            $cp = new CinetPay($site_id, $apiKey);
            try {
                $cp->setTransId($id_transaction)
                    ->setDesignation($description_du_paiement)
                    ->setTransDate($date_transaction)
                    ->setAmount($montant_a_payer)
                    ->setDebug(false)// Valorisé à true, si vous voulez activer le mode debug sur cinetpay afin d'afficher toutes les variables envoyées chez CinetPay
                    //->setCustom($identifiant_du_payeur)// optional
                    ->setBuyerName($buyer_name)
                    ->setNotifyUrl($notify_url)// optional
                    ->setReturnUrl($return_url)// optional
                    ->setCancelUrl($cancel_url)// optional
                    /*->displayPayButton($formName, $btnType, $btnSize);*/
                    ->submitCinetPayForm();

                    //Gain de points  Bonus lors d'un payement
                    $myWalletBonus = $frontuser->getWallet('bonus');
                    $deposit = ($this->arrondi_entier_sup($bookingdata->order_amount))*0.001;

                    if ($myWalletBonus != null) {
                    $myWalletBonus->deposit($deposit);
                    } else {
                        $walletBonus = $frontuser->createWallet([
                        'name' => 'My Bonus',
                        'slug' => 'bonus',
                        ]);
                    $walletBonus->deposit($deposit);
                    }

                    $bonus = $myWalletBonus->balance;
                    if ($bonus >= 100) {
                        //Recharche Wallet E-dari dès que Point bonus superieur aou égale a 100
                        $result = (int)($bonus/100);
                        $myWallet->deposit($result*5000);
                        $myWalletBonus->withdraw($result*100);

                        //Mail de récompense Wallet E-Dari.
                        $bookingdata = $this->ticket_booking->getOrderData($request->input('order_id'));
                        $mail = (isset($bookingdata->user_email))?array($bookingdata->user_email):array(guestUserData($bookingdata->gust_id)->email);
                        $mailMessage = '';

                        $lastAmountFromDefaultWallet = $frontuser->transactions
                            ->where('wallet_id', $frontuser->getWallet('default')->id)
							->where('type', 'deposit')
                            ->reverse()
                            ->first()->amount;

                        try {
                                Mail::send('theme.pdf.bonus',['bookingdata'=>$bookingdata,'lastAmountFromDefaultWallet' => $lastAmountFromDefaultWallet],function($message) use ($mail) {
                                    $message->from(frommail(), forcompany());
                                    $message->to($mail);
                                    $message->bcc(['charlene.valmorin@gmail.com','contact@myplace-events.com','christelle.abeu@myplace-events.com']);
                                    $message->subject(trans('words.msg.e_tic_ord1'));
                                });
                        }catch (\Exception $e) {
                                $mailMessage = ", Mail Sending Fail !";
                        }
                    }

            } catch (\Exception $e) {
                print $e->getMessage();
            }
        }

    }

    protected function generate_cinetpay_form(Request $request)
    {

        $formData = $request->all();
        //dd($formData);

        $order_data = json_decode($request->input('order_data'));
        //dd($order_data);
        
        $frontuser = Frontuser::where('id', $order_data->user_id)->first();

        $bookingdata	= $this->ticket_booking->getOrderData($request->input('order_id'));
        $this->ticket_booking->updateData(['order_status' => 5], $request->input('order_id'));
 
        $id_transaction = $bookingdata->order_id; 

        if ($bookingdata->user_id) {
            $data = Frontuser::where('id',$bookingdata->user_id)->first();
        }
        else { 

			$guest_user = GuestUser::where('guest_id', $bookingdata->gust_id)->first();
			//dd($bookingdata);
            $data = (object) [
                'firstname' => $guest_user->user_name,
                'lastname' => $guest_user->user_name,
                'email' => $guest_user->guest_email,
                'cellphone' => $guest_user->cellphone,
                'address' => '',
                'city' => '',
            ];
            unset($guest_user);
        }
        
        //dd($data);
        $apiKey = "12225072435af2f658189760.36336854"; // Remplacez ce champs par votre APIKEY
        $site_id = "332112"; // Remplacez ce champs par votre SiteID
        $version = "V2";
        $date_transaction = date("Y-m-d H:i:s"); // Date Paiement dans votre système
        // $channels = ["ALL", "MOBILE_MONEY", "CREDIT_CARD", "WALLET"];
        $channels = ["ALL"];
        $notify_url = route('cinetpay.notification'); 
        $return_url = route('cinetpay.return');
        //dd($notify_url .'-'. $return_url) ; 
        $cancel_url = route('cinetpay.delete', $id_transaction); // Lien d'annulation CinetPay


       /* if ($request->has('wallet')) {
                //Paiement avec Wallet
                try {
                    $myWallet = $frontuser->getWallet('default');
                    $myWallet->pay($bookingdata);
                    
                    //Gain de points  Bonus lors d'un payement
                    $myWalletBonus = $frontuser->getWallet('bonus');
                    $deposit = ($this->arrondi_entier_sup($bookingdata->order_amount))*0.001;

                    if ($myWalletBonus != null) {
                    $myWalletBonus->deposit($deposit);
                    } else {
                        $walletBonus = $frontuser->createWallet([
                        'name' => 'My Bonus',
                        'slug' => 'bonus',
                        ]);
                    $walletBonus->deposit($deposit);
                    } 

                    $bonus = $myWalletBonus->balance;
                    if ($bonus >= 100) {
                        //Recharche Wallet E-dari dès que Point bonus superieur aou égale a 100
                        $result = (int)($bonus/100);
                        $myWallet->deposit($result*5000);
                        $myWalletBonus->withdraw($result*100);
                        
                        //Mail de récompense Wallet E-Dari
                        $bookingdata = $this->ticket_booking->getOrderData($request->input('order_id'));
                        $mail = (isset($bookingdata->user_email))?array($bookingdata->user_email):array(guestUserData($bookingdata->gust_id)->email);
                        $mailMessage = '';

                        $lastAmountFromDefaultWallet = $frontuser->transactions
                            ->where('wallet_id', $frontuser->getWallet('default')->id)
							->where('type', 'deposit')
                            ->reverse()
                            ->first()->amount;

                    try {
                            Mail::send('theme.pdf.bonus',['bookingdata'=>$bookingdata,'lastAmountFromDefaultWallet' => $lastAmountFromDefaultWallet],function($message) use ($mail) {
                                $message->from(frommail(), forcompany());
                                $message->to($mail);
                                $message->bcc(['charlene.valmorin@gmail.com','contact@myplace-events.com','christelle.abeu@myplace-events.com']);
                                $message->subject(trans('words.msg.e_tic_ord1'));
                            });
                        }catch (\Exception $e) {
                            $mailMessage = ", Mail Sending Fail !";
                        }
                    }

                    $this->wallet_notification($formData, $bookingdata, $request);
                    return redirect()
                    ->route('order.success', $bookingdata->order_id);

                } catch (\Exception $e) {
                    //dd($e);
                    return redirect()
                    ->route('order.cancel', $bookingdata->order_id);
                }
        }*/

            
        if ($request->has('cinetpay')) {
            
            $devent=Event::where('event_unique_id', $bookingdata->event_id)->first();
        
            if($devent->event_country=="Cameroun"){
                $currency="XAF";
            }else{
                $currency="XOF";
            }
            
            //dd($formData);
            if(isset($formData['designation']) && $formData['designation'] == 'prestataire'){
                $this->validate($request,[
                    'url_slug'		        => 'required',
                    'identifiant_payeur'    => 'required',
                    'formule'               => 'required',
                    'montant'               => 'required',
                    'pu'                    => 'required',
                ]);
                $prestataire = Prestataire::where('url_slug',$formData['url_slug'])->first();
                $count = $this->souscprestataires->count_sousc_number($prestataire->id);

                $id_transaction = $formData['url_slug'].'-'.date('Hi').$count; // Identifiant du Paiement
                $description_du_paiement = $formData['designation']/*sprintf('Mon produit de ref %s', $id_transaction)*/; // Description du Payment
                $identifiant_du_payeur = $formData['identifiant_payeur']." <br> Détails prestataire : Pseudo <b>$prestataire->pseudo</b> | Nombre de Paiment <b>$count</b> | "; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
                $montant_a_payer = montant_prix_unitaire_prestataire()*$formData['formule']/*mt_rand(100, 200)*/; // Montant à Payer : minimun est de 100 francs sur CinetPay
                $buyer_name = $formData['url_slug'];
                //dd($count,$prestataire,$id_transaction);

            }elseif($request->input('order_data') !== null){
                $order_data = json_decode($request->input('order_data'));

                $id_transaction = $bookingdata->order_id; // Identifiant du Paiement
                $description_du_paiement = $order_data->designation/*sprintf('Mon produit de ref %s', $id_transaction)*/; // Description du Payment
                $identifiant_du_payeur = $order_data->identifiant_payeur; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
                $montant_a_payer = $order_data->amount/*mt_rand(100, 200)*/; // Montant à Payer : minimun est de 100 francs sur CinetPay
                //$buyer_name = 'Maurel';
                
		//echo $montant_a_payer."--";

                $form = [
                    "apikey"=> $apiKey,
                    "site_id"=> $site_id,
                    "transaction_id"=> $id_transaction,
                    "amount"=> $montant_a_payer,
                    "currency"=> $currency,
                    "customer_surname"=> $data->firstname,
                    "customer_name"=> $data->firstname .' '. $data->lastname,
                    "description"=> $description_du_paiement,
                    "notify_url" => $notify_url,
                    "return_url" => $return_url,
                    "channels" => $channels,
                    //pour afficher le paiement par carte de credit
                    "metadata" => "Ceci est le SDK PHP",
                    "chk_metadata" => "Ceci est le SDK PHP",
                    "alternative_currency" => "EUR",
                    "customer_email" => $data->email ? $data->email : "test@cinetpay.com",
                    "customer_phone_number" =>  $data->cellphone ? $data->cellphone : "0505050505",
                    "customer_address" => $data->address ? $data->address : "BP 258",
                    "customer_city" =>  $data->city ? $data->city : "ABIDJAN",
                    "customer_country" => "CI",
                    "customer_state" =>  "AZ",
                    "customer_zip_code" =>  "00225"
                ];

                //dd($form);
            }elseif(isset($formData['designation']) && $formData['designation'] == 'Slider'){
                $this->validate($request,[
                    'slug'  => 'required'
                ]);

                $slider = ALaUne::where('slug',$formData['slug'])->first(); // occurance du Slider
                $frontuser = Frontuser::where('id',$slider->id_frontuser)->first();
                $count = $this->alupayment->count_sousc_number($slider->id_frontuser,$slider->id);
                $id_transaction = "SLIDER".date('Hi').$count.'-'.$slider->id; // Identifiant du Paiement
                $description_du_paiement = $formData['designation'];/*sprintf('Mon produit de ref %s', $id_transaction)*/; // Description du Payment
                $identifiant_du_payeur = $frontuser->fisrtname.' '.$frontuser->lastname." <br>Nombre de Paiment <strong>$count</strong> <br> Identifiant Paiment : ".$id_transaction; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
                $montant_a_payer = (montant_prix_unitaire_slider()*$slider->duree_service == $slider->montant)?$slider->montant:montant_prix_unitaire_slider();/*mt_rand(100, 200)*/; // Montant à Payer : minimun est de 100 francs sur CinetPay
                $buyer_name = '-';

            }
            elseif(isset($formData['designation']) && $formData['designation'] == 'Tête de liste'){
                $this->validate($request,[
                    'slug'  => 'required'
                ]);

                $tdl = ALaUne::where('slug',$formData['slug'])->first(); // occurance du Slider
                $frontuser = Frontuser::where('id',$tdl->id_frontuser)->first();
                $count = $this->alupayment->count_sousc_number($tdl->id_frontuser,$tdl->id);
                $id_transaction = "TDL".date('Hi').$count.'-'.$tdl->id; // Identifiant du Paiement
                $description_du_paiement = $formData['designation'];/*sprintf('Mon produit de ref %s', $id_transaction)*/; // Description du Payment
                $identifiant_du_payeur = $frontuser->fisrtname.' '.$frontuser->lastname." <br>Nombre de Paiment <strong>$count</strong> <br> Identifiant Paiment : ".$id_transaction; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
                $montant_a_payer = (montant_prix_unitaire_slider()*$tdl->duree_service == $tdl->montant)?$tdl->montant:montant_prix_unitaire_slider();/*mt_rand(100, 200)*/; // Montant à Payer : minimun est de 100 francs sur CinetPay
                $buyer_name = '-';
            }
            
            $cp = new CinetPayNew($site_id, $apiKey, $version);
            //dd($cp);
            try {
                $result = $cp->generatePaymentLink($form);
                if ($result["code"] == '201')
                    {
                        $url = $result["data"]["payment_url"];
                        //dd($url);
                        //redirection vers l'url
                        return \Redirect::to($url);
                    }
                   
                	//Gain de points  Bonus lors d'un payement
                    $myWalletBonus = $frontuser->getWallet('bonus');
                    $deposit = ($this->arrondi_entier_sup($bookingdata->order_amount))*0.001;

                    if ($myWalletBonus != null) {
                    	$myWalletBonus->deposit($deposit);
                    } else {
                        $walletBonus = $frontuser->createWallet([
                        'name' => 'My Bonus',
                        'slug' => 'bonus',
                        ]);
                    	$walletBonus->deposit($deposit);
                    }

                    $bonus = $myWalletBonus->balance;
				
                    if ($bonus >= 100) {
                        //Recharche Wallet E-dari dès que Point bonus superieur aou égale a 100
                        $result = (int)($bonus/100);
                        $myWallet->deposit($result*5000);
                        $myWalletBonus->withdraw($result*100);

                        //Mail de récompense Wallet E-Dari.
                        $bookingdata = $this->ticket_booking->getOrderData($request->input('order_id'));
                        $mail = (isset($bookingdata->user_email))?array($bookingdata->user_email):array(guestUserData($bookingdata->gust_id)->email);
                        $mailMessage = '';

                        $lastAmountFromDefaultWallet = $frontuser->transactions
                            ->where('wallet_id', $frontuser->getWallet('default')->id)
							->where('type', 'deposit')
                            ->reverse()
                            ->first()->amount;

                        try {
                            Mail::send('theme.pdf.bonus',['bookingdata'=>$bookingdata,'lastAmountFromDefaultWallet' => $lastAmountFromDefaultWallet],function($message) use ($mail) {
                                $message->from(frommail(), forcompany());
                                $message->to($mail);
                                $message->bcc(['charlene.valmorin@gmail.com','contact@myplace-events.com','christelle.abeu@myplace-events.com']);
                                $message->subject(trans('words.msg.e_tic_ord1'));
                            });
                        }catch (\Exception $e) {
                                $mailMessage = ", Mail Sending Fail !";
                        }
                         
					}  
				
				
				
            } catch (\Exception $e) {
               print $e->getMessage();
            }
        }else{
			echo"<center>Une erreur est survenue!</center><br>";
		}

    }
	
	
	
	
    protected function generate_shop_cinetpayform(Request $request)
    {

        $formData = $request->all();
        //dd($formData);

        $order_data = json_decode($request->input('order_data'));
        //dd($order_data);
        
        $frontuser = Frontuser::where('id', $order_data->user_id)->first();

        $bookingdata	= $this->ticket_booking->getOrderData($request->input('order_id'));
        $this->ticket_booking->updateData(['order_status' => 5], $request->input('order_id'));
 
        $id_transaction = $bookingdata->order_id; 

        if($bookingdata->user_id) {
            $data = Frontuser::where('id',$bookingdata->user_id)->first();
        }else { 

			$guest_user = GuestUser::where('guest_id', $bookingdata->gust_id)->first();
			//dd($bookingdata);
            $data = (object) [
                'firstname' => $guest_user->user_name,
                'lastname' => $guest_user->user_name,
                'email' => $guest_user->guest_email,
                'cellphone' => $guest_user->cellphone,
                'address' => '',
                'city' => '',
            ];
            unset($guest_user);
        }
        
        //dd($data);
        $apiKey = "12225072435af2f658189760.36336854"; // Remplacez ce champs par votre APIKEY
        $site_id = "332112"; // Remplacez ce champs par votre SiteID
        $version = "V2";
        $date_transaction = date("Y-m-d H:i:s"); // Date Paiement dans votre système
        // $channels = ["ALL", "MOBILE_MONEY", "CREDIT_CARD", "WALLET"];
        $channels = ["ALL"];
        $notify_url = route('cinetpay.notification'); 
        $return_url = route('cinetpay.return');
        //dd($notify_url .'-'. $return_url) ; 
        $cancel_url = route('cinetpay.delete', $id_transaction); // Lien d'annulation CinetPay
 
            
        if ($request->has('cinetpay')) {
            
            $devent=Event::where('event_unique_id', $bookingdata->event_id)->first();
        
            if($devent->event_country=="7"){
                $currency="XAF";
            }else{
                $currency="XOF";
            }
            
            //dd($formData);
			if($request->input('order_data') !== null){
                $order_data = json_decode($request->input('order_data'));

                $id_transaction = $bookingdata->order_id; // Identifiant du Paiement
                $description_du_paiement = $order_data->designation/*sprintf('Mon produit de ref %s', $id_transaction)*/; // Description du Payment
                $identifiant_du_payeur = $order_data->identifiant_payeur; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
                $montant_a_payer = $order_data->amount/*mt_rand(100, 200)*/; // Montant à Payer : minimun est de 100 francs sur CinetPay
                //$buyer_name = 'Maurel';
				
                $form = [
                    "apikey"=> $apiKey,
                    "site_id"=> $site_id,
                    "transaction_id"=> $id_transaction,
                    "amount"=> $montant_a_payer,
                    "currency"=> $currency,
                    "customer_surname"=> $data->firstname,
                    "customer_name"=> $data->firstname .' '. $data->lastname,
                    "description"=> $description_du_paiement,
                    "notify_url" => $notify_url,
                    "return_url" => $return_url,
                    "channels" => $channels,
                    //pour afficher le paiement par carte de credit
                    "metadata" => "Ceci est le SDK PHP",
                    "chk_metadata" => "Ceci est le SDK PHP",
                    "alternative_currency" => "EUR",
                    "customer_email" => $data->email ? $data->email : "test@cinetpay.com",
                    "customer_phone_number" =>  $data->cellphone ? $data->cellphone : "0505050505",
                    "customer_address" => $data->address ? $data->address : "BP 258",
                    "customer_city" =>  $data->city ? $data->city : "ABIDJAN",
                    "customer_country" => "CI",
                    "customer_state" =>  "AZ",
                    "customer_zip_code" =>  "00225"
                ];

                //dd($form);
            }
            
            $cp = new CinetPayNew($site_id, $apiKey, $version);
            //dd($cp);
            try {
                $result = $cp->generatePaymentLink($form);
                if ($result["code"] == '201'){
                        $url = $result["data"]["payment_url"];
                        //dd($url);
                        //redirection vers l'url
                        return \Redirect::to($url);
                    }
                   
					//Gain de points  Bonus lors d'un payement
                    $myWalletBonus = $frontuser->getWallet('bonus');
                    $deposit = ($this->arrondi_entier_sup($bookingdata->order_amount))*0.001;

                    if ($myWalletBonus != null) {
                    $myWalletBonus->deposit($deposit);
                    } else {
                        $walletBonus = $frontuser->createWallet([
                        'name' => 'My Bonus',
                        'slug' => 'bonus',
                        ]);
                    $walletBonus->deposit($deposit);
                    }

                    $bonus = $myWalletBonus->balance;
                    if ($bonus >= 100) {
                        //Recharche Wallet E-dari dès que Point bonus superieur aou égale a 100
                        $result = (int)($bonus/100);
                        $myWallet->deposit($result*5000);
                        $myWalletBonus->withdraw($result*100);

                        //Mail de récompense Wallet E-Dari.
                        $bookingdata = $this->ticket_booking->getOrderData($request->input('order_id'));
                        $mail = (isset($bookingdata->user_email))?array($bookingdata->user_email):array(guestUserData($bookingdata->gust_id)->email);
                        $mailMessage = '';

                        $lastAmountFromDefaultWallet = $frontuser->transactions
                            ->where('wallet_id', $frontuser->getWallet('default')->id)
							->where('type', 'deposit')
                            ->reverse()
                            ->first()->amount;

                        try {
                            Mail::send('theme.pdf.bonus',['bookingdata'=>$bookingdata,'lastAmountFromDefaultWallet' => $lastAmountFromDefaultWallet],function($message) use ($mail) {
                                $message->from(frommail(), forcompany());
                                $message->to($mail);
                                $message->bcc(['charlene.valmorin@gmail.com','contact@myplace-events.com','christelle.abeu@myplace-events.com']);
                                $message->subject(trans('words.msg.e_tic_ord1'));
                            });
                        }catch (\Exception $e) {
                                $mailMessage = ", Mail Sending Fail !";
                        }

                        
                }     
            } catch (\Exception $e) {
               print $e->getMessage();
            }
        }else{
			echo"<center>Une erreur est survenue!</center><br>";
		}

    }
 
    protected function generateForm(Request $request)
    {
        $order_data = json_decode($request->input('order_data'));
        //$order_data->event_booking_id;

        $bookingdata	= $this->ticket_booking->singleOrder($order_data->event_booking_id);

        if(!isset($bookingdata) && empty($bookingdata)){
            \App::abort(404, 'Somthing is wrong! Please try again.');
        }
        if($bookingdata->order_status == 2)
            return redirect()->route('order.cancel',$bookingdata->order_id);

        //$input_order['order_status']  = '3';
        //$this->ticket_booking->updateData($input_order,$bookingdata->order_id);

        /*
         * Preparation des elements constituant le panier
        */
        $apiKey = "12225072435af2f658189760.36336854"; //Veuillez entrer votre apiKey
        $site_id = "332112"; //Veuillez entrer votre siteId

        $identifiantAcheteur = $bookingdata->user_id;
        //$id_transaction = CinetPay::generateTransId(); // Identifiant du Paiement
        $id_transaction = $bookingdata->order_id; // Identifiant du Paiement

        $description_du_paiement = sprintf('Achat de tickets %s', $id_transaction); // Description du Payment
        $date_transaction = date("Y-m-d H:i:s"); // Date Paiement dans votre système

        //$montant_a_payer = mt_rand(5, 100); // Montant à Payer : minimun est de 5 francs sur CinetPay
        $montant_a_payer = $order_data->amount; // Montant à Payer : minimun est de 5 francs sur CinetPay

        // $identifiant_du_payeur = 'payeur@domaine.ci'; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
        $identifiant_du_payeur = $identifiantAcheteur;

        $formName = "goCinetPay"; // nom du formulaire CinetPay
        $notify_url = url('p/cinetPay/notify'); // Lien de notification CallBack CinetPay (IPN Link)
        $return_url = url('p/cinetPay/return'); // Lien de retour CallBack CinetPay
        $cancel_url = url('p/cinetPay/cancel/'.$id_transaction); // Lien d'annulation CinetPay
        // Configuration du bouton
        $btnType = 2;//1-5xwxxw
        $btnSize = 'large'; // 'small' pour reduire la taille du bouton, 'large' pour une taille moyenne ou 'larger' pour  une taille plus grande

        // Paramétrage du panier CinetPay et affichage du formulaire
        $cp = new CinetPay($site_id, $apiKey);
        try {
            $cp->setTransId($id_transaction)
                ->setDesignation($description_du_paiement)
                ->setTransDate($date_transaction)
                ->setAmount($montant_a_payer)
                ->setDebug(false)// Valorisé à true, si vous voulez activer le mode debug sur cinetpay afin d'afficher toutes les variables envoyées chez CinetPay
                ->setCustom($identifiant_du_payeur)// optional
                ->setNotifyUrl($notify_url)// optional
                ->setReturnUrl($return_url)// optional
                ->setCancelUrl($cancel_url)// optional
           //                ->displayPayButton($formName, $btnType, $btnSize);
                ->submitCinetPayForm();
        } catch (\Exception $e) {
            print $e->getMessage();
        }
    }

    public function cancelUrl($order_id){
        //dd($order_id);
        //$session_orderId = $this->session::get('order_id');
        $session_orderId = \Session::get('order_id');
        $key = array_search($order_id, $session_orderId);
        if(isset($key) && $key != '')
            \Session::forget('order_id.' . $key);

        $bookingdata = $this->ticket_booking->getOrderData($order_id);
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

    protected function cinetpay_notification_old(){
        $id_transaction = $_POST['cpm_trans_id'];
        if(!empty($id_transaction)) {
            try {
                $apiKey = "12225072435af2f658189760.36336854"; //Veuillez entrer votre apiKey
                $site_id = "332112"; //Veuillez entrer votre siteId

                $cp = new CinetPay($site_id, $apiKey);

                // Reprise exacte des bonnes données chez CinetPay
                $cp->setTransId($id_transaction)->getPayStatus();
                $paymentData = [
                    "cpm_site_id" => $cp->_cpm_site_id,
                    "signature" => $cp->_signature,
                    "cpm_amount" => $cp->_cpm_amount,
                    "cpm_trans_id" => $cp->_cpm_trans_id,
                    "cpm_custom" => $cp->_cpm_custom,
                    "cpm_currency" => $cp->_cpm_currency,
                    "cpm_payid" => $cp->_cpm_payid,
                    "cpm_payment_date" => $cp->_cpm_payment_date,
                    "cpm_payment_time" => $cp->_cpm_payment_time,
                    "cpm_error_message" => $cp->_cpm_error_message,
                    "payment_method" => $cp->_payment_method,
                    "cpm_phone_prefixe" => $cp->_cpm_phone_prefixe,
                    "cel_phone_num" => $cp->_cel_phone_num,
                    "cpm_ipn_ack" => $cp->_cpm_ipn_ack,
                    "created_at" => $cp->_created_at,
                    "updated_at" => $cp->_updated_at,
                    "cpm_result" => $cp->_cpm_result,
                    "cpm_trans_status" => $cp->_cpm_trans_status,
                    "cpm_designation" => $cp->_cpm_designation,
                    "buyer_name" => $cp->_buyer_name,
                ];
                // Recuperation de la ligne de la transaction dans votre base de données

                // Verification de l'etat du traitement de la commande

                // Si le paiement est bon alors ne traitez plus cette transaction : die();

                // On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction

                // On verifie que le paiement est valide
                $order_payment = [];

                switch ($paymentData['cpm_designation']) {
                    case 'event_ticket':
                        $bookingdata = $this->ticket_booking->singleOrder($id_transaction);
                        if ($bookingdata->user_id != 0):
                            $order_payment['payment_user_id'] = $bookingdata->user_id;
                            $order_payment['payment_guest_id'] = null;
                        else:
                            $order_payment['payment_user_id'] = 0;
                            $order_payment['payment_guest_id'] = $bookingdata->gust_id;
                        endif;
                        $order_payment['payment_order_id'] = $bookingdata->order_id;
                        $order_payment['payment_event_id'] = $bookingdata->event_id;
                        $order_payment['payment_currency'] = 'FCFA';
                        $order_payment['payment_gateway'] = 'CINETPAY';
                        $order_payment['payment_method'] = $paymentData["payment_method"];
                        $order_payment['payment_number'] = '+' . $paymentData["cpm_phone_prefixe"] . $paymentData["cel_phone_num"];

                        $designation = 1;
                        break;
                    case 'prestataire' :
                        $dispatchIdTrans = explode('-',$paymentData['cpm_trans_id']);
                        $url_slug = $dispatchIdTrans[0].'-'.$dispatchIdTrans[1];
                        $prestataire = Prestataire::where('url_slug',$url_slug)->first();
                        $order_payment['id_transaction'] = $paymentData['cpm_trans_id'];
                        $order_payment['id_frontuser'] = $prestataire->id_frontusers;
                        $order_payment['id_prestataire'] = $prestataire->id;
                        $order_payment['payment_gateway'] = 'CINETPAY';
                        $order_payment['payment_method'] = $paymentData["payment_method"];
                        $order_payment['payment_phone_number'] = '+' . $paymentData["cpm_phone_prefixe"] . $paymentData["cel_phone_num"];

                        $designation = 2;
                        break;
                    case 'Tête de liste':
                        $dispatchIdTrans = explode('-',$paymentData['cpm_trans_id']);
                        $idTdl = $dispatchIdTrans[1];
                        $alu = ALaUne::where('id',$idTdl)->first();
                        $frontuser = Frontuser::where('id',$alu->id_frontuser);

                        $order_payment['id_transaction'] = $paymentData['cpm_trans_id'];
                        $order_payment['id_frontuser'] = $alu->id_frontuser;
                        $order_payment['id_alu'] = $alu->id;
                        $order_payment['payment_gateway'] = 'CINETPAY';
                        $order_payment['payment_method'] = $paymentData["payment_method"];
                        $order_payment['payment_phone_number'] = '+' . $paymentData["cpm_phone_prefixe"] . $paymentData["cel_phone_num"];
                        $order_payment['payment_designation'] = $paymentData["cpm_designation"];


                        $designation = 3;

                        break;
                    case 'Slider':
                        $dispatchIdTrans = explode('-',$paymentData['cpm_trans_id']);
                        $idSlider = $dispatchIdTrans[1];
                        $alu = ALaUne::where('id',$idSlider)->first();
                        $frontuser = Frontuser::where('id',$alu->id_frontuser);

                        $order_payment['id_transaction'] = $paymentData['cpm_trans_id'];
                        $order_payment['id_frontuser'] = $alu->id_frontuser;
                        $order_payment['id_alu'] = $alu->id;
                        $order_payment['payment_method'] = $paymentData["payment_method"];
                        $order_payment['payment_phone_number'] = '+' . $paymentData["cpm_phone_prefixe"] . $paymentData["cel_phone_num"];
                        $order_payment['payment_designation'] = $paymentData["cpm_designation"];

                        $designation = 4;
                        break;

                    default :
                        break;

                }

                /*$order_payment['payment_user_id'] = $bookingdata->user_id;
                $order_payment['payment_guest_id'] =*/
                // paiement valide
                if (!empty($paymentData["cpm_result"]) && $paymentData["cpm_result"] == '00') {
                    /*$message = ($message == "")?'Felicitation, votre paiement a été effectué avec succès':$message;
                    $order_payment['message'] = $message;
                    $data = $this->order_payment->insertData($order_payment);
                    $this->send_message_to_admin($message);
                    session(['cinetpay_notification' => 1]);
                    $this->ticket_controller->orderDone($cpm_trans_id);
                    //return redirect()->route('ticket.oderdone', $id_transaction);*/
                    if (isset($designation)):
                        if($designation == 1){
                            $montant_reel = arrondi_entier_sup($bookingdata->order_amount * cinetpay_commission());
                            /*if ($montant_reel != $paymentData["cpm_amount"]):
                                $order_payment['payment_state'] = 2;
                                $order_payment['payment_status'] = 'MONTANT INCORRECT';
                            else:*/
                                //pour les bon paiement
                                $order_payment['payment_state'] = 1;
                                $order_payment['payment_amount'] = $paymentData["cpm_amount"];
                                $order_payment['payment_status'] = 'SUCCESS';
                            //endif;
                            $succes_paiement = 1;
                        }
                        // Pour les prestataires
                        if($designation  == 2){
                            if($paymentData["cpm_amount"]>=montant_prix_unitaire_prestataire()){
                                if($paymentData["cpm_amount"]%montant_prix_unitaire_prestataire() != 0){
                                    //Mauvais paiement
                                    $order_payment['formule'] = null;
                                    $order_payment['montant'] = $paymentData["cpm_amount"];
                                    $order_payment['status'] = 2;
                                    $order_payment['payment_trans_status'] = 'MONTANT INCORRECT';
                                    $order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];
                                    $succes_paiement = 2;
                                }else{
                                    //pour les bon paiement
                                    $order_payment['formule'] = $paymentData["cpm_amount"]/montant_prix_unitaire_prestataire();
                                    $order_payment['status'] = 1;
                                    $order_payment['montant'] = $paymentData["cpm_amount"];
                                    $order_payment['payment_trans_status'] = 'SUCCESS';
                                    $order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];
                                    $succes_paiement = 1;
                                }
                            }
                        }
                        if($designation  == 3 || $designation  == 4){
                            if($paymentData["cpm_amount"]%montant_prix_unitaire_tdl() != 0){
                                $order_payment['formule'] = null;
                                $order_payment['montant'] = $paymentData["cpm_amount"];
                                $order_payment['status'] = 0;

                                $succes_paiement = 2;
                            }else{
                                //pour les bon paiement
                                $order_payment['formule'] = $paymentData["cpm_amount"]/montant_prix_unitaire_prestataire();
                                $order_payment['status'] = 1;
                                $order_payment['montant'] = $paymentData["cpm_amount"];
                                //$order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];

                                $succes_paiement = 1;
                            }
                        }
                    endif;
                }

                // traitement operation dans la bdd
                if (isset($designation)){
                    if($designation == 1){
                        if ($this->order_payment->no_repeat_payment($bookingdata->order_id)):
                            if ($succes_paiement):
                                //dd($paymentData['cpm_trans_id']);
                                /*return redirect()->route('ticket.oderdone',$paymentData['cpm_trans_id'])*/
                                $this->ticket_controller->orderDone($paymentData['cpm_trans_id']);
                                $user = Frontuser::where('id',$bookingdata->user_id)->first();
                                if($user == null) $user = GuestUser::where('guest_id',$bookingdata->gust_id)->first();
                                $event = Event::where('event_unique_id',$bookingdata->event_id)->first();
                                /*$orgId = Organization::where('id', $event->event_org_name)->first();
                                $orgUserData = Frontuser::where('id', $orgId->user_id);*/
                                $message = ['user'=>$user, 'event'=>$event, 'bookingdata'=>$bookingdata, /*'orgEmail' => $orgUserData->email*/];
                                //dd($message);
                                $this->send_message_to_admin_for_ticket_paid($message, $event);
                            endif;
                            $data = $this->order_payment->insertData($order_payment);
                            if($succes_paiement != 1):
                                $cinetpayTrack['designation'] = $paymentData['cpm_designation'];
                                $cinetpayTrack['payment_method'] = $paymentData['payment_method'];
                                $cinetpayTrack['telephone'] =  "(.".$paymentData['cpm_phone_prefixe'].") ".$paymentData['cel_phone_num'];
                                $cinetpayTrack['num_transaction'] =  $paymentData['cpm_trans_id'];
                                $cinetpayTrack['code_erreur'] =  $paymentData['cpm_trans_status'];
                                $cinetpayTrack["message"] = $paymentData['cpm_error_message'];
                                $cinetpayTrack["data_track"] = null;
                                //dd($id_transaction);
                                $this->cinetpay_track->insertData($cinetpayTrack);
                                return $this->cinetpay_annulation($id_transaction);

                            endif;
                        endif;
                    }
                    if($designation == 2){
                        if ($this->souscprestataires->no_repeat_payment($paymentData['cpm_trans_id'])):
                            //dd($paymentData['cpm_trans_id']);
                            if ($succes_paiement == 1):
                                $count = $this->souscprestataires->count_sousc_number($prestataire->id);
                                if($prestataire->status == 3){
                                    Prestataire::where('id',$prestataire->id)->update(['status'=>2]);
                                }
                                $message = "Le paiement de la commande <strong>" . $paymentData['cpm_trans_id']. "</strong> s'est éffectué avec succès !<br> Détails : ".$paymentData['cpm_designation'];
                                $this->send_message_to_admin($message);
                                $data = $this->souscprestataires->insertData($order_payment);
                            elseif($succes_paiement == 2):
                                $message = "Il y a une incohérance dans le paiment n<strong>".$paymentData['cpm_trans_id']."</strong><br>Veuillez contacter l'adminitrateur si vous pensez qu'il s'agit d'une erreur";
                                $this->send_simple_message($prestataire->adresse_mail,$message);
                            endif;
                            if($count>=1 && $prestataire->status == 2){
                                $data = $this->souscprestataires->insertData($order_payment);
                                $this->prestataire_controller->AddNewDateExpire($paymentData['cpm_trans_id']);
                                Prestataire::where('id',$prestataire->id)->update(['status'=>1]);
                                return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                            }elseif($count>=1 && $prestataire->status == 1){
                                $data = $this->souscprestataires->insertData($order_payment);
                                $this->AddNewDateExpire($paymentData['cpm_trans_id']);
                                return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                            }else{
                                $data = $this->souscprestataires->insertData($order_payment);
                            }
                        endif;
                    }
                    if($designation == 3 || $designation == 4){
                        if ($this->alupayment->no_repeat_payment($paymentData['cpm_trans_id'])):
                            //dd($paymentData['cpm_trans_id']);
                            if ($succes_paiement == 1):
                                if($alu->status_service == 0){
                                    //$formule = ($designation == 3)?$paymentData["cpm_amount"]/montant_prix_unitaire_tdl():($designation == 4)?$paymentData["cpm_amount"]/montant_prix_unitaire_slider():"";
                                    
                                    if($designation == 3){
                                        $formule = $paymentData["cpm_amount"]/montant_prix_unitaire_tdl();
                                    }else if($designation == 4){
                                       $formule = $paymentData["cpm_amount"]/montant_prix_unitaire_slider();
                                    }else{
                                       $formule ="" ;
                                    }
                                    
                                    
                                    $date_fin = Carbon::now()->addWeeks(/*$formule*/1)->format('Y-m-d H:i:s');
                                    ALaUne::where('id',$alu->id)->update(['status_service'=>2,'id_last_transaction'=>$id_transaction]);
                                }
                                $message = "Le paiement de la commande <strong>" . $paymentData['cpm_trans_id']. "</strong> s'est éffectué avec succès !<br> Détails : ".$paymentData['cpm_designation'];
                                $this->send_message_to_admin($message);
                                $data = $this->alupayment->insertData($order_payment);
                            elseif($succes_paiement == 2):
                                $message = "Il y a une incohérance dans le paiment n<strong>".$paymentData['cpm_trans_id']."</strong><br>Veuillez contacter l'adminitrateur si vous pensez qu'il s'agit d'une erreur";
                                $this->send_simple_message($frontuser->email,$message);
                            endif;
                            if($alu->status_service == 1){
                                $data = $this->alupayment->insertData($order_payment);
                                ALaUne::where('id',$alu->id)->update(['id_last_transaction'=>$id_transaction]);
                                $this->prestataire_controller->AddNewDateExpireAlu($paymentData['cpm_trans_id']);
                                return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                            }else{
                                $data = $this->alupayment->insertData($order_payment);
                            }
                        endif;
                    }
            }
                /*if ($cp->isValidPayment()) {
                    // echo 'Felicitation, votre paiement a été effectué avec succès';

                    return redirect()->route('ticket.oderdone', $paymentData['cpm_site_id']);
                    // die();
                } else {
                    // echo 'Echec, votre paiement a échoué pour cause : ' . $cp->_cpm_error_message;
                    return redirect()->route('order.cancel', $paymentData['cpm_site_id'])->with('error',$paymentData['cpm_error_message']);
                    // die();
                }*/
            } catch (Exception $e) {
                $this->send_message_to_admin($e);
                //echo "Erreur :" . $e->getMessage();
                //return redirect()->route('order.cancel',$order_payment['payment_order_id'])->with('error','Erreur lors du paiement');
                // Une erreur s'est produite
            }
        } else {
            // redirection vers la page d'accueil
            return redirect()->route('/');
        }
    }

    protected function cinetpay_notification(){
        $id_transaction = $_POST['cpm_trans_id'];
        if(!empty($id_transaction)) {
            try {
                $apiKey = "12225072435af2f658189760.36336854"; //Veuillez entrer votre apiKey
                $site_id = "332112"; //Veuillez entrer votre siteId
                $version = "V2";

                $cp = new CinetPayNew($site_id, $apiKey, $version);

                // Reprise exacte des bonnes données chez CinetPay
                $cp->setTransId($id_transaction)->getPayStatus();

                $paymentData = [
                    "cpm_site_id" => $cp->site_id,
                    "signature" => $cp->token,
                    "cpm_amount" => $cp->chk_amount,
                    "cpm_trans_id" => $cp->transaction_id,
                    "cpm_currency" => $cp->currency,
                    "cpm_payid" => $cp->customer_country,
                    "cpm_payment_date" => $cp->chk_payment_date,
                    "cpm_error_message" => $cp->chk_message,
                    "payment_method" => $cp->chk_payment_method,
                    "cel_phone_num" => $_POST['cpm_phone_prefixe'] . $_POST['cel_phone_num'],
                    // "cpm_ipn_ack" => $cp->_cpm_ipn_ack,
                    "created_at" => $cp->chk_payment_date,
                    // "updated_at" => $cp->_updated_at,
                    "cpm_result" => $cp->chk_code,
                    "cpm_trans_status" => $cp->chk_message,
                    "cpm_designation" => $cp->chk_description,
                    "buyer_name" => $cp->customer_name,
                ];
                // Recuperation de la ligne de la transaction dans votre base de données

                        $designation = 2;
						$succes_paiement=0;
                /*    
                        break;
                    case 'Tête de liste':
                        $dispatchIdTrans = explode('-',$id_transaction);
                        $idTdl = $dispatchIdTrans[1];
                        $alu = ALaUne::where('id',$idTdl)->first();
                        $frontuser = Frontuser::where('id',$alu->id_frontuser);

                        $order_payment['id_transaction'] = $id_transaction;
                        $order_payment['id_frontuser'] = $alu->id_frontuser;
                        $order_payment['id_alu'] = $alu->id;
                        $order_payment['payment_gateway'] = 'WALLET';
                        $order_payment['payment_method'] = 'WALLET';
                        $order_payment['payment_phone_number'] = '';
                        $order_payment['payment_designation'] = $order_data->designation;
                */

                // On verifie que le paiement est valide
                $order_payment = [];

                switch ($paymentData['cpm_designation']) {
                    case 'event_ticket':
                        $bookingdata = $this->ticket_booking->singleOrder($id_transaction);
                        if ($bookingdata->user_id != 0):
                            $order_payment['payment_user_id'] = $bookingdata->user_id/*auth()->guard('frontuser')->user()->id*/
                            ;
                            $order_payment['payment_guest_id'] = null;
                        else:
                            $order_payment['payment_user_id'] = 0;
                            $order_payment['payment_guest_id'] = $bookingdata->gust_id;
                        endif;
                        
                        $devent=Event::where('event_unique_id', $bookingdata->event_id)->first();
        
                        if($devent->event_country=="Cameroun"){
                            $currency="XAF";
                        }else{
                            $currency="XOF";
                        }
        
                        $order_payment['payment_order_id'] = $bookingdata->order_id;
                        $order_payment['payment_event_id'] = $bookingdata->event_id;
                        $order_payment['payment_currency'] = $currency;
                        $order_payment['payment_gateway'] = 'CINETPAY';
                        $order_payment['payment_method'] = $paymentData["payment_method"];
                        $order_payment['payment_number'] = $paymentData["cel_phone_num"];

                        $designation = 1;
                        break;
                    case 'prestataire' :
                        $dispatchIdTrans = explode('-',$paymentData['cpm_trans_id']);
                        $url_slug = $dispatchIdTrans[0].'-'.$dispatchIdTrans[1];
                        $prestataire = Prestataire::where('url_slug',$url_slug)->first();
                        $order_payment['id_transaction'] = $paymentData['cpm_trans_id'];
                        $order_payment['id_frontuser'] = $prestataire->id_frontusers;
                        $order_payment['id_prestataire'] = $prestataire->id;
                        $order_payment['payment_gateway'] = 'CINETPAY';
                        $order_payment['payment_method'] = $paymentData["payment_method"];
                        $order_payment['payment_number'] = $paymentData["cel_phone_num"];

                        $designation = 2;
                        break;
                    case 'Tête de liste':
                        $dispatchIdTrans = explode('-',$paymentData['cpm_trans_id']);
                        $idTdl = $dispatchIdTrans[1];
                        $alu = ALaUne::where('id',$idTdl)->first();
                        $frontuser = Frontuser::where('id',$alu->id_frontuser);

                        $order_payment['id_transaction'] = $paymentData['cpm_trans_id'];
                        $order_payment['id_frontuser'] = $alu->id_frontuser;
                        $order_payment['id_alu'] = $alu->id;
                        $order_payment['payment_gateway'] = 'CINETPAY';
                        $order_payment['payment_method'] = $paymentData["payment_method"];
                        $order_payment['payment_number'] = $paymentData["cel_phone_num"];
                        $order_payment['payment_designation'] = $paymentData["cpm_designation"];


                        $designation = 3;

                        break;
                    case 'Slider':
                        $dispatchIdTrans = explode('-',$paymentData['cpm_trans_id']);
                        $idSlider = $dispatchIdTrans[1];
                        $alu = ALaUne::where('id',$idSlider)->first();
                        $frontuser = Frontuser::where('id',$alu->id_frontuser);

                        $order_payment['id_transaction'] = $paymentData['cpm_trans_id'];
                        $order_payment['id_frontuser'] = $alu->id_frontuser;
                        $order_payment['id_alu'] = $alu->id;
                        $order_payment['payment_method'] = $paymentData["payment_method"];
                        $order_payment['payment_number'] = $paymentData["cel_phone_num"];
                        $order_payment['payment_designation'] = $paymentData["cpm_designation"];

                        $designation = 4;
                        break;

                    default :
                        break;

                }

                /*$order_payment['payment_user_id']		= $bookingdata->user_id;
                $order_payment['payment_guest_id']      =*/
                // paiement valide
                if (!empty($paymentData["cpm_result"]) && $paymentData["cpm_result"] == '00') {
                    /*$message = ($message == "")?'Felicitation, votre paiement a été effectué avec succès':$message;
                    $order_payment['message'] = $message;
                    $data = $this->order_payment->insertData($order_payment);
                    $this->send_message_to_admin($message);
                    session(['cinetpay_notification' => 1]);
                    $this->ticket_controller->orderDone($cpm_trans_id);
                    //return redirect()->route('ticket.oderdone', $id_transaction);*/
                    if (isset($designation)):
                        if($designation == 1){
                                 //pour les bon paiement
                                $order_payment['payment_state'] = 1;
                                $order_payment['payment_amount'] = $paymentData["cpm_amount"];
                                $order_payment['payment_status'] = 'SUCCESS';
                             $succes_paiement = 1;
                        }
                        // Pour les prestataires
                        if($designation  == 2){
                            if($paymentData["cpm_amount"]>=montant_prix_unitaire_prestataire()){
                                if($paymentData["cpm_amount"]%montant_prix_unitaire_prestataire() != 0){
                                    //Mauvais paiement
                                    $order_payment['formule'] = null;
                                    $order_payment['montant'] = $paymentData["cpm_amount"];
                                    $order_payment['status'] = 2;
                                    $order_payment['payment_trans_status'] = 'MONTANT INCORRECT';
                                    $order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];
                                    $succes_paiement = 2;
                                }else{
                                    //pour les bon paiement
                                    $order_payment['formule'] = $paymentData["cpm_amount"]/montant_prix_unitaire_prestataire();
                                    $order_payment['status'] = 1;
                                    $order_payment['montant'] = $paymentData["cpm_amount"];
                                    $order_payment['payment_trans_status'] = 'SUCCESS';
                                    $order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];
                                    $succes_paiement = 1;
                                }
                            }
                        }
                        if($designation  == 3 || $designation  == 4){
                            if($paymentData["cpm_amount"]%montant_prix_unitaire_tdl() != 0){
                                $order_payment['formule'] = null;
                                $order_payment['montant'] = $paymentData["cpm_amount"];
                                $order_payment['status'] = 0;

                                $succes_paiement = 2;
                            }else{
                                //pour les bon paiement
                                $order_payment['formule'] = $paymentData["cpm_amount"]/montant_prix_unitaire_prestataire();
                                $order_payment['status'] = 1;
                                $order_payment['montant'] = $paymentData["cpm_amount"];
                                //$order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];

                                $succes_paiement = 1;
                            }
                        }
                    endif;
                }

                // traitement operation dans la bdd
                if (isset($designation)){
                    if($designation == 1){
                        if ($this->order_payment->no_repeat_payment($bookingdata->order_id)):
                            if ($succes_paiement):
                                //dd($paymentData['cpm_trans_id']);
                                /*return redirect()->route('ticket.oderdone',$paymentData['cpm_trans_id'])*/
                                $this->ticket_controller->orderDone($paymentData['cpm_trans_id']);
                                $user = Frontuser::where('id',$bookingdata->user_id)->first();
                                if($user == null) $user = GuestUser::where('guest_id',$bookingdata->gust_id)->first();
                                $event = Event::where('event_unique_id',$bookingdata->event_id)->first();
                                /*$orgId = Organization::where('id', $event->event_org_name)->first();
                                $orgUserData = Frontuser::where('id', $orgId->user_id);*/
                                $message = ['user'=>$user, 'event'=>$event, 'bookingdata'=>$bookingdata, /*'orgEmail' => $orgUserData->email*/];
                                //dd($message);
                                $this->send_message_to_admin_for_ticket_paid($message, $event);
                            endif;
                            $data = $this->order_payment->insertData($order_payment);
                            if($succes_paiement != 1):
                                $command['designation'] = $paymentData['cpm_designation'];
                                $command['payment_method'] = $paymentData['payment_method'];
                                $command['telephone'] =  $paymentData['cel_phone_num'];
                                $command['num_transaction'] =  $paymentData['cpm_trans_id'];
                                $command['code_erreur'] =  $paymentData['cpm_trans_status'];
                                $command["message"] = $paymentData['cpm_error_message'];
                                $command["data_track"] = null;
                                //dd($id_transaction);
                                $this->commande->insertData($command);
                                return $this->cinetpay_annulation($id_transaction);

                            endif;
                        endif;
                    }
                    if($designation == 2){
                        if ($this->souscprestataires->no_repeat_payment($paymentData['cpm_trans_id'])):
                            //dd($paymentData['cpm_trans_id']);
                            if ($succes_paiement == 1):
                                $count = $this->souscprestataires->count_sousc_number($prestataire->id);
                                if($prestataire->status == 3){
                                    Prestataire::where('id',$prestataire->id)->update(['status'=>2]);
                                }
                                $message = "Le paiement de la commande <strong>" . $paymentData['cpm_trans_id']. "</strong> s'est éffectué avec succès !<br> Détails : ".$paymentData['cpm_designation'];
                                $this->send_message_to_admin($message);
                                $data = $this->souscprestataires->insertData($order_payment);
                            elseif($succes_paiement == 2):
                                $message = "Il y a une incohérance dans le paiment n<strong>".$paymentData['cpm_trans_id']."</strong><br>Veuillez contacter l'adminitrateur si vous pensez qu'il s'agit d'une erreur";
                                $this->send_simple_message($prestataire->adresse_mail,$message);
                            endif;
                            if($count>=1 && $prestataire->status == 2){
                                $data = $this->souscprestataires->insertData($order_payment);
                                $this->prestataire_controller->AddNewDateExpire($paymentData['cpm_trans_id']);
                                Prestataire::where('id',$prestataire->id)->update(['status'=>1]);
                                return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                            }elseif($count>=1 && $prestataire->status == 1){
                                $data = $this->souscprestataires->insertData($order_payment);
                                $this->AddNewDateExpire($paymentData['cpm_trans_id']);
                                return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                            }else{
                                $data = $this->souscprestataires->insertData($order_payment);
                            }
                        endif;
                    }
                    if($designation == 3 || $designation == 4){
                        if ($this->alupayment->no_repeat_payment($paymentData['cpm_trans_id'])):
                            //dd($paymentData['cpm_trans_id']);
                            if ($succes_paiement == 1):
                                if($alu->status_service == 0){
                                    //$formule = ($designation == 3)?$paymentData["cpm_amount"]/montant_prix_unitaire_tdl():($designation == 4)?$paymentData["cpm_amount"]/montant_prix_unitaire_slider():"";
                                    
                                    if($designation == 3){
                                        $formule = $paymentData["cpm_amount"]/montant_prix_unitaire_tdl();
                                    }else if($designation == 4){
                                        $formule = $paymentData["cpm_amount"]/montant_prix_unitaire_slider();
                                    }else{
                                        $formule = "";
                                    }
                                    
                                    
                                    $date_fin = Carbon::now()->addWeeks(/*$formule*/1)->format('Y-m-d H:i:s');
                                    ALaUne::where('id',$alu->id)->update(['status_service'=>2,'id_last_transaction'=>$id_transaction]);
                                }
                                $message = "Le paiement de la commande <strong>" . $paymentData['cpm_trans_id']. "</strong> s'est éffectué avec succès !<br> Détails : ".$paymentData['cpm_designation'];
                                $this->send_message_to_admin($message);
                                $data = $this->alupayment->insertData($order_payment);
                            elseif($succes_paiement == 2):
                                $message = "Il y a une incohérance dans le paiment n<strong>".$paymentData['cpm_trans_id']."</strong><br>Veuillez contacter l'adminitrateur si vous pensez qu'il s'agit d'une erreur";
                                $this->send_simple_message($frontuser->email,$message);
                            endif;
                            if($alu->status_service == 1){
                                $data = $this->alupayment->insertData($order_payment);
                                ALaUne::where('id',$alu->id)->update(['id_last_transaction'=>$id_transaction]);
                                $this->prestataire_controller->AddNewDateExpireAlu($paymentData['cpm_trans_id']);
                                return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                            }else{
                                $data = $this->alupayment->insertData($order_payment);
                            }
                        endif;
                    }
            }
                /*if ($cp->isValidPayment()) {
                    // echo 'Felicitation, votre paiement a été effectué avec succès';

                    return redirect()->route('ticket.oderdone', $paymentData['cpm_site_id']);
                    // die();
                } else {
                    // echo 'Echec, votre paiement a échoué pour cause : ' . $cp->_cpm_error_message;
                    return redirect()->route('order.cancel', $paymentData['cpm_site_id'])->with('error',$paymentData['cpm_error_message']);
                    // die();
                }*/
            } catch (Exception $e) {
                $this->send_message_to_admin($e);
                //echo "Erreur :" . $e->getMessage();
                //return redirect()->route('order.cancel',$order_payment['payment_order_id'])->with('error','Erreur lors du paiement');
                // Une erreur s'est produite
            }
        } else {

            // Tentative d'accès direct au lien IPN
            // return $this->cintepay_notification();
        }
    }

    protected function wallet_notification($order_data, $bookingdata, Request $request){
        $data = Frontuser::where('id',$bookingdata->user_id)->first();
        $order_data = json_decode($request->input('order_data'));
        //dd($data);

        $id_transaction = $bookingdata->order_id;
        if(!empty($id_transaction)) {
            try {
                $order_payment = [];

                switch ($order_data->designation) {
                    case 'event_ticket':
                        $bookingdata = $this->ticket_booking->singleOrder($id_transaction);
                        if ($bookingdata->user_id != 0):
                            $order_payment['payment_user_id'] = $bookingdata->user_id/*auth()->guard('frontuser')->user()->id*/
                            ;
                            $order_payment['payment_guest_id'] = null;
                        else:
                            $order_payment['payment_user_id'] = null;
                            $order_payment['payment_guest_id'] = $bookingdata->gust_id;
                        endif;
                        $order_payment['payment_order_id'] = $bookingdata->order_id;
                        $order_payment['payment_event_id'] = $bookingdata->event_id;
                        $order_payment['payment_currency'] = 'FCFA';
                        $order_payment['payment_gateway'] = 'WALLET';
                        $order_payment['payment_method'] = 'WALLET';
                        $order_payment['payment_number'] = '';

                        $designation = 1;
                        break;
                    case 'prestataire' :
                        $dispatchIdTrans = explode('-',$id_transaction);
                        $url_slug = $dispatchIdTrans[0].'-'.$dispatchIdTrans[1];
                        $prestataire = Prestataire::where('url_slug',$url_slug)->first();
                        $order_payment['id_transaction'] = $id_transaction;
                        $order_payment['id_frontuser'] = $prestataire->id_frontusers;
                        $order_payment['id_prestataire'] = $prestataire->id;
                        $order_payment['payment_gateway'] = 'WALLET';
                        $order_payment['payment_method'] = 'WALLET';
                        $order_payment['payment_phone_number'] = '';

                        $designation = 2;
                        break;
                    case 'Tête de liste':
                        $dispatchIdTrans = explode('-',$id_transaction);
                        $idTdl = $dispatchIdTrans[1];
                        $alu = ALaUne::where('id',$idTdl)->first();
                        $frontuser = Frontuser::where('id',$alu->id_frontuser);

                        $order_payment['id_transaction'] = $id_transaction;
                        $order_payment['id_frontuser'] = $alu->id_frontuser;
                        $order_payment['id_alu'] = $alu->id;
                        $order_payment['payment_gateway'] = 'WALLET';
                        $order_payment['payment_method'] = 'WALLET';
                        $order_payment['payment_phone_number'] = '';
                        $order_payment['payment_designation'] = $order_data->designation;


                        $designation = 3;

                        break;
                    case 'Slider':
                        $dispatchIdTrans = explode('-',$id_transaction);
                        $idSlider = $dispatchIdTrans[1];
                        $alu = ALaUne::where('id',$idSlider)->first();
                        $frontuser = Frontuser::where('id',$alu->id_frontuser);

                        $order_payment['id_transaction'] = $id_transaction;
                        $order_payment['id_frontuser'] = $alu->id_frontuser;
                        $order_payment['id_alu'] = $alu->id;
                        $order_payment['payment_method'] = 'WALLET';
                        $order_payment['payment_phone_number'] = '';
                        $order_payment['payment_designation'] = $order_data->designation;
                        $designation = 4;
                        break;

                    default :
                        break;

                }

                // paiement valide
                if ($bookingdata->getUniqueId() !=0) {
                    if (isset($designation)):
                        if($designation == 1){
                            $montant_reel = arrondi_entier_sup($bookingdata->order_amount);
                            /*if ($montant_reel != $bookingdata->getAmountProduct($data)):
                                $order_payment['payment_state'] = 2;
                                $order_payment['payment_status'] = 'MONTANT INCORRECT';
                            else:*/
                                //pour les bon paiement
                                $order_payment['payment_state'] = 1;
                                $order_payment['payment_amount'] =  $bookingdata->getAmountProduct($data);
                                $order_payment['payment_status'] = 'SUCCESS';
                            //endif;
                            $succes_paiement = 1;
                        }
                        // Pour les prestataires
                        if($designation  == 2){
                            if($paymentData["cpm_amount"]>=montant_prix_unitaire_prestataire()){
                                if($paymentData["cpm_amount"]%montant_prix_unitaire_prestataire() != 0){
                                    //Mauvais paiement
                                    $order_payment['formule'] = null;
                                    $order_payment['montant'] = $paymentData["cpm_amount"];
                                    $order_payment['status'] = 2;
                                    $order_payment['payment_trans_status'] = 'MONTANT INCORRECT';
                                    $order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];
                                    $succes_paiement = 2;
                                }else{
                                    //pour les bon paiement
                                    $order_payment['formule'] = $paymentData["cpm_amount"]/montant_prix_unitaire_prestataire();
                                    $order_payment['status'] = 1;
                                    $order_payment['montant'] = $paymentData["cpm_amount"];
                                    $order_payment['payment_trans_status'] = 'SUCCESS';
                                    $order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];
                                    $succes_paiement = 1;
                                }
                            }
                        }
                        if($designation  == 3 || $designation  == 4){
                            if($paymentData["cpm_amount"]%montant_prix_unitaire_tdl() != 0){
                                $order_payment['formule'] = null;
                                $order_payment['montant'] = $paymentData["cpm_amount"];
                                $order_payment['status'] = 0;

                                $succes_paiement = 2;
                            }else{
                                //pour les bon paiement
                                $order_payment['formule'] = $paymentData["cpm_amount"]/montant_prix_unitaire_prestataire();
                                $order_payment['status'] = 1;
                                $order_payment['montant'] = $paymentData["cpm_amount"];
                                //$order_payment['payment_date'] = $paymentData["cpm_payment_date"]." ".$paymentData["cpm_payment_time"];

                                $succes_paiement = 1;
                            }
                        }
                    endif;
                }

                // traitement operation dans la bdd
                if (isset($designation)){
                    if($designation == 1){
                        if ($this->order_payment->no_repeat_payment($bookingdata->order_id)):
                            if ($succes_paiement):
                                //dd($paymentData['cpm_trans_id']);
                                /*return redirect()->route('ticket.oderdone',$paymentData['cpm_trans_id'])*/
                                $this->ticket_controller->orderDone($id_transaction);
                                $user = Frontuser::where('id',$bookingdata->user_id)->first();
                                if($user == null) $user = GuestUser::where('guest_id',$bookingdata->gust_id)->first();
                                $event = Event::where('event_unique_id',$bookingdata->event_id)->first();
                                /*$orgId = Organization::where('id', $event->event_org_name)->first();
                                $orgUserData = Frontuser::where('id', $orgId->user_id);*/
                                $message = ['user'=>$user,'event'=>$event,'bookingdata'=>$bookingdata, /*'orgEmail' => $orgUserData->email*/];
                                //dd($message);
                                $this->send_message_to_admin_for_ticket_paid($message, $event);
                            endif;
                            $data = $this->order_payment->insertData($order_payment);
                            if($succes_paiement != 1):
                                return redirect()->route('order.cancel', $bookingdata->order_id);
                            endif;
                        endif;
                    }
                    if($designation == 2){
                        if ($this->souscprestataires->no_repeat_payment($paymentData['cpm_trans_id'])):
                            //dd($paymentData['cpm_trans_id']);
                            if ($succes_paiement == 1):
                                $count = $this->souscprestataires->count_sousc_number($prestataire->id);
                                if($prestataire->status == 3){
                                    Prestataire::where('id',$prestataire->id)->update(['status'=>2]);
                                }
                                $message = "Le paiement de la commande <strong>" . $paymentData['cpm_trans_id']. "</strong> s'est éffectué avec succès !<br> Détails : ".$paymentData['cpm_designation'];
                                $this->send_message_to_admin($message);
                                $data = $this->souscprestataires->insertData($order_payment);
                            elseif($succes_paiement == 2):
                                $message = "Il y a une incohérance dans le paiment n<strong>".$paymentData['cpm_trans_id']."</strong><br>Veuillez contacter l'adminitrateur si vous pensez qu'il s'agit d'une erreur";
                                $this->send_simple_message($prestataire->adresse_mail,$message);
                            endif;
                            if($count>=1 && $prestataire->status == 2){
                                $data = $this->souscprestataires->insertData($order_payment);
                                $this->prestataire_controller->AddNewDateExpire($paymentData['cpm_trans_id']);
                                Prestataire::where('id',$prestataire->id)->update(['status'=>1]);
                                return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                            }elseif($count>=1 && $prestataire->status == 1){
                                $data = $this->souscprestataires->insertData($order_payment);
                                $this->AddNewDateExpire($paymentData['cpm_trans_id']);
                                return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                            }else{
                                $data = $this->souscprestataires->insertData($order_payment);
                            }
                        endif;
                    }
                    if($designation == 3 || $designation == 4){
                        if ($this->alupayment->no_repeat_payment($paymentData['cpm_trans_id'])):
                            //dd($paymentData['cpm_trans_id']);
                            if ($succes_paiement == 1):
                                if($alu->status_service == 0){
                                    //$formule = ($designation == 3)?$paymentData["cpm_amount"]/montant_prix_unitaire_tdl():($designation == 4)?$paymentData["cpm_amount"]/montant_prix_unitaire_slider():"";
                                    
                                    if($designation == 3){
                                        $formule = $paymentData["cpm_amount"]/montant_prix_unitaire_tdl();
                                    }else if($designation == 4){
                                        $formule = $paymentData["cpm_amount"]/montant_prix_unitaire_slider();
                                    }else{
                                        $formule = "";
                                    }
                                    
                                    $date_fin = Carbon::now()->addWeeks(/*$formule*/1)->format('Y-m-d H:i:s');
                                    ALaUne::where('id',$alu->id)->update(['status_service'=>2,'id_last_transaction'=>$id_transaction]);
                                }
                                $message = "Le paiement de la commande <strong>" . $paymentData['cpm_trans_id']. "</strong> s'est éffectué avec succès !<br> Détails : ".$paymentData['cpm_designation'];
                                $this->send_message_to_admin($message);
                                $data = $this->alupayment->insertData($order_payment);
                            elseif($succes_paiement == 2):
                                $message = "Il y a une incohérance dans le paiment n<strong>".$paymentData['cpm_trans_id']."</strong><br>Veuillez contacter l'adminitrateur si vous pensez qu'il s'agit d'une erreur";
                                $this->send_simple_message($frontuser->email,$message);
                            endif;
                            if($alu->status_service == 1){
                                $data = $this->alupayment->insertData($order_payment);
                                ALaUne::where('id',$alu->id)->update(['id_last_transaction'=>$id_transaction]);
                                $this->prestataire_controller->AddNewDateExpireAlu($paymentData['cpm_trans_id']);
                                return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                            }else{
                                $data = $this->alupayment->insertData($order_payment);
                            }
                        endif;
                    }
                }
            } catch (Exception $e) {
                $this->send_message_to_admin($e);
            }
        }
    }

    public function cinetpay_retour_old(){
        if (isset($_POST['cpm_trans_id'])) {
            // SDK PHP de CinetPay
            //require_once __DIR__ . '/../src/cinetpay.php';
            try {
                // Initialisation de CinetPay et Identification du paiement
                $id_transaction = $_POST['cpm_trans_id'];
                //Veuillez entrer votre apiKey et site ID
                $apiKey = "12225072435af2f658189760.36336854";
                $site_id = "332112";
                $plateform = "PROD";
                $version = "V1";
                $CinetPay = new CinetPay($site_id, $apiKey, $plateform, $version);
                //Prise des données chez CinetPay correspondant à ce paiement
                $CinetPay->setTransId($id_transaction)->getPayStatus();
                $cpm_site_id = $CinetPay->_cpm_site_id;
                $signature = $CinetPay->_signature;
                $cpm_amount = $CinetPay->_cpm_amount;
                $cpm_trans_id = $CinetPay->_cpm_trans_id;
                $cpm_custom = $CinetPay->_cpm_custom;
                $cpm_currency = $CinetPay->_cpm_currency;
                $cpm_payid = $CinetPay->_cpm_payid;
                $cpm_payment_date = $CinetPay->_cpm_payment_date;
                $cpm_payment_time = $CinetPay->_cpm_payment_time;
                $cpm_error_message = $CinetPay->_cpm_error_message;
                $payment_method = $CinetPay->_payment_method;
                $cpm_phone_prefixe = $CinetPay->_cpm_phone_prefixe;
                $cel_phone_num = $CinetPay->_cel_phone_num;
                $cpm_ipn_ack = $CinetPay->_cpm_ipn_ack;
                $created_at = $CinetPay->_created_at;
                $updated_at = $CinetPay->_updated_at;
                $cpm_result = $CinetPay->_cpm_result;
                $cpm_trans_status = $CinetPay->_cpm_trans_status;
                $cpm_designation = $CinetPay->_cpm_designation;
                $buyer_name = $CinetPay->_buyer_name;

               //dd($id_transaction);
                /*$id = $request->get('paymentId');
                $token = $request->get('token');
                $payer_id = $request->get('PayerID');

                $payment = new getById($id, $this->_apiContext);
                $paymentExecution = new PaymentExecution();
                   $paymentExecution->setPayerId($payer_id);
                $executePayment = $payment->execute($paymentExecution, $this->_apiContext);
                echo $executePayment->state;
                   dd($executePayment); */
                /* switch($cpm_trans_id){
                    case "event_ticket" :
                        // Au cas le montant du billet n'est pas celui payé -- donc en cas de fraude --
                        //dd($paymentData);
                        $order_payment = $this->event_record($cpm_trans_id);
                        $message = ($order_payment['failure_message'] == 'REFUSED')?'Tentative de fraude':'';
                        break;
                    default :
                        $message = 'Nous ne reconnaissons pas ce service : '.$cpm_designation;
                        //dd($message);
                        break;
                }*/
                /*$order_payment['payment_user_id']		= $bookingdata->user_id;
                $order_payment['payment_guest_id']      = ($bookingdata->gust_id != null)?$bookingdata->gust_id:null;
                $order_payment['payment_order_id']		= $bookingdata->order_id;
                $order_payment['payment_event_id']		= $bookingdata->event_id;
                $order_payment['payment_amount']		= ($cpm_amount >= $bookingdata->order_amount)?$cpm_amount:0;
                // Au cas le montant du billet n'est pas celui payé -- donc en cas de fraude ---

                $order_payment['payment_currency']		= 'FCFA';
                $order_payment['payment_status']		= 'Done';
                $order_payment['payment_gateway']		= 'CinetPay';*/
                $order_payment = [];
                switch($cpm_designation){
                    case 'event_ticket':
                        $bookingdata	= $this->ticket_booking->singleOrder($id_transaction);
                        $paymentData    = $this->order_payment->get_data($id_transaction);
                        $saveForTranking = $paymentData;
                        break;
                    case 'prestataire':
                        $dispatchIdTrans = explode('-',$id_transaction);
                        $url_slug = $dispatchIdTrans[0].'-'.$dispatchIdTrans[1];
                        $souscprestataire = $this->souscprestataires->getDataByIdTransaction($id_transaction);
                        $saveForTranking = $souscprestataire;
                        break;
                    case 'Tête de liste':
                        $dispatchIdTrans = explode('-',$id_transaction);
                        $id = $dispatchIdTrans[1];
                        $alu = ALaUne::where('id',$id)->first();
                        $alupayment = AluPayment::where('id_transaction',$id_transaction)->first();
                        $frontuser = Frontuser::where('id',$alu->id_frontuser);

                        $designation = 3;
                        $saveForTranking = $alupayment;
                        break;
                    case 'Slider':
                        $dispatchIdTrans = explode('-',$id_transaction);
                        $id = $dispatchIdTrans[1];
                        $alu = ALaUne::where('id',$id)->first();
                        $alupayment = AluPayment::where('id_transaction',$id_transaction)->first();
                        $frontuser = Frontuser::where('id',$alu->id_frontuser);

                        $designation = 4;
                        $saveForTranking = $alupayment;
                        break;
                }

                //return redirect()->route('ticket.oderdone', $order_id);

                if(!empty($cpm_result) && $cpm_result == '00') {
                    if ($cpm_designation == 'event_ticket') {
                        if (isset($paymentData) && $paymentData != null):
                            if ($paymentData->payment_state == 1):
                                return redirect()->route('order.success', $id_transaction);
                            elseif ($paymentData->payment_state == 0):
                                $montant_reel = arrondi_entier_sup($bookingdata->order_id * cinetpay_commission());
                                /*if ($montant_reel != $cpm_amount):
                                    OrderPayment::where('payment_order_id')->update(['payment_state' => 2, 'payment_status' => 'MONTANT INCORRECT']);
                                else:*/
                                    //pour les bon paiement
                                    OrderPayment::where('payment_order_id')->update(['payment_state' => 1, 'payment_amount' => $cpm_amount, 'payment_status' => 'SUCCESS']);
                                //endif;
                                $this->ticket_controller->orderDone($cpm_trans_id);
                                $message = "Le paiement de la commande <strong>" . $bookingdata->order_id . "</strong> s'est éffectué avec succès !";
                                $this->send_message_to_admin($message);
                            elseif ($paymentData->payment_state == 2):
                                return redirect()->route('events.details', $id_transaction)->with('Erreur : Le montant payé est différent de ce lui de l\'événement. Veuillez contacter l\'administrateur pour plus les détails');
                            endif;
                        else:
                            if ($bookingdata->user_id != 0):
                                $order_payment['payment_user_id'] = $bookingdata->user_id/*auth()->guard('frontuser')->user()->id*/
                                ;
                                $order_payment['payment_guest_id'] = null;
                            else:
                                $order_payment['payment_user_id'] = 0;
                                $order_payment['payment_guest_id'] = $bookingdata->gust_id;
                            endif;

                            /*$order_payment['payment_user_id']		= $bookingdata->user_id;
                            $order_payment['payment_guest_id']      =*/
                            $order_payment['payment_order_id'] = $bookingdata->order_id;
                            $order_payment['payment_event_id'] = $bookingdata->event_id;
                            $order_payment['payment_currency'] = 'FCFA';
                            $order_payment['payment_gateway'] = 'CINETPAY';
                            $order_payment['payment_method'] = $payment_method;
                            $order_payment['payment_number'] = '+' . $cpm_phone_prefixe . $cel_phone_num;
                        endif;
                    } elseif ($cpm_designation == 'prestataire') {
                        if ($souscprestataire == null) {
                            $prestataire = Prestataire::where('url_slug', $url_slug)->first();
                            $order_payment['id_transaction'] = $id_transaction;
                            $order_payment['id_frontuser'] = $prestataire->id_frontusers;
                            $order_payment['id_prestataire'] = $prestataire->id;
                            $order_payment['payment_gateway'] = 'CINETPAY';
                            $order_payment['payment_method'] = $payment_method;
                            $order_payment['payment_phone_number'] = '+' . $cpm_phone_prefixe . $cel_phone_num;
                            $order_payment['payment_date'] = $cpm_payment_date . " " . $cpm_payment_time;
                            if ($cpm_amount >= montant_prix_unitaire_prestataire()) {
                                if ($cpm_amount%montant_prix_unitaire_prestataire() != 0) {
                                    $order_payment['formule'] = null;
                                    $order_payment['montant'] = $cpm_amount;
                                    $order_payment['status'] = 2;
                                    $order_payment['payment_trans_status'] = 'MONTANT INCORRECT';
                                } else {
                                    //pour les bon paiement
                                    $order_payment['formule'] = $cpm_amount /montant_prix_unitaire_prestataire();
                                    $order_payment['status'] = 1;
                                    $order_payment['montant'] = $cpm_amount;
                                    $order_payment['payment_trans_status'] = 'SUCCESS';
                                }
                            }
                            $data = $this->souscprestataires->insertData($order_payment);
                            Prestataire::where('id', $prestataire->id)->update(['status' => 2]);
                            return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                        } elseif ($souscprestataire != null) {
                            return redirect()->route('pre.index')->with('success', 'Paiement effectué avec succes');
                        }
                        //Mise à la une
                    } elseif ($cpm_designation == 'Tête de liste' || $cpm_designation == 'Slider') {
                        if ($alupayment == null){
                            $order_payment['id_transaction'] = $cpm_trans_id;
                            $order_payment['id_frontuser'] = $alu->id_frontuser;
                            $order_payment['id_alu'] = $alu->id;
                            $order_payment['payment_method'] = $payment_method;
                            $order_payment['payment_phone_number'] = '+' . $cpm_phone_prefixe . $cel_phone_num;
                            $order_payment['payment_designation'] = $cpm_designation;

                            if ($cpm_amount >= montant_prix_unitaire_prestataire()) {
                                if ($cpm_amount % montant_prix_unitaire_prestataire() != 0) {
                                    $order_payment['formule'] = null;
                                    $order_payment['montant'] = $cpm_amount;
                                    $order_payment['status'] = 2;
                                    $order_payment['payment_trans_status'] = 'MONTANT INCORRECT';
                                    $succes_paiement = 0;
                                } else {
                                    //pour les bon paiement
                                    $order_payment['formule'] = $cpm_amount / montant_prix_unitaire_prestataire();
                                    $order_payment['status'] = 1;
                                    $order_payment['montant'] = $cpm_amount;
                                    $order_payment['payment_trans_status'] = 'SUCCESS';
                                    $succes_paiement = 1;
                                }
                            }
                            if ($succes_paiement):
                                if($alu->status_service == 0){
                                    //$formule = ($designation == 3)?$cpm_amount/montant_prix_unitaire_tdl():($designation == 4)?$cpm_amount/montant_prix_unitaire_slider():"";
                                    
                                    if($designation == 3){
                                        $formule = $cpm_amount/montant_prix_unitaire_tdl();
                                    }else if($designation == 4){
                                        $formule = $cpm_amount/montant_prix_unitaire_slider();
                                    }else{
                                        $formule = "";
                                    }
                                    
                                    $date_fin = Carbon::now()->addWeeks($formule)->format('Y-m-d H:i:s');
                                    ALaUne::where('id',$alu->id)->update(['status_service'=>2,'id_last_transaction'=>$id_transaction,'date_fin'=>$date_fin]);
                                }
                                $message = "Le paiement de la commande <strong>" . $cpm_trans_id. "</strong> s'est éffectué avec succès !<br> Détails : ".$cpm_designation;
                                $this->send_message_to_admin($message);
                                $data = $this->alupayment->insertData($order_payment);
                            elseif(!$succes_paiement):
                                $message = "Il y a une incohérance dans le paiment n<strong>".$cpm_trans_id."</strong><br>Veuillez contacter l'adminitrateur si vous pensez qu'il s'agit d'une erreur";
                                $this->send_simple_message($frontuser->email,$message);
                            endif;
                            if($alu->status_service == 1){
                                $data = $this->alupayment->insertData($order_payment);
                                $this->prestataire_controller->AddNewDateExpireAlu($cpm_trans_id);
                                return redirect()->route('alu.index')->with('success', 'Paiement effectué avec succes');
                            }else{
                                $data = $this->alupayment->insertData($order_payment);
                            }
                            return redirect()->route('alu.index')->with('success', 'Paiement effectué avec succes');
                        } elseif ($alupayment != null) {
                            return redirect()->route('alu.index')->with('success', 'Paiement effectué avec succes');
                        }
                    }
                    /*else:
                        $order_payment['payment_state']         = 0;
                        $order_payment['payment_amount']		= $cpm_amount;
                        $order_payment['payment_status']		= 'ECHEC';
                        $message = "Paiement ".$bookingdata->order_id."Echoué";
                        $this->send_message_to_admin($message);*/
                    /*else{
                        if($this->order_payment->no_repeat_no_repeat_payment):
                            die();
                        else:
                            $order_payment['payment_state']         = 0;
                            $order_payment['payment_amount']		= $cpm_amount;
                            $order_payment['payment_status']		= 'ECHEC';
                            $message = "Paiement ".$bookingdata->order_id."Echoué";
                            $this->send_message_to_admin($message);
                        endif;
                        //Le paiement a échoué
                        /*$message = $message = ($message == "")?'Echec, votre paiement a échoué pour cause : ' . $cpm_error_message:$message;
                        $order_payment['message'] = $message;
                        $data = $this->order_payment->insertData($order_payment);
                        $result = $this->ticket_controller->ticketCancel($cpm_trans_id);
                        session(['cinetpay_notification' => 1]);
                        if($result){
                            $message = 'Le ticket a été supprimé';
                            $this->send_message_to_admin($message);
                        }else{
                            $message = 'Le ticket n\'a pas pu être supprimer'.$cpm_trans_id;
                            $this->send_message_to_admin($message);
                        }
                        $this->send_message_to_admin($message);
                        die();
                    }*/
                }else{

                    $cinetpayTrack['designation'] = $cpm_designation;
                    $cinetpayTrack['payment_method'] = $payment_method;
                    $cinetpayTrack['telephone'] =  "(.".$cpm_phone_prefixe.") ".$cel_phone_num;
                    $cinetpayTrack['num_transaction'] =  $cpm_trans_id;
                    $cinetpayTrack['code_erreur'] =  $cpm_result;
                    $cinetpayTrack["message"] = $cpm_error_message;
                    $cinetpayTrack["data_track"] = json_encode($saveForTranking);
                    //dd($id_transaction);
                    $this->cinetpay_track->insertData($cinetpayTrack);
                    return $this->cinetpay_annulation($id_transaction);

                }
            } catch (Exception $e) {
                //$this->cinetpay_annulation($id_transaction);
                //$this->send_message_to_admin($e);
                //echo "Erreur :" . $e->getMessage();
                //return redirect()->route('order.cancel',$order_payment['payment_order_id'])->with('error','Erreur lors du paiement');
                // Une erreur s'est produite
            }
        } else {

            // Tentative d'accès direct au lien IPN
            // return $this->cintepay_notification();
        }
    }

    public function cinetpay_retour(){
        if (isset($_POST['transaction_id'])) {
            // SDK PHP de CinetPay
            //require_once __DIR__ . '/../src/cinetpay.php';
            try {
                // Initialisation de CinetPay et Identification du paiement
                $id_transaction = $_POST['transaction_id'];
                //Veuillez entrer votre apiKey et site ID
                $apiKey = "12225072435af2f658189760.36336854";
                $site_id = "332112";
                $version = "V2";
                $CinetPay = new CinetPayNew($site_id, $apiKey, $version);
                //dd($CinetPay);
                //Prise des données chez CinetPay correspondant à ce paiement
                $CinetPay->setTransId($id_transaction)->getPayStatus();
                $cpm_site_id = $CinetPay->site_id;
                $signature = $CinetPay->token;
                $cpm_amount = $CinetPay->chk_amount;
                $cpm_trans_id = $CinetPay->transaction_id;
                $cpm_currency = $CinetPay->currency;
                $cpm_payment_date = $CinetPay->chk_payment_date;
                $cpm_error_message = $CinetPay->chk_message;
                $payment_method = $CinetPay->chk_payment_method;
                $cel_phone_num = $CinetPay->customer_phone_number;
                $cpm_result = $CinetPay->chk_code;
                $cpm_trans_status = $CinetPay->chk_message;
                $cpm_designation = $CinetPay->chk_description;
                $buyer_name = $CinetPay->customer_name;
                $metadata = $CinetPay->chk_metadata;

                $order_payment = [];
                //return redirect()->route('ticket.oderdone', $order_id);
                $bookingdata	= $this->ticket_booking->singleOrder($id_transaction);
                //dd($cpm_designation);
				
				Log::info($CinetPay);

                if(!empty($cpm_result) && $cpm_result == '00') {
                    if ($cpm_designation == 'event_ticket') {
                        
                        $order_payment['payment_user_id'] = $bookingdata->user_id;
						$order_payment['payment_guest_id'] = $bookingdata->gust_id;
                        $order_payment['payment_order_id'] = $bookingdata->order_id;
                        $order_payment['payment_event_id'] = $bookingdata->event_id;
                        $order_payment['payment_currency'] = $cpm_currency;
                        $order_payment['payment_gateway'] = "CINETPAY";
                        $order_payment['payment_method'] = $payment_method;
                        $order_payment['payment_state'] = 1;
                        $order_payment['payment_status'] = $cpm_trans_status;
                        $order_payment['payment_amount'] = $cpm_amount;
                        $this->order_payment->insertData($order_payment);

                        $paymentData = $this->order_payment->get_data($id_transaction);
                        //dd($paymentData);
                    
                        $designation = 1;
                        $succes_paiement = 1;
                        if(isset($paymentData) && $paymentData != null):
                            if ($paymentData->payment_state == 1):
                                // if (isset($designation)) {
                                //     if ($designation == 1) {
                                //             if ($succes_paiement) {
                                //                 $this->ticket_controller->orderDone($id_transaction);

                                //                 $user = Frontuser::where('id',$bookingdata->user_id)->first();

                                //                 if($user == null) $user = GuestUser::where('guest_id',$bookingdata->gust_id)->first();

                                //                 $event = Event::where('event_unique_id',$bookingdata->event_id)->first();

                                //                 $message = ['user'=>$user,'event'=>$event,'bookingdata'=>$bookingdata];
                                //                 //dd($message);
                                //                 $this->send_message_to_admin_for_ticket_paid($message, $event);
                                //             }
                                //     }
                                // }
                                return redirect()->route('order.success', $id_transaction);
                            elseif ($paymentData->payment_state == 0):
                                $montant_reel = arrondi_entier_sup($bookingdata->order_id * cinetpay_commission());
                                if ($montant_reel != $cpm_amount):
                                    OrderPayment::where('payment_order_id')->update(['payment_state' => 2, 'payment_status' => 'MONTANT INCORRECT']);
                                endif;
                                
                            elseif ($paymentData->payment_state == 2):
                                return redirect()->route('events.details', $id_transaction)->with('Erreur : Le montant payé est différent de ce lui de l\'événement. Veuillez contacter l\'administrateur pour plus les détails');
                            endif;
                        endif;

                    } 
                }else{

                    $command['designation'] = $cpm_designation;
                    $command['payment_method'] = $payment_method;
                    $command['telephone'] =  $cel_phone_num;
                    $command['num_transaction'] =  $cpm_trans_id;
                    $command['code_erreur'] =  $cpm_result;
                    $command["message"] = $cpm_error_message;
                    // $command["data_track"] = json_encode($saveForTranking);
                    //dd($id_transaction);
                    // $this->commande->insertData($command);
                    return $this->cinetpay_annulation($id_transaction);

                }
				
            } catch (Exception $e) {
                //$this->cinetpay_annulation($id_transaction);
                //$this->send_message_to_admin($e);
                //echo "Erreur :" . $e->getMessage();
                //return redirect()->route('order.cancel',$order_payment['payment_order_id'])->with('error','Erreur lors du paiement');
                // Une erreur s'est produite
            }
        } else {

            // Tentative d'accès direct au lien IPN
            // return $this->cintepay_notification();
        }
    }


    public function cinetpay_annulation($order_id){
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
		$order_payment['payment_guest_id'] = $bookingdata->gust_id;
        $order_payment['payment_order_id']		= $bookingdata->order_id;
        $order_payment['payment_event_id']		= $bookingdata->event_id;
        $order_payment['payment_amount']		= $bookingdata->order_amount;
        $order_payment['payment_currency']		= 'FCFA';
        $order_payment['payment_status']		= 'Done';
        $order_payment['payment_gateway']		= 'CinetPay';

        $data = $this->order_payment->insertData($order_payment);
        return redirect()->route('ticket.oderdone', $order_id);
    }

    public function event_record(Array $paymentData){
        $data_information = $this->ticket_booking->getOrderData($paymentData['cpm_trans_id']);
        $order_payment['payment_user_id']		= $data_information->user_id;
        $order_payment['payment_guest_id']      = ($data_information->gust_id != null)?$data_information->gust_id:null;
        $order_payment['payment_order_id']		= $data_information->order_id;
        $order_payment['payment_event_id']		= $data_information->event_id;
        $montant_cinetpay = arrondi_entier_sup(1.035*$data_information->order_amount);
        //dd($montant_cinetpay,$paymentData['cpm_amount']);
        $order_payment['payment_amount']		= ((int)$paymentData['cpm_amount'] == $montant_cinetpay)?$paymentData['cpm_amount']:0;
        //dd((int)$paymentData['cpm_amount'] == $montant_cinetpay);
        if($order_payment['payment_amount'] == 0){
            $order_payment['failure_message'] = 'Fraude';
            $message = "Un utilisateur a tenté de pirater le mode de paiement de la plateforme <br> Montant sur notre serveur : "." $montant_cinetpay "." Montant perçu par cinetpay : ".$paymentData['cpm_amount'] ;
            $order_payment['payment_status']		= 'REFUSED';
        }else{
            $order_payment['failure_message'] = 'Fraude';
            $order_payment['payment_status']		= 'SUCCESS';
        }

        // Au cas le montant du billet n'est pas celui payé -- donc en cas de fraude ---
        $order_payment['payment_currency']		= 'FCFA';
        $order_payment['payment_gateway']		= 'CINETPAY';
        return $order_payment;
    }

    public function prestataire_record(){

    }

    public function alu_record(){

    }

    public function AddNewDateExpireAlu($idTransaction){
        $dispatchIdTrans = explode('-',$idTransaction);
        $id = $dispatchIdTrans[1];

        $alu = ALaUne::where('id',$id)->first();
        $alupayment = AluPayment::where('id_transaction',$idTransaction);

        $oldDate = Carbon::parse($alu->date_fin);
        $newDateExpire = $oldDate;
        $dateExpiration = $newDateExpire->addWeeks($alupayment->formule)->format('Y-m-d H:i:s');
        ALaUne::where('id',$id)->update(['date_fin'=>$dateExpiration]);
        return 1;
    }

    public function AddNewDateExpire($idTransaction){
        $dispatchIdTrans = explode('-',$idTransaction);
        $url_slug = $dispatchIdTrans[0].'-'.$dispatchIdTrans[1];

        $detailsSouscription = SouscPrestataire::where('id_transaction',$idTransaction)->first();
        $today = Carbon::now();
        $dateExpiration = Carbon::now()->addMonths($detailsSouscription->formule)->format('Y-m-d H:i:s');
        Prestataire::where('url_slug',$url_slug)->update(['status'=>1]);
        SouscPrestataire::where('id_transaction',$idTransaction)->update(['payment_expire'=>$dateExpiration]);
        $data = $this->prestataires->getPaidData();
        return view('Admin.prestataire.prestatairesview',compact('data'));
    }



    public function arrondi_entier_sup($montant){
        if($montant%5 != 0){
            $montant = ceil($montant);
            while($montant%5 != 0){
                $montant++;
            }
            /*ceil(1.035*$bookingdata->order_amount);
            while($montant%5 != 0){
                $montant++;
            }*/
        }
        return $montant;
    }




}

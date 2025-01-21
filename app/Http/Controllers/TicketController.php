<?php

namespace App\Http\Controllers;

use App\Http\Controllers\admin\FrontuserController;
use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\EventCategory;
use App\Event;
use App\EventTicket;
use App\Organization;
use Validator;
use App\Booking;
use App\orderTickets;
use App\orderPayment;
use App\GuestUser;
use App\Frontuser;
use PDF;
use Mail;
use File;
use Carbon\Carbon;
use Illuminate\Routing\RouteCollection;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use Illuminate\Support\Facades\Input;
use RealRashid\SweetAlert\Facades\Alert;
use Bavix\Wallet\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\EventTicketsCoupon;
use App\CouponEnum;
use App\Models\Clients_pays;

use Illuminate\Support\Facades\Log;


class TicketController extends FrontController{

    public function __construct() {
    	parent::__construct();
    	$this->event = new Event;
    	$this->event_ticket = new EventTicket;
    	$this->event_category = new EventCategory;
    	$this->organization = new Organization;
    	$this->ticket_booking = new Booking;
    	$this->order_tickets = new orderTickets;
    	$this->order_payment = new orderPayment;
    	$this->guest_user = new GuestUser;
		$this->frontuser = new Frontuser;
	}

	public function guestLogin(Request $request) {

        $input = $request->all();

        $this->validate($request,[
            'guestuserName' => 'required',
            'guestUserEmail' => 'required|email',
            'guestUserPhone' => 'required',
            'countryCode' => 'required',
        ]);
        $guestuserName 	= $input['guestuserName'];
        $guestUserEmail = $input['guestUserEmail'];
        $guestUserPhone = $input['guestUserPhone'];
        $countryCode =  $input['countryCode'];

    	$getGuestUser = $this->guest_user->searchByEmail($guestUserEmail);
    	if(is_null($getGuestUser)){
        	$userdata = ['guest_id' => str_shuffle(time()), 'user_name' => $guestuserName, 'guest_email' => $guestUserEmail, 'cellphone' => $guestUserPhone];
    		$guestUserData = $this->guest_user->insertData($userdata);
    	}else{
    		$upDate['user_name'] = $guestuserName;
            $upDate['cellphone'] = $guestUserPhone;
            $upDate['countryCode'] = $countryCode;
    		$update_data = $this->guest_user->updateData($upDate, $getGuestUser->guest_id);
    		$guestUserData = $getGuestUser;
    	}
    	$userdatas = ['id' => $guestUserData->guest_id, 'UserName' => $guestUserData->user_name, 'GuestEmail' => $guestUserData->guest_email];
		if(! auth()->guard('frontuser')->check()) {
			if(!\Session::has('guestUser')){
				\Session::put('guestUser', $userdatas);
			}
		}
        $response = guestSessionData();
        return response()->json($response);
    }
 

	public function booking(Request $request) { 
		//dd( $request);
		$input = $request->all();
        $userCellPhone = null;
		if(isset($input["userCellphone"])){
		    $userCellPhone = $input["userCellphone"];
            Frontuser::where("id", auth()->guard('frontuser')->user()->id)->update(["cellphone" => $userCellPhone]);
        }
		$client_token		= str_shuffle(csrf_token());
		$bookingOrder_id	= generate_booking_code($input['event_id']);
		if(auth()->guard('frontuser')->check()):
			$bookingData['user_id'] = auth()->guard('frontuser')->user()->id;
			$bookingData['gust_id'] = null;
		else:
			$bookingData['user_id'] = 0;
			$bookingData['gust_id'] = guestSessionData()->id;
		endif;

		$bookingData['event_id'] 			= $input['event_id'];
		$bookingData['order_id']			= $bookingOrder_id;
		$bookingData['client_token']		= $client_token;
        
        $bookingData['discount']		= $input['total_remise'];
        $bookingData['discount_type']		= $input['total_remise_type'];
        
        $discount		= $input['total_remise'];
        $discount_type	= $input['total_remise_type'];
        $codecoupon 	= $input['codecoupon'];
    
        $bookingData['discount_code'] = $input['codecoupon'];
                
        
		if (isset($input['event_code'])) {
			$ecode = Event::where('event_unique_id',$bookingData['event_id'])->first();
			if ($input['event_code'] != $ecode->event_code) {
				return redirect()->back()->with('notmatch','Event code not match');
			}
		}

		if($input['total_ticket'] == 0){
			return redirect()->back();
		}
		$order_t_id = array();
		$order_t_title = array();
		$order_t_price = array();
		$order_t_fees = array();
		$order_t_qty = array();
        
        $totalAmount=0;

		foreach ($input['ticket_type_qty'] as $key => $value) {

			if($value != 0){
				$quanty		= $input['ticket_type_qty'][$key];
				$ticket_id 	= $input['ticket_id'][$key];
				$ticket 	= $this->event_ticket->ticket_by_id($ticket_id);

				if(isset($input['ticket_type_dns'][$key])){
					//$ticketPriceActual = number_format(floatval($input['ticket_type_dns'][$key]),2, '.', '');
//                    $ticketPriceActual = number_format(intval($input['ticket_type_dns'][$key]),0, ',', ' ');
                    $ticketPriceActual = intval($input['ticket_type_dns'][$key]);
				}else{
					//$ticketPriceActual = number_format(floatval($ticket->ticket_price_actual),2, '.', '');
//                    $ticketPriceActual = number_format(intval($ticket->ticket_price_actual),0, ',', ' ');
                    /*$ticketPriceActual = intval($ticket->ticket_price_actual);*/
                    $ticketPriceActual = intval($ticket->ticket_price_buyer);
				}
				/* DONATE TICKET QTY. */
				if($ticket->ticket_type == 2){
					$quanty = intval(1);
				}
				/* DONATE TICKET QTY. */
				/* TICKET COMMISSION AND FEES */
                //dd(intval($ticketPriceActual), intval($ticket->ticket_commission));
				$orderTcommission	= ($ticketPriceActual * 3.5) / 100;
                //dd($orderTcommission);
				if($ticket->ticket_services_fee == 1){
					/*$orderTfees	= floatval($orderTcommission);*/
                    $orderTfees	= $orderTcommission;
					$pfees=$ticketPriceActual+$orderTfees;
				}else{
					//$orderTfees	= floatval(0);
                    $orderTfees	= intval(0);
					$pfees=$ticketPriceActual;					
				}
				/* TICKET COMMISSION AND FEES */
				/* TICKET DATA */
				if($ticket->ticket_qty >= $quanty){
					$order_t_id[]			= $ticket_id;
					$order_t_title[]		= $ticket->ticket_title;
					$order_t_price[]		= $ticketPriceActual;
//					$order_t_fees[]			= number_format(floatval($orderTfees), 2, '.', '');
//                    $order_t_fees[]			= number_format(intval($orderTfees), 0, ',', ' ');
                    $order_t_fees[]			= $orderTfees;
//					$order_t_commission[]	= number_format(floatval($orderTcommission),2, '.', '');
//                    $order_t_commission[]	= number_format(intval($orderTcommission),0, ',', ' ');
                    $order_t_commission[]	= $orderTcommission;
					$order_t_qty[]			= $quanty;
					//$order_commission[]		= floatval($orderTcommission) * intval($quanty);
                    $order_commission[]		= intval($orderTcommission) * intval($quanty);
					/*$order_Tamount[]		= ($ticketPriceActual+$orderTfees)*$quanty;*/
                    $order_Tamount[]		= $totalAmount+(($pfees)*$quanty);
                    $totalAmount=$totalAmount+(($pfees)*$quanty);
				}
				/* TICKET DATA */
				$ticketId = $ticket->ticket_id;
				$ticket_update = $this->event_ticket->decres_ticket_qty($ticketId, intval($quanty));
				$ticket_data['ticket_remaning_qty']	= intval($ticket->ticket_remaning_qty) - intval($quanty);
			}
		}
		/*tickets data*/
		$bookingData['order_tickets']		= $input['total_ticket'];
		/*$bookingData['order_amount']		= number_format(array_sum($order_Tamount),2, '.', '');
		$bookingData['order_commission']	= number_format(array_sum($order_commission),2, '.', '');*/
//        $bookingData['order_amount']		= number_format(array_sum($order_Tamount),0, ',', ' ');
//        $bookingData['order_commission']	= number_format(array_sum($order_commission),0, ',', ' ');
        
        if(!empty($codecoupon)){
            
            if($discount_type=='percentage'){    
                $discount_amount = ($totalAmount*$discount)/100;
                $totalAmount = $totalAmount - $discount_amount;
            }else{
                $totalAmount = $totalAmount - $discount;
            }
			\Session::push('discount', $discount);
			\Session::push('discount_type', $discount_type);            
        }

        $bookingData['order_amount']		= $totalAmount;//array_sum($order_Tamount);
        $bookingData['order_amount_nodiscount']		= array_sum($order_Tamount);
        $bookingData['order_commission']	= array_sum($order_commission);
		/*serialize data*/
		$bookingData['order_t_id']			= serialize($order_t_id);
		$bookingData['order_t_title']		= serialize($order_t_title);
		$bookingData['order_t_qty']			= serialize($order_t_qty);
		$bookingData['order_t_price']		= serialize($order_t_price);
		$bookingData['order_t_fees']		= serialize($order_t_fees);
		$bookingData['order_t_commission']	= serialize($order_t_commission);

		//dd($bookingData);

		$data = $this->ticket_booking->insertData($bookingData);
		//$this->session::push('order_id', $bookingOrder_id);
        \Session::push('order_id', $bookingOrder_id);
		return redirect()->route('ticket.register', $client_token);
	}

	public function register($token) {
				
		//Alert::alert('Title', 'Message', 'Type');

		$bookingdata = $this->ticket_booking->getData($token);
		if(is_null($bookingdata)){
 		 	\App::abort(404, 'Somthing is wrong! Please try again.');
 		}
 
		$moTicket=$this->event_ticket->event_tickets($bookingdata->event_id);
		
		//$this->session::push('order_id', $bookingdata->order_id );
        \Session::push('order_id', $bookingdata->order_id );
		
		if($bookingdata->order_status == 5){
			return redirect()->route('order.cancel',$bookingdata->order_id);
		}

		if($bookingdata->order_status == 4)
		    return redirect()->route('events.details',$bookingdata->event_slug);
		
		if($bookingdata->order_status != 0 && $bookingdata->order_status != 4){
			return redirect()->route('order.single', $bookingdata->order_id);
		}

        //--------------- A APPROFONDIR --------------------------

		$organization = $this->organization->findDataId($bookingdata->event_org_name);

        //--------------- A APPROFONDIR --------------------------

		$GuestUserData = array();
		if($bookingdata->user_id == 0 && $bookingdata->gust_id != 0) {
			$GuestUserData = $this->guest_user->findData($bookingdata->gust_id);
		}
		$orderSessionTime = NULL;
		//if ($this->session::has('order_id')){
        if (\Session::has('order_id')){ 
		//$orderUid = array_column($this->session::get('order_id'), 'order_uid');
            $orderUid = array_column(\Session::get('order_id'), 'order_uid');
			//if(in_array($bookingdata->order_id, $this->session::get('order_id'))) {
            if(in_array($bookingdata->order_id, \Session::get('order_id'))) { 
				$orderSessionTime = (strtotime(gmdate('Y-m-d H:i:s')) + env('BOOKING_TIME', '600')) * 1000;
			}
		}
 		
		if(auth()->guard('frontuser')->check()){
			return view('theme.booking.ticket-booking',compact('bookingdata','organization','orderSessionTime','moTicket'));
		}else{
			return view('theme.booking.guest-ticket-booking',compact('bookingdata','organization','orderSessionTime','GuestUserData','moTicket'));
		}
	}

	public function payment(Request $request){
 
 		$input = $request->all();
		$bookingdatasAll="";
		//si l'utilisateur n'est pas déjà connecté on crée le user guest 
		//ou on le connecte s'il exste déjà
			if(!empty($input['newsletter'])){
				$ns=1;
			}else{
				$ns=0;
			}
					
		if(!auth()->guard('frontuser')->check()) {
			$this->validate($request,[
				'guestuserName' => 'required',
				'guestUserEmail' => 'required|email',
				'guestUserPhone' => 'required',
			]);
			$guestuserName 	= $input['guestuserName'];
			$guestUserEmail = $input['guestUserEmail'];
			$guestUserPhone = $input['guestUserPhone'];
			
			
			if(empty($guestuserName)){
				return redirect()->back()->with('error','Veuillez saisir votre Nom & Prénom(s)');
			}
			if(empty($guestUserPhone)){
				return redirect()->back()->with('error','Veuillez saisir votre N° de téléphone');
			}
			if(empty($guestUserEmail)){
				return redirect()->back()->with('error','Veuillez saisir votre adresse email');
			}

			$getGuestUser = $this->guest_user->searchByEmail($guestUserEmail);
			
			if(is_null($getGuestUser)){
				$userdata = ['guest_id' => str_shuffle(time()), 'user_name' => $guestuserName, 'guest_email' => $guestUserEmail, 'cellphone' => $guestUserPhone, 'newsletter'=>$ns];
				$guestUserData = $this->guest_user->insertData($userdata);
			}else{
				$upDate['user_name'] = $guestuserName;
				$upDate['cellphone'] = $guestUserPhone;
				$upDate['newsletter'] = $ns;
				$update_data = $this->guest_user->updateData($upDate, $getGuestUser->guest_id);
				$guestUserData = $getGuestUser;
			}
			
			$guestUserData = $this->guest_user->searchByEmail($guestUserEmail);
			
			$userdatas = ['id' => $guestUserData->guest_id, 'UserName' => $guestUserData->user_name, 'GuestEmail' => $guestUserData->guest_email];
 
			if(!\Session::has('guestUser')){
				\Session::put('guestUser', $userdatas);
			}
		}else{
			$user_id = auth()->guard('frontuser')->user()->id;
			$inputs=['newsletter' => $ns];
			$this->frontuser->UpdatedataPro($user_id, $inputs);
		}
		//fin Création ou connexion user Guest
		
		
		if(auth()->guard('frontuser')->check()):
			$user_id = auth()->guard('frontuser')->user()->id;
			$this->ticket_booking->updateData(['user_id' => $user_id], $input['order_id']);
		else:
			$gust_id = $guestUserData->guest_id;
			$this->ticket_booking->updateData(['gust_id' => $gust_id], $input['order_id']);		
		endif;
		
		
		if (isset($input['createinvoice']))
			$this->ticket_booking->updateData(['createinvoice' => (int)$input['createinvoice']], $input['order_id']);
		
		if(auth()->guard('frontuser')->check()){
			$bookingdata = $this->ticket_booking->getOrderData($input['order_id']);
		}else{
			$bookingdata = $this->ticket_booking->getOrderDataGuest($input['order_id']);
		}

		if($bookingdata->order_status == 2)
			return redirect()->route('order.cancel',$bookingdata->order_id);

		$organization = $this->organization->findDataId($bookingdata->event_org_name);
		$oderTickets['ot_order_id']	= $input['order_id'];
		$oderTickets['ot_event_id']	= $input['event_id'];
		
		if(auth()->guard('frontuser')->check()){
		    //$uData=Frontuser::where('id',auth()->guard('frontuser')->user()->id)->update(['cellphone' => $input['cellphone']]);
            $oderTickets['ot_user_id']	= $input['user_id'];
			$ufname=auth()->guard('frontuser')->user()->firstname;
			$ulname=auth()->guard('frontuser')->user()->lastname;
			$umail=auth()->guard('frontuser')->user()->email;
			$uphone=$input['cellphone'];
		}else{
			 
            //if($bookingdata->order_amount > 0) GuestUser::where('guest_id',$guestUserData->guest_id)->update(['cellphone' => $input['cellphone']]);
			$oderTickets['ot_user_id'] = 0;
			$oderTickets['gust_id'] = $gust_id;
		}

		$ordData = $this->order_tickets->countTickets($input['order_id']);
		if(isset($ordData) && $ordData != 0 ){
			$this->order_tickets->deleteOrder($input['order_id']);
		}
		$moreinfos_=array();
		$ticket_id = $input['ticket_id'];
		foreach($ticket_id as $key => $ticket) {
			$oderTickets['ot_ticket_id'] = $ticket;

				if(auth()->guard('frontuser')->check()){
					if(isset($input['fname_on_ticket'][$key])):
						$oderTickets['ot_f_name'] = $input['fname_on_ticket'][$key];
					else:
						$oderTickets['ot_f_name'] = $ufname;
					endif;

					if(isset($input['fname_on_ticket'][$key])):
						$oderTickets['ot_l_name'] = $input['lname_on_ticket'][$key];
					else:
						$oderTickets['ot_l_name'] = $ulname;
					endif;

                    if(isset($input['ot_cellphone'][$key])):
                        $oderTickets['ot_cellphone'] = $input['ot_cellphone'][$key];
                    else:
                        $oderTickets['ot_cellphone'] = $uphone;
                    endif;
					
					if(isset($input['email_on_ticket'][$key])):
						$oderTickets['ot_email'] = $input['email_on_ticket'][$key];					
					else:
						$oderTickets['ot_email'] = $umail;
					endif;
										
					   if($bookingdata->event_id == 3513696401){
								if(isset($input['choix_atelier'][$key])):
									$choix_atelier = $input['choix_atelier'][$key];
								else:
									$choix_atelier = 'Non renseigné';
								endif;
							
								$moreinfos_=array("choix_atelier"=>$choix_atelier);
								$moreinfos=json_encode($moreinfos_);
								
								$oderTickets['moreinfos'] = $moreinfos;
						}
					
					    if ($bookingdata->event_id == 1848865761){
								if(isset($input['taille'][$key])):
									$taille = $input['taille'][$key];
								else:
									$taille = 'Non renseigné';
								endif;
							
								$moreinfos_=array("taille"=>$taille);
								$moreinfos=json_encode($moreinfos_);
								
								$oderTickets['moreinfos'] = $moreinfos;
						}
					
						if ($bookingdata->event_id == 2616775009){
								if(isset($input['gender_on_ticket'][$key])):
									$gender_on_ticket = $input['gender_on_ticket'][$key];
								else:
									$gender_on_ticket = 'Non renseigné';
								endif;

								if(isset($input['birthd_on_ticket'][$key])):
									$birthd_on_ticket = $input['birthd_on_ticket'][$key];
								else:
									$birthd_on_ticket = 'Non renseigné';
								endif;

								if(isset($input['nationality_on_ticket'][$key])):
									$nationality_on_ticket = $input['nationality_on_ticket'][$key];
								else:
									$nationality_on_ticket = 'Non renseigné';
								endif;

								if(isset($input['club_on_ticket'][$key])):
									$club_on_ticket = $input['club_on_ticket'][$key];
								else:
									$club_on_ticket = 'Non renseigné';
								endif;
							
								$moreinfos=array("birthd_on_ticket"=>$birthd_on_ticket, 
											 'gender_on_ticket'=>$gender_on_ticket, 
											 'nationality_on_ticket'=>$nationality_on_ticket, 
											 'club_on_ticket'=>$club_on_ticket);
								$moreinfos=json_encode($moreinfos);
								$oderTickets['moreinfos'] = $moreinfos;
						}
					
				}
				else{
					
					if(isset($input['fname_on_ticket'][$key])):
						$oderTickets['ot_f_name'] = $input['fname_on_ticket'][$key];
					else:
						$oderTickets['ot_f_name'] = $input['guestuserName'];
					endif;

                    if(isset($input['ot_cellphone'][$key])):
                        $oderTickets['ot_cellphone'] = $input['ot_cellphone'][$key];
                    else:
                        $oderTickets['ot_cellphone'] = $input['guestUserPhone'];
                    endif;
					
					if(isset($input['gender_on_ticket'][$key])):
                        $oderTickets['gender_on_ticket'] = $input['gender_on_ticket'][$key];
                    else:
                        $oderTickets['gender_on_ticket'] = 'Non renseigné';
                    endif;
					
					$oderTickets['ot_email'] = $input['guestUserEmail'];			
						
						if ($bookingdata->event_id == 1848865761){
								if(isset($input['taille'][$key])):
									$taille = $input['taille'][$key];
								else:
									$taille = 'Non renseigné';
								endif;
							
								$moreinfos_=array("taille"=>$taille);
								$moreinfos=json_encode($moreinfos_);
								
								$oderTickets['moreinfos'] = $moreinfos;
						}
					
						if ($bookingdata->event_id == 2616775009){
								if(isset($input['gender_on_ticket'][$key])):
									$gender_on_ticket = $input['gender_on_ticket'][$key];
								else:
									$gender_on_ticket = 'Non renseigné';
								endif;

								if(isset($input['birthd_on_ticket'][$key])):
									$birthd_on_ticket = $input['birthd_on_ticket'][$key];
								else:
									$birthd_on_ticket = 'Non renseigné';
								endif;

								if(isset($input['nationality_on_ticket'][$key])):
									$nationality_on_ticket = $input['nationality_on_ticket'][$key];
								else:
									$nationality_on_ticket = 'Non renseigné';
								endif;

								if(isset($input['club_on_ticket'][$key])):
									$club_on_ticket = $input['club_on_ticket'][$key];
								else:
									$club_on_ticket = 'Non renseigné';
								endif;
							
								$moreinfos=array("birthd_on_ticket"=>$birthd_on_ticket, 
											 'gender_on_ticket'=>$gender_on_ticket, 
											 'nationality_on_ticket'=>$nationality_on_ticket, 
											 'club_on_ticket'=>$club_on_ticket);
								$moreinfos=json_encode($moreinfos);
								
								$oderTickets['moreinfos'] = $moreinfos;
						}
				}
			
				$moTicket=$this->event_ticket->ticket_by_id($ticket);

				if(!empty($moTicket->moreinfos_field)){  
						
						$moreFields=$moTicket->moreinfos_field;  
						$Mainchamp=explode("|",$moreFields); // on split chaque champ
						
						for($z=0;$z<count($Mainchamp);$z++){
							
							$champ=explode("@",$Mainchamp[$z]); // on split le type et le titre
							$nbc=count($champ);
							$vales=array();
 							
							for($xx=0;$xx<$nbc;$xx++){
								$champx=explode("=",$champ[$xx]);
								if($champx[0]=='values'){
									$vales[]=$champx[1];  
								}
							 } 
							
							for($xx=0;$xx<$nbc;$xx++){
								$champ2=explode("=",$champ[$xx]);

								if($champ2[0]=='type'){
									if($champ2[1]=='text'){
										//$champ2
										$ctitle=explode("=",$champ[1]);
										$txtSlug1=str_slug($ctitle[1], '_');
 						  
										if(isset($input[$txtSlug1][0])){  
											for($bx=0;$bx<count($input[$txtSlug1]);$bx++){
												if($key==$bx){
													$moreinfos_[$ctitle[1]]=$input[$txtSlug1][$bx]; 
												}
											}
										}
							 
									}

									if($champ2[1]=='list'){
										//$champ2
										$ctitle2=explode("=",$champ[1]);
										$txtSlug=str_slug($ctitle2[1], '_');										
 										
										if(isset($input[$txtSlug][0])){  
											for($cx=0;$cx<count($input[$txtSlug]);$cx++){  
												if($key==$cx)
												$moreinfos_[$ctitle2[1]]=$input[$txtSlug][$cx]; 
											}
										}										
							 
									}


								}
							}
 						

						$moreinfos=json_encode($moreinfos_);  
						$oderTickets['moreinfos'] = $moreinfos;						
						
						}
 
				}
					 
			
			/* EMAIL FOR SEND MAIL */
			if(auth()->guard('frontuser')->check()){
				//$oderTickets['ot_email'] = $input['email_on_ticket'][$key];
				if(isset($input['email_on_ticket'][$key])):
					$oderTickets['ot_email'] = $input['email_on_ticket'][$key];					
				else:
					$oderTickets['ot_email'] = $umail;
				endif;
			}else{
				$oderTickets['ot_email'] = guestUserData($gust_id)->email;
			}
			
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
			/* ------------------------ */

		} 
		
		//$paypalId = UserPaypalEmail($bookingdata->event_create_by);
		$orderSessionTime = NULL;
		//		if ($this->session::has('order_id')){
        if (\Session::has('order_id')){
		//			$orderUid = array_column($this->session::get('order_id'), 'order_uid');
		//			if(in_array($bookingdata->order_id, $this->session::get('order_id'))) {
            $orderUid = array_column(\Session::get('order_id'), 'order_uid');
            if(in_array($bookingdata->order_id, \Session::get('order_id'))) {
				$orderSessionTime = (strtotime(gmdate('Y-m-d H:i:s')) + env('BOOKING_TIME', '600')) * 1000;
			}
		}
		 
		if(auth()->guard('frontuser')->check()){
			$bookingdatas = $this->ticket_booking->getOrderData($input['order_id']);
			$bookingdatasAll = $this->ticket_booking->getOrderDataAll($input['order_id']);												
		} 
		 
        if(intval($bookingdata->order_amount) <= 0) {	
			//si c un ticket gratuit
            return redirect()->route('ticket.oderdone', $input['order_id']);			
        }
		elseif(isset($input['delivery-pay'])){  
			//si c un ticket à payer à la livraison
            $this->validate($request,[
                'cellphone'		=> 'required',
            ]);
            if(auth()->guard('frontuser')->check()){
                Frontuser::where('id',auth()->guard('frontuser')->user()->id)->update(['cellphone' => $input['cellphone']]);
            }else{
                GuestUser::where('guest_id',$guestUserData->guest_id)->update(['cellphone' => $input['cellphone']]);
            }
            return redirect()->route('ticket.oderdone-delivery', $input['order_id']);
            /*$session_orderId = \Session::get('order_id');
            $key = array_search($bookingdata->order_id, $session_orderId);
            // dd($session_orderId,$bookingdata->order_id,$key);
            \Session::forget('order_id.' . $key);

            $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com','williamscedricdabo@gmail.com');
            try {
                Mail::send('theme.pdf.cash-on-delivery',['orderData'=>$bookingdata],function($message) use ($mail)
                {
                    $message->from(frommail(), forcompany());
                    $message->to($mail);
                    $message->subject('Evénement créé');
                });
            } catch (\Exception $e) {
                dd($e);
                //return redirect()->route('index');
            }
            return view('theme.booking.cash-on-delivery',compact('bookingdata','orderSessionTime','organization'));*/	 			
			
		}else{
		
			
			if(isset($input['type-pay'])){
				$typepay=$input['type-pay'];
			}
 			$paypalId="";
			
			return view('theme.booking.ticket-payment',compact('bookingdata','organization','typepay','paypalId','orderSessionTime','bookingdatasAll'));
		}
	}
	
	public function testtick($id){
		$orders_id = $id;
		$orderData_	= $this->ticket_booking->getOrderDataAll($orders_id); 
 		$files = array();
 		
		foreach($orderData_ as $orderData){  
			$path = 'upload/ticket-pdf/';
			if (!is_dir(public_path($path))) {
				File::makeDirectory(public_path($path),0777,true);
			}
			$ot_ticket_id = unserialize($orderData->order_t_id)[0]; 
			$orderid=$orderData->orderid;
			$pdf_save_path = $path . $orders_id . '-' . $orderData->event_id .'-'.$orderid.'.pdf';
 		 	 
			$bookingdatax = $this->order_tickets->orderTicketsOT($orderid);
			
			if($orderData->event_id==52410727){
					$pdf_save_path = $path . $orders_id . '-' . $orderData->event_id .'-'.$orderid.'.pdf';
 
					foreach($bookingdatax as $bookingdata){ 
							if(!empty($bookingdata)){
								$bookingdatay[]=$bookingdata;  
								//echo"<pre>"; print_r($bookingdatay); echo"</pre>";
								view()->share('bookingdata',$bookingdatay);
								$pdf = PDF::loadView('theme.pdf.badge');
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
								$pdf->setPaper('a4','portrait')
									->setWarnings(false)
									//->save('public/'.$pdf_save_path)
									->stream();
								return $pdf->stream();
								// return $pdf->stream();
								$pdf_path = public_path().$pdf_save_path;
								/*$pdf_path= $pdf->stream();*/
								$files[]=$pdf_path;
								unset($bookingdatay);
							}
					}
					
		 	 
			}
			
		} 
		
		
	}

	// take order id for litige case
	public function takeOrderId($ot_email)
	{
		$order_id = $this->order_tickets->takeOrderId($ot_email);
		return $this->orderDone($order_id);
	}

	public function orderDone($orders_id){
		ini_set('memory_limit', '512M');
		set_time_limit(320);

		//$session_orderId = $this->session::get('order_id');
        $session_orderId = \Session::get('order_id');
        if($session_orderId != null){
            $order_key = array_search($orders_id, $session_orderId);
            \Session::forget('order_id.' . $order_key);
        }
		$input['client_token']	= str_shuffle(csrf_token());
        $lastestOrderData	= $this->ticket_booking->getOrderData($orders_id);  
        // ---- Début livraison traitée ---- //

		if($lastestOrderData->order_status == 4){ //getOrderData
            $orderData_	= $this->ticket_booking->getOrderDataAll($orders_id);
 
			foreach($orderData_ as $orderData){
				$path = 'upload/ticket-pdf/';
				if (!is_dir(public_path($path))) {
					File::makeDirectory(public_path($path),0777,true);
				}
				$ot_ticket_id = unserialize($orderData->order_t_id);
				$pdf_save_path = $path . $orders_id . '-' . $orderData->event_id .'.pdf';
				$bookingdata	= $this->order_tickets->orderTicketsOT($ot_ticket_id);

				$compteur = 1;
				
				if($orderData->event_id==52410727){
					$pdf_save_path = $path . 'badge-'.$orders_id . '-' . $orderData->event_id .'.pdf';

					foreach($bookingdata as $key=>$value){
						$compteur++;

						view()->share('bookingdata',$value);
						$pdf = PDF::loadView('theme.pdf.badge');
						$pdf->setOptions(
							[
								'dpi' 			=> 150,
								'defaultFont' 	=> 'roboto',
								'isPhpEnabled' 	=> true,
								'isRemoteEnabled' => true,
								'isHtml5ParserEnabled' => true,
								'setIsRemoteEnabled'=>true,
							]
						);
						$pdf->setPaper('a4','portrait')->setWarnings(false);
						$pdf->save('public/'.$pdf_save_path);
						//return $pdf->stream();
					}
					
				}else{
					foreach($bookingdata as $key=>$value){
						$compteur++;

						view()->share('bookingdata',$value);
						$pdf = PDF::loadView('theme.pdf.pdfview');
						$pdf->setOptions(
							[
								'dpi' 			=> 150,
								'defaultFont' 	=> 'roboto',
								'isPhpEnabled' 	=> true,
								'isRemoteEnabled' => true,
								'isHtml5ParserEnabled' => true,
								'setIsRemoteEnabled'=>true,
							]
						);
						$pdf->setPaper('a4','portrait')->setWarnings(false);
						$pdf->save('public/'.$pdf_save_path);
						//return $pdf->stream();
					}
				}
				
				$pdf_path = public_path().$pdf_save_path;
				$mail = (isset($orderData->user_email))?array($orderData->user_email):array(guestUserData($orderData->gust_id)->email);
				
				//Log::info('Send Mail to: {mail}', ['mail' => $mail]);
				
				$mailMessage = '';
				try {
					Mail::send('theme.pdf.mail',['orderData'=>$orderData],function($message) use ($mail,$pdf_path) {
						$message->from(frommail(), forcompany());
						$message->to($mail);
						$message->subject(trans('words.msg.e_tic_ord'));
						$message->attach($pdf_path);
					});
				} catch (\Exception $e) {
					$mailMessage = ", Mail Sending Fail please Download your Tickets here";
					//dd($e);
				}
				
			}	
				$input['order_status']	= '1';
				$updateOrderTicket = orderTickets::where('ot_order_id',$orders_id)->update(['delivred_status' => 1]);
			
			
            $this->ticket_booking->updateData($input,$orders_id);
            $message = 'Le billet a été envoyé au client';
            return redirect()->route('delivery.list')->with('success', $message);
        }
		// ---- Fin livraison traitée ---- print_r($bookingdata);die("--"); //

		$input['order_status']	= '1';
		$this->ticket_booking->updateData($input,$orders_id);
		$orderData_	= $this->ticket_booking->getOrderDataAll($orders_id);
 		$files = array();
		
		
		foreach($orderData_ as $orderData){  
			$path = 'upload/ticket-pdf/';
			if (!is_dir(public_path($path))) {
				File::makeDirectory(public_path($path),0777,true);
			}
			$ot_ticket_id = unserialize($orderData->order_t_id)[0]; 
			$orderid=$orderData->orderid;
			$pdf_save_path = $path . $orders_id . '-' . $orderData->event_id .'-'.$orderid.'.pdf';
 		 	 
			$bookingdatax = $this->order_tickets->orderTicketsOT($orderid);
			
			if($orderData->event_id==52410727){
					$pdf_save_path = $path . $orders_id . '-' . $orderData->event_id .'-'.$orderid.'.pdf';

					foreach($bookingdatax as $bookingdata){ 
							if(!empty($bookingdata)){
								$bookingdatay[]=$bookingdata;  
								//echo"<pre>"; print_r($bookingdatay); echo"</pre>";
								view()->share('bookingdata',$bookingdatay);
								$pdf = PDF::loadView('theme.pdf.badge');
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
								$pdf->setPaper('a4','portrait')
									->setWarnings(false)
									->save('public/'.$pdf_save_path)
									->stream();
								// return $pdf->stream();
								$pdf_path = public_path().$pdf_save_path;
								/*$pdf_path= $pdf->stream();*/
								$files[]=$pdf_path;
								unset($bookingdatay);
							}
					}
					
		 	}else{
			
              foreach($bookingdatax as $bookingdata){ 
					if(!empty($bookingdata)){
						$bookingdatay[]=$bookingdata;  
						//echo"<pre>"; print_r($bookingdatay); echo"</pre>";
						view()->share('bookingdata',$bookingdatay);
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
						$pdf->setPaper('a4','portrait')
							->setWarnings(false)
							->save('public/'.$pdf_save_path)
							->stream();
						// return $pdf->stream();
						$pdf_path = public_path().$pdf_save_path;
						/*$pdf_path= $pdf->stream();*/
						$files[]=$pdf_path;
						unset($bookingdatay);
					}
			}
				
			}
			
		} 
		
		
		if (auth()->guard('frontuser')->check() || $orderData->user_id != 0)
            $mail = array($orderData->user_email);
        elseif($orderData->user_id == 0)
			$mail = array(guestUserData($orderData->gust_id)->email);
			$mailMessage = '';
    	try {
    		Mail::send('theme.pdf.mail',['orderData'=>$orderData],function($message) use ($mail,$files) {
            	$message->from(frommail(), forcompany());
            	$message->to($mail);
            	$message->subject(trans('words.msg.e_tic_ord'));
				foreach($files as $ff){
            		$message->attach($ff);
				}
        	});
    	} catch (\Exception $e) {
    		$mailMessage = ", Échec de l'envoi du courrier, veuillez télécharger vos billets ici";
    	}
        $updateOrderTicket = orderTickets::where('ot_order_id',$orders_id)->update(['delivred_status' => 1]);
        $message = "Merci d'avoir passé votre commande avec ".$mailMessage;
		
		$this->send_message_to_admin_for_new_booking2($orderData);
		
        if(session('litige') == url('ub7qfzTBzX8JXdr8V4kV7sq/litige')){
            \Session::forget('litige');
            return redirect()->route('litige')->with('success','Ticket delivré au client');
        }
        //dd($updateOrderTicket,$message,$orders_id);
		return redirect()->route('order.success', $orders_id)->with('success','');
	}

    public function orderDoneForDeleveryPayment($orders_id){

        //$session_orderId = $this->session::get('order_id');
        $session_orderId = \Session::get('order_id');
        $order_key = array_search($orders_id, $session_orderId);
        \Session::forget('order_id.' . $order_key);

        //$input['client_token']	= str_shuffle(csrf_token());
        $input['order_status']	= '4';
        $this->ticket_booking->updateData($input,$orders_id);

        $orderData	= $this->ticket_booking->getOrderData($orders_id);

        /*$path = 'upload/ticket-pdf/';
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }
        $pdf_save_path = $path . $orders_id . '-' . $orderData->event_id .'.pdf';
        $bookingdata	= $this->order_tickets->orderTickets($orders_id);

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
        // return $pdf->stream();

        $pdf_path = public_path().$pdf_save_path;*/
        
        $updateTicket = EventTicketsCoupon::where('code',$orderData->discount_code)->update([
            'used_by' => $orderData->user_id,
            'used_on' => gmdate('Y-m-d H:i:s'),
            'status' => 'used'
        ]);
 

       if (auth()->guard('frontuser')->check()) {
            $mail = array($orderData->user_email);
        }else{
            $mail = array(guestUserData($orderData->gust_id)->email);
        }
        $mailMessage = '';
        try {
            Mail::send('theme.pdf.cash-on-delivery',['orderData'=>$orderData],function($message) use ($mail) {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Commande de Billets');
            });
        } catch (\Exception $e) {
            $mailMessage = ", Mail Sending Fail please Download your Tickets here";
        }

        // Message to Admin
        //$orderData = (object)$input;
        $this->send_message_to_admin_for_new_booking($orderData);
        $message = 'Thank you for placing your order with'.$mailMessage;
        return redirect()->route('order.success-delivery', $orders_id)->with('success',$message);
    }

    public function send_message_to_admin_for_new_booking($mailtoadmin){
        /*dd($mailtoadmin);*/
        $orderData = $mailtoadmin;
        //dd($orderData);
		$event_create_by = Frontuser::where('id', $orderData->event_create_by)->first();
        $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com','christelle.abeu@myplace-events.com', $event_create_by->email);
        try {
            Mail::send('Admin.mail.new-booking-delivery',['orderData'=>$orderData],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Nouvelle commande de ticket');
            });
        } catch (\Exception $e) {
            dd($e);
            //return redirect()->route('index');
        }
    }
	
    public function send_message_to_admin_for_new_booking2($mailtoadmin){
        /*dd($mailtoadmin);*/
         $orderData = $mailtoadmin;
         //dd($orderData);
		 $event_create_by = Frontuser::where('id', $orderData->event_create_by)->first();
         $mail = array(/*'charlene.valmorin@gmail.com','contact@myplace-events.com','christelle.abeu@myplace-events.com',*/ $event_create_by->email);
         try {
             Mail::send('theme.pdf.message_free_ticket',['orderData'=>$orderData],function($message) use ($mail)
             {
                 $message->from(frommail(), forcompany());
                 $message->to($mail);
                 $message->subject('Nouvelle commande de ticket');
             });
         } catch (\Exception $e) {
             dd($e);
             return redirect()->route('index');
         }
    }
	

    public function ticketSuccess($order_id){ 
		$bookingdata	= $this->ticket_booking->getOrderData($order_id);

		$frontuser = Frontuser::where("id", Auth::guard('frontuser')->id())->first();

		if ($frontuser && optional($frontuser->getWallet('bonus'))->id) {
			$lastDepositBonus = $frontuser->transactions
								->where('wallet_id', $frontuser->getWallet('bonus')->id)
								->where('type', 'deposit')
								->reverse()
								->first()->amount;
		}
		else $lastDepositBonus = 0;
		$orderData_	= $this->ticket_booking->getOrderDataAll($order_id);
		
		
		
		
		return view('theme.booking.success',compact('bookingdata','lastDepositBonus','orderData_'));
	}

    public function ticketSuccessForDeliveryPayment($order_id){
        $bookingdata	= $this->ticket_booking->getOrderData($order_id);
        return view('theme.booking.cash-on-delivery',compact('bookingdata'));
    }

	public function cancelBooking($order_id) {
		$this->ticket_booking->deleteBooking($order_id);
	}

	public function ticketCancel($order_id)	{
//        $session_orderId = $this->session::get('order_id');
        $session_orderId = \Session::get('order_id');
        if(isset($session_orderId) && $session_orderId != ''){
            $key = array_search($order_id, $session_orderId);
            if(isset($key) && $key != ''){
                \Session::forget('order_id.' . $key);
            }
        }
		
		if (\Session::has('discount')){
			\Session::forget('discount');
			\Session::forget('discount_type');
		}

		$bookingdata = $this->ticket_booking->getOrderData($order_id);
		$order_ticket_id	= unserialize($bookingdata->order_t_id);
		$order_ticket_qty	= unserialize($bookingdata->order_t_qty);

		foreach ($order_ticket_id as $key => $value) {
			$ticket_update = $this->event_ticket->incres_ticket_qty($value,$order_ticket_qty[$key]);
		}
		$input['client_token']	= str_shuffle(csrf_token());
		if($bookingdata->order_status == 4){
		    //dd($order_id);
            $input['order_status']	= '2';
            $this->ticket_booking->updateData($input,$order_id);
            $this->order_tickets->deleteOrder($order_id);
            $this->ticket_booking->deleteBooking($order_id);

            $message = 'Billet supprimé';
            return redirect()->route('delivery.list')->with('success',$message);
        }
		$input['order_status']	= '2';
		$this->ticket_booking->updateData($input,$order_id);
		$this->order_tickets->deleteOrder($order_id);
        $this->ticket_booking->deleteBooking($order_id);
        if(session('cinetpay_notification') == 1){
            \Session::forget('cinetpay_notification');
            return 1;
        }
		return view('theme.booking.cancel', compact('bookingdata'));
	}

	public function ticketExpire($order_id)	{
		$view = (new TicketController)->ticketCancel($order_id);
		$view->setPath(str_replace('cancel.', 'expire.', $view->getPath()));
		return $view;
	}

/*Wallet
	public function ticketCancelWithWallet($order_id)	{
		//        $session_orderId = $this->session::get('order_id');
				$session_orderId = \Session::get('order_id');
				if(isset($session_orderId) && $session_orderId != ''){
					$key = array_search($order_id, $session_orderId);
					if(isset($key) && $key != ''){
						\Session::forget('order_id.' . $key);
					}
				}

				$bookingdata = $this->ticket_booking->getOrderData($order_id);
				$order_ticket_id	= unserialize($bookingdata->order_t_id);
				$order_ticket_qty	= unserialize($bookingdata->order_t_qty);

				foreach ($order_ticket_id as $key => $value) {
					$ticket_update = $this->event_ticket->incres_ticket_qty($value,$order_ticket_qty[$key]);
				}
				$input['client_token']	= str_shuffle(csrf_token());
				if($bookingdata->order_status == 4){
					//dd($order_id);
					$input['order_status']	= '2';
					$this->ticket_booking->updateData($input,$order_id);
					$this->order_tickets->deleteOrder($order_id);
					$this->ticket_booking->deleteBooking($order_id);

					$message = 'Billet supprimé';
					return redirect()->route('delivery.list')->with('success',$message);
				}
				$input['order_status']	= '2';
				$this->ticket_booking->updateData($input,$order_id);
				$this->order_tickets->deleteOrder($order_id);
				$this->ticket_booking->deleteBooking($order_id);
				return view('theme.booking.cancelwithwallet', compact('bookingdata'));
	}
*/

	public function BookAttendes(Request $request)
	{
		$input = $request->all();

		$bookingData['event_id'] = $input['event_id'];
		$bookingData['manual_attend_vendor'] = \Auth::guard('frontuser')->user()->id;
		$bookingData['user_id'] = \Auth::guard('frontuser')->user()->id;

		$client_token		= str_shuffle(csrf_token());
		$bookingOrder_id	= generate_booking_code($input['event_id']);

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

					if(isset($input['ticket_type_dns'][$key])){
//						$ticketPriceActual = number_format(floatval($input['ticket_type_dns'][$key]),2, '.', '');
                        $ticketPriceActual = inttval($input['ticket_type_dns'][$key]);
					}else{
						$ticketPriceActual = ($ticket->ticket_price_actual);
					}

					/* DONATE TICKET QTY. */
					if($ticket->ticket_type == 2){
						$quanty = intval(1);
					}

				if($ticket->ticket_qty >= $quanty){
					$order_t_id[]			= $ticket_id;
					$order_t_title[]		= $ticket->ticket_title;
					$order_t_price[]		= $ticketPriceActual;
					$order_t_fees[]			= 0;
					$order_t_commission[]	= 0;
					$order_t_qty[]			= $quanty;
					$order_commission[]		= 0 * intval($quanty);
					$order_Tamount[]		= $ticketPriceActual * $quanty;
				}

				$ticketId = $ticket->ticket_id;
				$ticket_update = $this->event_ticket->decres_ticket_qty($ticketId, intval($quanty));
				$ticket_data['ticket_remaning_qty']	= intval($ticket->ticket_remaning_qty) - intval($quanty);
			}
		}

		$bookingData['order_tickets'] 		= array_sum($input['ticket_type_qty']);
		$bookingData['order_amount'] 		= array_sum($order_Tamount);
		$bookingData['order_commission'] 	= 0;
		$bookingData['order_id']			= $bookingOrder_id;
		$bookingData['client_token']		= $client_token;
		/*serialize data*/
		$bookingData['order_t_id']			= serialize($order_t_id);
		$bookingData['order_t_title']		= serialize($order_t_title);
		$bookingData['order_t_qty']			= serialize($order_t_qty);
		$bookingData['order_t_price']		= serialize($order_t_price);
		$bookingData['order_t_fees']		= serialize($order_t_fees);
		$bookingData['order_t_commission']	= serialize($order_t_commission);
		$data = $this->ticket_booking->insertData($bookingData);
//		$this->session::push('order_id', $bookingOrder_id );
        \Session::push('order_id', $bookingOrder_id );


		$payment['payment_user_id']  = $bookingData['user_id'];
//		$payment['payment_guest_id']  = $bookingData['gust_id'];

		if (!empty($bookingData['gust_id'])) {
			$payment['payment_guest_id'] = $bookingData['gust_id'];
		} else {
			$payment['payment_guest_id'] = null;
		}

		
		$payment['payment_order_id'] = $bookingOrder_id;
		$payment['payment_event_id'] = $input['event_id'];
		$payment['payment_amount'] 	 = $bookingData['order_amount'];
		$payment['payment_currency'] = 'INR';
		$payment['payment_status']   = 'Done';
		$payment['payment_gateway']  = $input['pp_payment_status'];

		$this->order_payment->insertData($payment);
		return redirect()->route('ticket.register', $client_token);
	}

	public function ManualRegister(Request $request)
	{
		$input = $request->all();
		$bookingdata	= $this->ticket_booking->getOrderData($input['order_id']);
		$organization	= $this->organization->findDataId($bookingdata->event_org_name);

		$oderTickets['ot_order_id']	= $input['order_id'];
		$oderTickets['ot_event_id']	= $input['event_id'];
		$oderTickets['ot_user_id']	= \Auth::guard('frontuser')->user()->id;

		$ticket_id = $input['ticket_id'];
		$tikorder = unserialize($bookingdata->order_t_qty);
		//dd($input, $bookingdata, $organization, $oderTickets, $ticket_id, $tikorder);
			foreach($tikorder as $key => $vale) {

				for ($i=0; $i < $vale ; $i++) {
					$oderTickets['ot_f_name'] 		= $input['fname_on_ticket'];
					$oderTickets['ot_l_name']		= $input['lname_on_ticket'];
                    //$orderTickets['ot_cellphone']   = $input['ot_cellphone'];
					$oderTickets['ot_email']		= $input['email_on_ticket'];
					$oderTickets['ot_ticket_id']    = $input['ticket_id'][$key];
					$path = 'upload/ticket-qr';
					if (!is_dir(public_path($path))) {
			            File::makeDirectory(public_path($path),0777,true);
			        }
					$booking_code	=  generate_ticket_code($input['ticket_id'][$key]);
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

			}

			$orders_id = $oderTickets['ot_order_id'];
			$input['client_token']	= str_shuffle(csrf_token());
			$input['order_status']	= '1';

			$this->ticket_booking->updateData($input,$orders_id);

			$orderData	= $this->ticket_booking->getOrderData($orders_id);

			$path = 'upload/ticket-pdf/';
			if (!is_dir(public_path($path))) {
	            File::makeDirectory(public_path($path),0777,true);
	        }
	        $pdf_save_path = $path . $orders_id . '-' . $orderData->event_id .'.pdf';

			$bookingdata	= $this->order_tickets->orderTickets($orders_id);

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
			$pdf_path = public_path().$pdf_save_path;

			$mail = array($orderData->user_email);

			$orderSessionTime = NULL;
			try {
		    	Mail::send('theme.pdf.mail',['orderData'=>$orderData],function($message) use ($mail,$pdf_path)
		        {
		            $message->from(frommail(), forcompany());
		            $message->to($mail);
		            $message->subject(trans('words.msg.e_tic_ord'));
		            $message->attach($pdf_path);
				});
			} catch (\Exception $e) {
				return redirect()->route('order.success',$orders_id);
			}
		return redirect()->route('order.success',$orders_id);
	}

	public function contactAttendeesMulti(Request $request)
	{
		$input = $request->all();

		$validator = Validator::make($input,[
			'subject' => 'required',
			'event_description' => 'required',
		]);

		if($validator->fails()){
			return response()->json(['status' => '0','error' => $validator->errors()->first()]);
		}

		$custom_name = array_unique($input['email']);
		$sub = $input['subject'];
		try {
			foreach($custom_name as $key => $name){
				$email = array($name);
				Mail::send('theme.pdf.contact',['data'=>$input,'email' => $name],function($message) use ($email,$sub){
		            $message->from(frommail(), forcompany());
		            $message->to($email);
		            $message->subject($sub);
				});
			}
		} catch (\Exception $e) {
			return response()->json(['status' => '1','success' => 'Mail Successfully send.']);
		}
		return response()->json(['status' => '1','success' => 'Mail Successfully send.']);
	}

	// public function psf()
	// {
	// 	$orderData	= $this->ticket_booking->getOrderData('91Q1M1J6H3');

	// 	return view('theme.pdf.mail',compact('orderData'));
	// }


    //---------- Inactif -------------//
    public function livraison($orders_id){

        //$session_orderId = $this->session::get('order_id');
        $session_orderId = \Session::get('order_id');
        $order_key = array_search($orders_id, $session_orderId);
        \Session::forget('order_id.' . $order_key);

        $input['client_token']	= str_shuffle(csrf_token());
        $input['order_status']	= '1';
        $this->ticket_booking->updateData($input,$orders_id);

        $orderData	= $this->ticket_booking->getOrderData($orders_id);

        $path = 'upload/ticket-pdf/';
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }
        $pdf_save_path = $path . $orders_id . '-' . $orderData->event_id .'.pdf';
        $bookingdata	= $this->order_tickets->orderTickets($orders_id);

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
        // return $pdf->stream();

        $pdf_path = public_path().$pdf_save_path;
        if (auth()->guard('frontuser')->check()) {
            $mail = array($orderData->user_email);
        }else{
            $mail = array(guestUserData($orderData->gust_id)->email);
        }
        $mailMessage = '';
        try {
            Mail::send('theme.pdf.mail',['orderData'=>$orderData],function($message) use ($mail,$pdf_path) {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject(trans('words.msg.e_tic_ord'));
                $message->attach($pdf_path);
            });
        } catch (\Exception $e) {
            $mailMessage = ", Mail Sending Fail please Download your Tickets here";
        }
        $message = 'Thank you for placing your order with'.$mailMessage;
        return redirect()->route('order.success', $orders_id)->with('success',$message);
    }

}

/*
$userdata = ['id' => str_shuffle(time()), 'UserName' => "Guest User", 'GuestEmail' => $email];
if(! auth()->guard('frontuser')->check()) {
	if(\Session::has('guestUser')){
		if(guestUserData()->email == ''){
			\Session::put('guestUser.GuestEmail', $email);
		}
	}else{
		\Session::put('guestUser', $userdata);
	}
}
*/
<?php

namespace App\Http\Controllers\Product;

use App\Action\CartAction;
use App\Action\CheckoutAction;
use App\Action\RegistrationAction;
use App\Events\ProductOrdered;
use App\Helpers\CartHelper;
use App\Helpers\FlashMsg;
use App\Helpers\PaymentHelper;
use App\Http\Controllers\Controller;
use App\Product\Product;
use App\ProductPayment;
use App\Product\ProductSellInfo;
use App\Shipping\ShippingMethod;
use App\Shipping\ShippingMethodOption;
use App\Shipping\UserShippingAddress;
use App\PaysList;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Unicodeveloper\Paystack\Facades\Paystack;
use Xgenious\Paymentgateway\Facades\XgPaymentGateway;

use App\Http\Controllers\CinetPayNew;
use Illuminate\Support\Facades\Redirect; 
 

class ProductSellPaymentController extends Controller
{
	
    const SUCCESS_ROUTE = 'frontend.products.payment.success';
    const CANCEL_ROUTE = 'frontend.products.payment.cancel';
 	
	public function __construct() {
    	parent::__construct();
		$this->products_payment = new ProductPayment;
    	$this->pays = new PaysList;
	}
	
    public function checkout(Request $request)
    {	
 		
		
		
        $this->validate($request, [
            // user info
            'firstname' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'nullable|string|max:191',
            'city' => 'required|string|max:191',
            'phone' => 'required|string',
            'shipping_address_id' => 'nullable|string|max:191',
            'selected_shipping_option' => 'nullable|string|max:191',
            'cheque_payment_input' => 'required_if:selected_payment_gateway,==,cheque_payment|nullable|file|mimes:jpg,jpeg,png,gif|max:11000',
            // payment info
            'selected_payment_gateway' => 'nullable|string|max:191',
            'bank_payment_input' => 'required_if:selected_payment_gateway,==,bank_payment|file|mimes:jpg,jpeg,png,gif|max:11000',
            'agree' => 'required',            
        ], ['agree.required' => __('Vous devez accepter nos conditions générales pour finaliser la commande')]);

        // if no items in cart
        if (CartHelper::isEmpty()) {
            return back()->withInput()->with('error', 'Une erreur s\'est produite');
        }

        // if account create
        if ($request->create_account) {
			
			 $this->validate($request, [
				// if register
				'password' => 'required|min:8|confirmed',
				'create_account' => 'required|string|max:191',
			]);
			
            $registration_action = new RegistrationAction();
            $user = $registration_action->register($request);
            $user_id = optional($user)->id;
        }

        // shipping address
        $address = $request->address;
        if ($request->shipping_address_id) {
            $user_shipping_address = UserShippingAddress::find($request->shipping_address_id);
            $address = $user_shipping_address && strlen($user_shipping_address->address) 
                        ? $user_shipping_address->address 
                        : $request->address;
        }

        $user_id = auth()->guard('frontuser')->user()->id;

        // calculate product and coupon prices
        $default_shipping_cost = CartAction::getDefaultShippingCost();

        $all_cart_items = CartHelper::getItems();

        $products = Product::whereIn('id', array_keys($all_cart_items))->get();

        $subtotal = CartAction::getCartTotalAmount($all_cart_items, $products);

        $coupon_amount = CartAction::calculateCoupon($request, $subtotal, $products, 'DISCOUNT');

        $selected_shipping_cost = $default_shipping_cost;

        $shipment_tax_applicable = false;
		
		// if user selected a shipping option
			if (isset($request->selected_shipping_option)) {
				$shipping_is_valid = CartAction::validateSelectedShipping($request->selected_shipping_option, $request->coupon);

				if (!$shipping_is_valid) {
					$shipping_method = ShippingMethod::with('availableOptions')->find($request->selected_shipping_option); // $request->selected_shipping_option;

					if (is_null($shipping_method)) {
						return back()->with(FlashMsg::explain('danger', __('Veuillez sélectionner une option d\'expédition valide')))->withInput();
					}

					if (isset(optional($shipping_method)->availableOptions)) {
						$minimum_order_amount = optional(optional($shipping_method)->availableOptions)->minimum_order_amount ?? 0;
						$minimum_order_amount = float_amount_with_currency_symbol($minimum_order_amount);

						$message = __('Le montant total minimum de la commande doit être') . ' ' . $minimum_order_amount;

						if (optional(optional($shipping_method)->availableOptions)->setting_preset === 'min_order_or_coupon') {
							$message .= ' ' . __('ou un coupon valide doit être donné.');
						} elseif (optional(optional($shipping_method)->availableOptions)->setting_preset === 'min_order_and_coupon') {
							$message .= ' ' . __('et un coupon valide doit être donné.');
						}
						return back()->with(FlashMsg::explain('danger', $message))->withInput();
					}

					return back()->with(FlashMsg::explain('danger', __('Veuillez sélectionner une option d\'expédition valide')))->withInput();
				}

				$shipping_info = CartAction::getSelectedShippingCost($request->selected_shipping_option, $subtotal, $request->coupon);
				$selected_shipping_cost = $shipping_info['cost'];

			}

			$checkout_image_path = "";         

			$total = $subtotal + $selected_shipping_cost - $coupon_amount;

			$payment_meta = [
				'total' => (string) round($total, 2),
				'subtotal' => (string) round($subtotal, 2),
				'shipping_cost' => (string) round($selected_shipping_cost, 2),
				'tax_amount' => 0,
				'coupon_amount' => (string) round($coupon_amount, 2),
			];		
		
		
		if(!isset($_SESSION['order_id'])){
	

			$id_transaction=Str::random(10).Str::random(10);
			$orderid=time().mt_rand().$user_id;

			$product_sell_info = [
				// user
				'lastname' => $request->lastname,
				'firstname' => $request->firstname,
				'email' => $request->email,
				'user_id' => $user_id,
				// billing address
				'country' => $request->country,
				'address' => $address,
				'city' => $request->city,
				'phone' => $request->phone,
				// shipping address
				'shipping_address_id' => $request->shipping_address_id ?? '',
				'selected_shipping_option' => $selected_shipping_cost,
				// product
				'total_amount' => $payment_meta['total'],
				'order_id' => $orderid,
				'order_details' => json_encode($all_cart_items),
				'payment_meta' => json_encode($payment_meta),
				// payment
				'payment_gateway' => $request->paymode,
				'payment_track' => $id_transaction,
				'transaction_id' => $id_transaction,
				'payment_status' => 'pending',
				'status' => 'pending',
				'checkout_image_path' => $checkout_image_path,
			];


			$product_sell_info = ProductSellInfo::create($product_sell_info);

			CartAction::storeItemSoldCount($all_cart_items, $products);
			$_SESSION['order_id']=$orderid;

		}else{			 
			$orderid=$_SESSION['order_id'];
			$product_sell_info = ProductSellInfo::where("order_id",$orderid)->first(); 
			if(!empty($product_sell_info)){
				$id_transaction=$product_sell_info->transaction_id;
			}else{
				unset($_SESSION['order_id']);
				return Redirect::back()->withErrors(['error' => 'Erreur votre commande a expirée']);
			}
		}	
		

		$paymode=$request->paymode;
		$designation="Articles: ";
		
		foreach($products as $pdt){
			$designation.=$pdt->title." / ";
		}
 
		$qte=0;
		foreach($all_cart_items as $key => $item){
			$qte=$qte+($item[0]['quantity']);
		}
		//echo"<br>";
		//print_r($products);
		//die("--");
		$montant_a_payer = $product_sell_info->total_amount/*mt_rand(100, 200)*/; // Montant à Payer : minimun est de 100 francs sur CinetPay
		
		
		if($paymode=="cinetpay"){
		
			$apiKey = "12225072435af2f658189760.36336854"; // Remplacez ce champs par votre APIKEY
			$site_id = "332112"; // Remplacez ce champs par votre SiteID
			$version = "V2";
			$date_transaction = gmdate("Y-m-d H:i:s"); // Date Paiement dans votre système
			// $channels = ["ALL", "MOBILE_MONEY", "CREDIT_CARD", "WALLET"];
			$channels = ["ALL"];
			$notify_url = route('shop.cinetpay.notification'); 
			$return_url = route('shop.cinetpay.return');

			$cancel_url = route('shop.cinetpay.delete', $id_transaction); // Lien d'annulation CinetPay


			if($request->country=="7"){
                $currency="XAF";
            }else{
                $currency="XOF";
            }			
 			
 			$description_du_paiement = $designation/*sprintf('Mon produit de ref %s', $id_transaction)*/; // Description du Payment
			$identifiant_du_payeur = $request->fisrtname.' '.$request->lastname;  
			
			$form = [
				"apikey"=> $apiKey,
				"site_id"=> $site_id,
				"transaction_id"=> $id_transaction,
				"amount"=> $montant_a_payer,
				"currency"=> $currency,
				"customer_surname"=> $request->firstname,
				"customer_name"=> $product_sell_info->firstname .' '. $product_sell_info->lastname,
				"description"=> $description_du_paiement,
				"notify_url" => $notify_url,
				"return_url" => $return_url,
				"channels" => $channels,
				//pour afficher le paiement par carte de credit
				"metadata" => "Ceci est le SDK PHP",
				"chk_metadata" => "Ceci est le SDK PHP",
				"alternative_currency" => "EUR",
				"customer_email" => $request->email ? $request->email : "test@cinetpay.com",
				"customer_phone_number" =>  $request->phone ? $request->phone : "0505050505",
				"customer_address" => $address ? $address : "BP 258",
				"customer_city" =>  $request->city ? $request->city : "ABIDJAN",
				"customer_country" => "CI",
				"customer_state" =>  "AZ",
				"customer_zip_code" =>  "00225"
			];
	 		
			
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
                   
					/*//Gain de points  Bonus lors d'un payement
                    $myWalletBonus = $frontuser->getWallet('bonus');
                    $deposit = ($this->arrondi_entier_sup($montant_a_payer))*0.001;

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

                        
					}*/
				
				
            } catch (\Exception $e) {
               print $e->getMessage();
            }
			
			 
			
		}
		else if($paymode=="visa"){
			 
  				$montant_visa = $payment_meta['total'];
				$service_designation = "event_ticket";
				$meta_data = ['designation' => "shop", 'order_id' => $orderid ];

				$datas=[
					"montant_visa"=>$montant_visa,
					"email"=>$request->email,
					"orderID" => $orderid,
					"amount" => $montant_visa,
					"quantity" => $qte,
					"currency" => "XOF",
					"metadata" => json_encode($meta_data),
				];
			
				$typepay=$paymode;
					
				return view('theme.gadgets.shop-payment',compact('datas','typepay'));
			
		}
		else if($paymode=="startbutton"){
			
			
			$number = str_replace(' ', '', $number);
			$msg=urlencode($msg);

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'api.startbutton.tech/transaction/initialize',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Bearer sb_bf85baf385f6444541826aec246a5a46986098d099b9607cc418e7337515eb93'
			  ),
			));

			$response = curl_exec($curl);
			Log::debug('CURL : '.$response); 

			curl_close($curl);
			
			
		}
		else{
			
			echo"<center>Une erreur est survenue!</center><br>";
			
		}
		
	 		
        
        /*try{
            return PaymentHelper::chargeCustomer($product_sell_info, $request);
        }catch(\Exception $e){
            return back()->with(['msg' => $e->getMessage(),'type' => 'danger']);
        }*/
		
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
 
                // On verifie que le paiement est valide
                $order_payment = [];
				
				$bookingdata = ProductSellInfo::where("transaction_id",$id_transaction)->first();

				$order_payment['payment_user_id'] = $bookingdata->user_id;
				$product=Products::where('id', $bookingdata->product_id)->first();

				if($product->country=="7"){
					$currency="XAF";
				}else{
					$currency="XOF";
				}

				$order_payment['payment_order_id'] = $bookingdata->order_id;
				$order_payment['payment_product_id'] = $bookingdata->product_id;
				$order_payment['payment_currency'] = $currency;
				$order_payment['payment_gateway'] = 'CINETPAY';
				$order_payment['payment_method'] = $paymentData["payment_method"];
				$order_payment['payment_number'] = $paymentData["cel_phone_num"];
				$order_payment['payment_amount'] = $paymentData["cpm_amount"];

				$designation = 1;
       
                /*$order_payment['payment_user_id']		= $bookingdata->user_id;
                $order_payment['payment_guest_id']      =*/
                // paiement valide
                if (!empty($paymentData["cpm_result"]) && $paymentData["cpm_result"] == '00') {
 
					$order_payment['payment_state'] = 1;
					$order_payment['payment_status'] = 'SUCCESS';

					$succes_paiement = 1;
					
					ProductSellInfo::where('transaction_id',$id_transaction)->update(['payment_status' => 'SUCCESS']);
					
 					//$user = Frontuser::where('id',$bookingdata->user_id)->first();
					//$message = ['user'=>$user, 'event'=>$event, 'bookingdata'=>$bookingdata, /*'orgEmail' => $orgUserData->email*/];
					//dd($message);
					//$this->send_message_to_admin_for_product_paid($message, $product);

                }else{
					$order_payment['payment_state'] = 0;
					$order_payment['payment_status'] = 'ERROR';
					$order_payment['failure_message'] = $paymentData['cpm_error_message'];
					
					$succes_paiement = 0;
				}

                // traitement operation dans la bdd
                     
				if ($this->products_payment->no_repeat_payment($bookingdata->transaction_id)):
					if ($succes_paiement):

						$this->orderDone($paymentData['cpm_trans_id']);
						
						$user = Frontuser::where('id',$bookingdata->user_id)->first();
						if($user == null) $user = GuestUser::where('guest_id',$bookingdata->gust_id)->first();

						$message = ['user'=>$user, 'product'=>$product, 'bookingdata'=>$bookingdata, /*'orgEmail' => $orgUserData->email*/];
						$this->send_message_to_admin_for_product_paid($message, $bookingdata);


					endif;

					$data = $this->products_payment->insertData($order_payment);				

					if($succes_paiement != 1):
 
						//dd($id_transaction);
						return $this->cinetpay_annulation($id_transaction);

					endif;
				
				
				
				endif;
 
               
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
	
	
	
    public function send_message_to_admin_for_product_paid($message, $bookingdata){
		
        $sendto = $bookingdata->email;

        $orderData = $message;
        //dd($orderData);
       // $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com','christelle.abeu@myplace-events.com',$sendto);
		$mail = array($sendto);
        try {
            Mail::send('Admin.mail.message_shop_paid',['orderData'=>$orderData],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Article(s) acheté(s) dans la boutique de My Place Events');
            });
        } catch (\Exception $e) {
            dd($e);
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
                                return redirect()->route('order.success', $id_transaction);
                            elseif ($paymentData->payment_state == 0):
                                $montant_reel = arrondi_entier_sup($bookingdata->order_id * cinetpay_commission());
                                if ($montant_reel != $cpm_amount):
                                    OrderPayment::where('payment_order_id')->update(['payment_state' => 2, 'payment_status' => 'MONTANT INCORRECT']);
                                endif;
                                
                            elseif ($paymentData->payment_state == 2):
                                return redirect()->route('events.details', $id_transaction)->with('Erreur : Le montant payé est différent de ce lui du produit. Veuillez contacter l\'administrateur pour plus les détails');
                            endif;
                        endif;
 
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
	
 	

    public function cinetpay_annulation($id_transaction){

		$bookingdata = ProductSellInfo::where("transaction_id",$id_transaction)->first();

		
        if($bookingdata == null){
			
            return redirect()->route('pre.index')->with('erreur', 'Aucune commande trouvée dans la base de données.');
			
        }elseif($bookingdata != null){
			
			ProductSellInfo::where('transaction_id',$id_transaction)->update(['payment_status' => 'CANCEL', 'status' => 'CANCEL']);
  			CartHelper::clear();
			
            return view('theme.gadgets.shop.cancel', compact('bookingdata'));
        }

    }

 	
	public function orderDone($id_transaction){
		ini_set('memory_limit', '512M');
		set_time_limit(320);
 
        $lastestOrderData = ProductSellInfo::where("transaction_id",$id_transaction)->first();
		$orderid=$lastestOrderData->order_id;
		
		$name=$lastestOrderData->firstname.' '.$lastestOrderData->lastname;
		
		$pid=array();
		$json=json_decode($lastestOrderData->order_details, true); 
  		
		if($lastestOrderData->payment_status=='SUCCESS'){
			
		 	$invoice='
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<div class="invoice-title">
								<h2>Fcature</h2><h3 class="pull-right">Commande #'.$orderid.'</h3>
							</div>
							<hr>
							<div class="row">
								<div class="col-xs-6">
									<address>
									<strong>Facturé à:</strong><br>
										'.$name.'<br>
										'.$lastestOrderData->address.'br>
										'.$lastestOrderData->country.' / '.$lastestOrderData->city.'
									</address>
								</div>
								<div class="col-xs-6 text-right">
									<address>
									<strong>Expédiés à:</strong><br>
										'.$name.'<br>
										'.$lastestOrderData->address.'br>
										'.$lastestOrderData->country.' / '.$lastestOrderData->city.'
									</address>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<address>
										<strong>Mode de paiement:</strong><br>
										'.$lastestOrderData->payment_gateway.'<br>
										'.$lastestOrderData->email.'
									</address>
								</div>
								<div class="col-xs-6 text-right">
									<address>
										<strong>Date de commande:</strong><br>
										'.$lastestOrderData->created_at.'<br><br>
									</address>
								</div>
							</div>
						</div>
					</div>';
			
			$invoice.='
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><strong>Résumé de la commande</strong></h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-condensed">
									<thead>
										<tr>
											<td><strong>Article</strong></td>
											<td class="text-center"><strong>Prix</strong></td>
											<td class="text-center"><strong>Quantité</strong></td>
											<td class="text-right"><strong>Total</strong></td>
										</tr>
									</thead>
									<tbody>';
 				$pname="";
				foreach($json as $key => $item){  
					$pdata = Product::where("id",$key)->first();
					$pname.= $pdata->title.' - ';
												
					$campaign_product = getCampaignProductById($key);
					$sale_price = $campaign_product ? $campaign_product->campaign_price : $pdata->sale_price;	
												
					$itotal=$sale_price*$item[0]['quantity'];				
					
					$invoice.='<tr>
    								<td>'.$pdata->title.'</td>
    								<td class="text-center">'.float_amount_with_currency_symbol($sale_price).'</td>
    								<td class="text-center">'.$item[0]['quantity'].'</td>
    								<td class="text-right">'.float_amount_with_currency_symbol($itotal).'</td>
    							</tr>';
					
				} 
			
			
			$invoice.='					</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> ';
			
			$path = 'upload/invoice-pdf/';
			if (!is_dir(public_path($path))) {
				File::makeDirectory(public_path($path),0777,true);
			}
			
			$pdf_save_path = $path . $id_transaction . '-' . gmdate("d-m-Y-His").'.pdf';
			
			view()->share('bookingdata',$invoice);
			$pdf = PDF::loadView('theme.pdf.shopinvoice');
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

			$pdf_path = public_path().$pdf_save_path;
			$mail = (isset($orderData->user_email))?array($orderData->user_email):array(guestUserData($orderData->gust_id)->email);			
				
			$mailMessage = '';
			$user = Frontuser::where('id',$bookingdata->user_id)->first();
            if($user == null) $user = GuestUser::where('guest_id',$bookingdata->gust_id)->first();
			
			$mailMessage = '';			
			
			
			try {
				Mail::send('theme.pdf.shopmail',['invoice'=>$invoice, 'pname'=>$pname],function($message) use ($mail,$pdf_path) {
					$message->from(frommail(), forcompany());
					$message->to($mail);
					$message->subject(trans('words.msg.e_tic_ord'));
					$message->attach($pdf_path);
				});
			} catch (\Exception $e) {
				$mailMessage = ", Échec de l'envoi du courrier de la boutique, veuillez télécharger votre facture ici";
			}				
			
			$updateOrderTicket = ProductSellInfo::where('transaction_id',$id_transaction)->update(['status' => 'DONE']);
 
            //$message = 'la facture a été envoyée au client';
            //return redirect()->route('delivery.list')->with('success', $message);
 
			
		}else{
			
		}
 		

	}
	
	
	
	

    public function checkoutContinuePending(Request $request)
    {
        $this->validate($request, [
            'bank_transfer_input' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:11000',
            'cheque_payment_input' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:11000',
        ]);

        $product_sell_info = ProductSellInfo::findOrFail($request->id);
        return PaymentHelper::chargeCustomer($product_sell_info, $request);
    }

    public function cancelPayment(Request $request)
    {
        $product_sell_info = ProductSellInfo::findOrFail($request->id);
        $product_sell_info->update([
            'status' => 'canceled',
            'payment_status' => 'canceled',
        ]);
        return true;
    }

    public function reorder(Request $request)
    {
        $product_sell_info = ProductSellInfo::findOrFail($request->id);
        $new_sell = $product_sell_info->replicate();
        $new_sell->created_at = Carbon::now();
        $new_sell->updated_at = Carbon::now();
        $new_sell->status = 'pending';
        $new_sell->payment_status = 'pending';
        $new_sell->payment_track = Str::random(10) . Str::random(10);
        $new_sell->transaction_id = Str::random(10) . Str::random(10);
        $new_sell->save();
        return redirect()->to(route('user.product.order.details', $new_sell->id));
    }

    private function returnAppropriateRedirect($payment_data)
    {
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete') {
            event(new ProductOrdered([
                'order_id' => $payment_data['order_id'],
                'transaction_id' => $payment_data['transaction_id']
            ]));
            return redirect()->route(self::SUCCESS_ROUTE, Str::random(6) . $payment_data['order_id'] . Str::random(6));
        }
        return redirect()->route(self::CANCEL_ROUTE, Str::random(6));
    }

 
	
}

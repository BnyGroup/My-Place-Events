<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*

use Jenssegers\Date\Date;
//use App\orderPayment;

Route::get('/test1', function() {
    $user = App\User::where('id', 4239)->get();

    //$user->deposit(50000);
    //$balance = $user->balance;
    $lastTransaction = DB::table('transactions')->where('payable_id', 4239)->orderBy('created_at', 'desc')->first()->amount;
    //$dateLastTransaction = DB::table('transactions')->where('payable_id', 4239)->orderBy('created_at', 'desc')->first()->created_at;
    $frontuser_id = Auth::guard('frontuser')->id();
    $dateLastTransaction = Transaction::where('payable_id', 4239)->latest()->first()['amount'];
    $tickets = DB::table('order_payment')->where('payment_user_id', 223)->orderBy('created_at', 'desc')->get();

    //$order_payment = new orderPayment;
    //$tickets = $order_payment->get_order_payment(223);

    $user = App\Models\Event::find(1)->user;

    return dd($tickets);
});
*/
 

use Gabievi\Promocodes\Facades\Promocode;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;
use Bavix\Wallet\Interfaces\Wallet;
use Illuminate\Support\Facades\DB;
use Bavix\Wallet\Models\Transaction;
use App\Frontuser;
use App\Gadget;
use App\Event;
use App\Classes\Commande; 
use App\Classes\CinetPay;
use App\Organization;
use App\Models\NewsletterSubscription;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Middleware\CheckNewsletterAbonnes;
/*
Route::get('/test', function() {
    //return dd(Promocodes::output($amount = 1));
    //return dd(auth()->guard('frontuser')->user()->id);
    $frontuser = Frontuser::where('id', 4239)->first();

    $array = DB::table('wallets')->where('holder_id', 4239)->get();
    $bonus = $array[1]->balance; 
    $walet = $frontuser->getWallet('bonus');

    //return dd(str_shuffle(csrf_token()));

    $event = Event::where('id', 471)->first();
    return dd($event);

    $this->event = new Event;
    $event = Event::where('id', 471)->first();
    $event_create_by = Frontuser::where('id', $event->event_create_by)->first();

    return dd($event_create_by);
    $this->org = new Organization;
    $org = $this->org->orgName($event->event_org_name);
    return dd($org);
   
    return dd($frontuser->transactions
                            ->where('wallet_id', $frontuser->getWallet('bonus')->id)
							->where('type', 'deposit')
                            ->reverse()
                            ->first());
});*/
//////////////////////////////


/**--------------------------------
                newsletter ROUTES
        ---------------------------------*/
       

   Route::post('/subscribe', 'NewsletterSubscriptionController@subscribe')->name('subscribe');
  

   



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
		
    	// Route::get('pdf','TicketController@psf');
        Route::get('/',['as'=>'index','uses'=>'FrontController@index']);

        Route::get('/test_email',['as'=>'test_email','uses'=>'HomeController@test_email']);

        //Boutique
        Route::get('shop',['as' => 'shop','uses' => 'ShopController@index']);

        //Gadget
        Route::get('/shop/item/{item}', ['as'=>'shop_item.details','uses'=>'ShopController@shopsingle']);
        Route::get('/shop/category/{item}', ['as'=>'shop_cat.details','uses'=>'ShopController@showategory']);
		
		Route::get('/shop/subcategory/{id}/{any?}', 'ShopController@products_subcategory')->name('shop_subcategory.details');
		
		/**--------------------------------
                CART ROUTES
        ---------------------------------*/
        Route::group(['prefix' => 'cart'], function () {
            Route::get('/all', 'ShopController@cartPage')->name('cart');
            Route::get('details', 'Product\ProductCartController@cartStatus')->name('cart.status.ajax');
            Route::get('summary-info', 'Product\ProductCartController@getCartInfoAjax')->name('cart.info.ajax');
            // Route::post('add', 'Product\ProductCartController@addToCart')->name('add.to.cart');
            Route::post('ajax/add-to-cart', 'Product\ProductCartController@addToCartAjax')->name('add.to.cart.ajax');
            Route::post('remove', 'Product\ProductCartController@removeCartItem')->name('cart.ajax.remove');
            Route::post('clear', 'Product\ProductCartController@clearCart')->name('cart.ajax.clear');
            Route::post('ajax/update', 'Product\ProductCartController@updateCart')->name('cart.update.ajax');
            Route::post('ajax/coupon', 'Product\ProductCartController@cartPageApplyCouponAjax')->name('cart.apply.coupon');
            // Route::post('ajax/shipping', 'Product\ProductCartController@ajax_shipping_apply')->name('shipping.apply');
        });		
		
		/**--------------------------------
				CHECKOUT ROUTES
		---------------------------------*/
		Route::get('checkout', 'ShopController@checkoutPage')->name('frontend.checkout');
		Route::post('checkout', 'Product\ProductSellPaymentController@checkout');
		Route::post('checkout-continue', 'Product\ProductSellPaymentController@checkoutContinuePending')->name('frontend.checkout.continue');
		Route::post('checkout-cancel-order', 'Product\ProductSellPaymentController@cancelPayment')->name('frontend.checkout.cancel');
		Route::post('checkout-reorder', 'Product\ProductSellPaymentController@reorder')->name('frontend.checkout.reorder');
		Route::get('checkout-apply-coupon', 'Product\ProductCartController@checkoutPageApplyCouponAjax')->name('frontend.checkout.apply.coupon');
		Route::get('checkout-calculate', 'Product\ProductCartController@calculateCheckout')->name('frontend.checkout.calculate');
		
		Route::get('/all', 'ShopController@cartPage')->name('frontend.products.cart');
		
		/**--------------------------------
				FRONT PAGE FILTER ROUTES
		---------------------------------*/
		Route::match(["get","post"],'filter-top-rated', 'ShopController@topRatedProducts')->name('frontend.products.filter.top.rated');
		Route::match(["get","post"],'filter-top-selling', 'ShopController@topSellingProducts')->name('frontend.products.filter.top.selling');
		Route::match(["get","post"],'filter-new', 'ShopController@newProducts')->name('frontend.products.filter.new');
		Route::post('filter-campaign', 'ShopController@campaignProduct')->name('frontend.products.filter.campaign');
		Route::post('filter-discount', 'ShopController@discountedProduct')->name('frontend.products.filter.discounted');

		Route::get('attribute-data', 'ShopController@getProductAttributeHtml')->name('frontend.products.attribute.html');
		
		Route::post('rate', 'ShopController@product_rating_store')->name('ratings.store');
        Route::get('/shop/orderdone/{id}',['as'=>'shop.oderdone','uses'=>'ProductSellPaymentController@orderDone']);
		
		
		
		
        
        Route::get('/events/{url?}', ['as'=>'events', 'uses'=>'EventController@index']);
        Route::post('/search-events-results', ['as'=>'events.search-results', 'uses'=>'EventController@SearchEvent']);
        Route::get('/events/categories/{url}', ['as'=>'events.categorie', 'uses'=>'EventController@index_by_cat']);
        Route::get('/events/pays/{url}', ['as'=>'events.pays', 'uses'=>'EventController@index_by_country']);
        
        Route::get('/eventsbycats', ['as'=>'eventsbycats', 'uses'=>'EventController@eventsbycats']);
        Route::get('/eventsbycatsfilter', ['as'=>'eventsbycatsfilter', 'uses'=>'EventController@eventsbycatsfilter']);


        Route::get('/search/data',['as'=>'serach.data','uses' =>'EventController@searchdata']);

        Route::get('/event/{slug}/{snippet?}', ['as'=>'events.details','uses'=>'EventController@singleevent']);
        Route::get('/location/search/{location}',['as' => 'event.location','uses' => 'EventController@evenLocation']);

        Route::post('org/contact',['as' => 'org.contact','uses' => 'OrganizationController@orgContact']);
        Route::post('prestataire/contact',['as' => 'pre.contact','uses' => 'PrestataireController@preContact']);
        //user signup
        Route::get('/signup', ['as'=>'user.signup', 'uses'=>'UserController@user_signup']);
        Route::post('/signup/post',['as'=>'signup.post','uses'=>'UserController@store']);
        Route::post('/signup/postAjax',['as'=>'signup.postAjax','uses'=>'UserController@storeAjax']);

        //pages
        Route::get('pages/{slug}',['as'=>'pages','uses'=>'FrontController@getPageData']);
        //Formulaire Service Route
        Route::post('/prestataire/demande-accompagnement',['as' => 'pre.demande','uses' => 'PrestataireController@demande']);
        Route::get('/prestatairesbycats', ['as'=>'prestatairesbycats', 'uses'=>'PrestataireController@prestatairesbycats']);
        Route::get('/prestatairesbytopcats', ['as'=>'prestatairesbytopcats', 'uses'=>'PrestataireController@prestatairesbytopcats']);
		

        /* Order Done and Cancel */
        Route::get('/order/cancel/{id}',['as'=>'order.cancel','uses'=>'TicketController@ticketCancel']);
        Route::get('/order/expire/{id}',['as'=>'order.expire','uses'=>'TicketController@ticketExpire']);
        //Wallet
        Route::get('/order/cancel/wallet/{id}',['as'=>'order.cancel_wallet','uses'=>'TicketController@ticketCancelWithWallet']);
        //Fin Wallet
        Route::get('/orderdone/{id}',['as'=>'ticket.oderdone','uses'=>'TicketController@orderDone']);
        Route::get('/orderdone/delivery/{id}',['as'=>'ticket.oderdone-delivery','uses'=>'TicketController@orderDoneForDeleveryPayment']);
        Route::get('/order/success/{id}',['as'=>'order.success','uses'=>'TicketController@ticketSuccess']);
        Route::get('/order/success/pour-livraison/{id}',['as'=>'order.success-delivery','uses'=>'TicketController@ticketSuccessForDeliveryPayment']);
        // Retrieve orderId by email and send ticket
        Route::get('/orderdone-by-email/{email}',['as'=>'ticket.oderdone.byEmail','uses'=>'TicketController@takeOrderId']);
        /* Order Done and Cancel */


        // Paystack route
        Route::post('/pay',['as'=>'paystack.sendform','uses'=>'PaystackController@redirectToGateway']);
        Route::get('/pay/callback',['as'=>'paystack.callback','uses'=>'PaystackController@handleGatewayCallback']);

        Route::get('/paystartbutton/callback',['as'=>'paystartbutton.callback','uses'=>'PaystackController@startbuttonCallback']);
        Route::get('/paystartbutton/webhook',['as'=>'paystartbutton.webhook','uses'=>'PaystackController@webhookstartbutton']);
		
        // Paystack Shop
        Route::post('/shopay',['as'=>'paystack.sendpay','uses'=>'PaystackController@redirectToGatewayforShop']);

        /*
        |-----------------------------------
        | Wordpress --- Integration
        |--------- -------------------------
        */

        /*Route::group(['name' => 'frontend'], function (){

            Route::get();

        });*/

        /*
        |-----------------------------------
        | Ajax --- Jquery
        |--------- -------------------------
        */

        //Route::post('ajax/prestataire/update/delete/file', ['as'=>'pre.delete.fupdate','uses'=>'AjaxController@deleteFilePreUpdate']);

        /*
        |-----------------------------------
        | Social Login
        |--------- -------------------------
        */

        Route::get('/policy',['as'=>'policy','uses'=>'FrontController@policy']);
        Route::get('/faqs',['as'=>'faqs','uses'=>'FrontController@faqs']);
        Route::get('/terms',['as'=>'terms','uses'=>'FrontController@terms']);
        Route::get('/support',['as'=>'support','uses'=>'FrontController@support']);
        Route::get('/about-us',['as'=>'aboutus','uses'=>'FrontController@aboutus']);
        Route::get('/server-requirement',['as'=>'server.requirement','uses'=>'FrontController@server_requirements']);


        Route::get('/contacts/index',['as'=>'contacts.index','uses'=>'FrontController@contact']);
        Route::get('/contacts',['as'=>'contact','uses'=>'FrontController@contact']);
        Route::post('/contacts/post',['as'=>'contact.post','uses'=>'FrontController@contact_post']);
        //Activation
        Route::get('activation/{token}',['as'=>'activation','uses'=>'UserController@activation']);

        Route::get('/snippet/event/{slug}',['as' => 'snippet.event','uses' => 'EventController@snippet']);

        //Frontuser
        Route::group(['middleware'=>'signin-check'],function(){
            //user login
            Route::get('/signin', ['as'=>'user.login', 'uses'=>'AdminAuth\AuthController@login_form']);
            Route::post('/signin/post',['as'=>'signin.post','uses'=>'AdminAuth\AuthController@login']);
        });

		Route::post('/signin/postAjax',['as'=>'signin.postAjax','uses'=>'AdminAuth\AuthController@postLogin']);

        Route::get('organization/{slug}',['as'=>'org.detail','uses'=>'OrganizationController@org_detail']);
        //Route::get('prestataires/{slug}',['as'=>'pre.show','uses'=>'PrestataireController@show']);
        Route::get('prestataires/{slug}',['as'=>'pre.detail','uses'=>'PrestataireController@show']);
        // Liste des prestataire
        Route::get('prestataire', ['as'=>'prestataire', 'uses'=>'PrestataireController@index2']);
        Route::post('prestataire', ['as'=>'prestataire', 'uses'=>'PrestataireController@searchhomepage']);
        //Route::get('prestataires/',['as'=>'pre.details','uses'=>'PrestataireController@pre_detail']);


        /* User Middleware  */
        //reset link
        Route::get('reset',['as'=>'reset.link','uses'=>'AdminAuth\PasswordResetController@form']);
        Route::post('reset/post',['as'=>'reset.post','uses'=>'AdminAuth\PasswordResetController@formpost']);
        Route::get('reset/form/{token}',['as'=>'reset.form','uses'=>'AdminAuth\PasswordResetController@reset_form']);
        Route::patch('reset/password',['as'=>'reset.password','uses'=>'AdminAuth\PasswordResetController@password_update']);

        Route::post('reset/postAjax',['as'=>'reset.postAjax','uses'=>'AdminAuth\PasswordResetController@formpostAjax']);

		
        // Social login
        Route::get('login/{provieder}',['as' => 'provieder','uses' => 'AdminAuth\SocialController@redirectToProvider']);
        Route::get('login/{provieder}/callback','AdminAuth\SocialController@handleProviderCallback');
        //Route::post('google/login',['as' => 'google.login','uses' => 'AdminAuth\SocialController@googleLogin']);

        //Services
        Route::get('services',['as' => 'services','uses' => 'ServiceController@index']);

        //Web TV
        Route::get('farafi-tv',['as' => 'farafi_tv','uses' => 'WebTvController@index']);
        Route::get('evenements_search/{code}',['as' => 'events.code','uses' => 'EventController@eventByCode']);
        Route::get('evenements/{pays}',['as' => 'events.country','uses' => 'EventController@eventByCountry']);

        //blog
        Route::get('blog', 'FrontController@blog');


        /* =============================================== */
        /* USER MIDDLEWARE */
        /* =============================================== */
        Route::group(['middleware'=>'guest'],function(){
            /* Guest Login */
            Route::post('s/g/login',['as'=>'guest.login','uses'=>'TicketController@guestLogin']);
            Route::get('oauth/{provider}', 'SocialAuthController@redirect')->where('provider', '(facebook|google|twitter)$');
            Route::get('oauth/{provider}/callback', 'SocialAuthController@callback')->where('provider', '(facebook|google|twitter)$');
            Route::auth();
            
            /* Guest Login */
            /* Ticket Bookin */
            Route::post('/t/booking',['as'=>'ticket.booking','uses'=>'TicketController@booking']);
            Route::get('/t/register/{token}',['as'=>'ticket.register','uses'=>'TicketController@register']);
            Route::post('payment',['as'=>'ticket.payment','uses'=>'TicketController@payment']);
            /* Ticket Bookin */
            /* paypal */
            Route::get('payPremium', ['as'=>'payPremium','uses'=>'PaypalController@payPremium']);
            Route::post('getCheckout', ['as'=>'getCheckout','uses'=>'PaypalController@getCheckout']);
            Route::get('getDone/{id}/{url?}', ['as'=>'getDone','uses'=>'PaypalController@getDone']);
            Route::get('getCancel', ['as'=>'getCancel','uses'=>'PaypalController@getCancel']);
            /*Route::post('paypal-transaction-complete',['as' => 'pp.return','uses' => 'PaypalController@returnDirectPay']);*/
            //Route::get('paypal/directpay/{object}',['as' => 'pp.return','uses' => 'PaypalController@returnDirectPay2']);
            Route::get('paypal-ticket-payment/create-order/{orderID}',['as' => 'pp.create','uses' => 'PaypalController@createOrder']);
            Route::get('paypal-ticket-payment/capture-order/{orderID}',['as' => 'pp.capture','uses' => 'PaypalController@captureOrder']);
            Route::get('paypal-ticket-payment/cancel-order',['as' => 'pp.cancel','uses' => 'PaypalController@cancelOrder']);
            Route::get('paypal-ticket-payment/cancel-return',['as' => 'pp.return','uses' => 'PaypalController@returnOrder']);
            Route::post('paypal-transaction-complete/{eventOrderId}/{orderID}',['as' => 'pp.getOrder','uses' => 'PaypalController@getOrder']);
            /* paypal */
            /* Stripe Payment */
            Route::post('p/stripPay', ['as'=>'stripe.payment','uses'=>'StripePaymentController@paymentDone']);
            /* Stripe Payment */

            /* Cinetpay Payment */

        /* Route::post('p/cinetPay', ['as'=>'cinetpay.payment','uses'=>'CinetPayController@generateForm']);
            Route::post('p/cinetPay/notify', ['as'=>'cinetpay.payment.notify','uses'=>'CinetPayController@notifyUrlTreat']);
            //Route::get('p/cinetPay/notify', ['as'=>'cinetpay.payment.notify','uses'=>'CinetPayController@notifyUrlTreat']);
            Route::post('p/cinetPay/return', ['as'=>'cinetpay.payment.return','uses'=>'CinetPayController@returnUrl']);
            Route::get('p/cinetPay/cancel/{id}', ['as'=>'cinetpay.payment.cancel','uses'=>'CinetPayController@cancelUrl']);*/

            //Route::post('paiement/cinetpay', ['as'=>'cinetpay.paiement','uses'=>'CinetPayController@generate_cinetpay_form']);
            //Route::post('notification/cinetpay', ['as'=>'cinetpay.notification','uses'=>'CinetPayController@cinetpay_notification']);
            //Route::post('retour/cinetpay', ['as'=>'cinetpay.return','uses'=>'CinetPayController@cinetpay_retour']);/*cinetpay_retour*/

            //Route::get('annulation/cinetpay/{id}', ['as'=>'cinetpay.delete','uses'=>'CinetPayController@cinetpay_annulation']);
            //Route::get('notification/cinetpay/{order_id}-{origine}', ['as'=>'orderdone.cinetpay','uses'=>'TicketController@orderDone']);

            /*
            Route::post('user/dashboard/add/funds','AddFundsController@cinetpayTryPayment');
            Route::get('user/dashboard/add/cancel', 'AddFundsController@cinetpayCancelUrl'); // Paiement annulé
            Route::post('user/dashboard/add/notify', 'AddFundsController@cinetpayNotifyPage'); // Reponse CinetPay
            Route::post('user/dashboard/add/return', 'AddFundsController@cinetpayRightPayment');// Reponse CinetPay */

            // Order in Session
            // Route::get('s/o/chack',['as'=>'session.order','uses'=>'OrderController@sessionOrder' ]);
            Route::get('s/o/remove{oid}',['as'=>'session.removeOrder','uses'=>'OrderController@revmoveOrder' ]);
            Route::get('s/o/cancle',['as'=>'remove.order','uses'=>'OrderController@removeCancleOrder' ]);

Route::get('coupons-cinfos',['as'=>'coupon.cinfos','uses' =>'EventController@CouponInfos']);

            Route::group(['middleware'=>'users'],function(){
                // user Route
                Route::get('/user/{slug?}', ['as'=>'users.pro', 'uses'=>'UserController@index']);
                Route::get('/user/tickets', ['as'=>'user.tickets', 'uses'=>'UserController@user_tickets']);
                Route::patch('/user/pro/update',['as'=>'user.pro.update','uses'=>'UserController@update_pro']);
                Route::post('uesr/profile/password',['as'=>'password.pro.update','uses'=>'UserController@password_update_pro']);
                Route::get('user/order',['as'=>'order.single','uses'=>'OrderController@orderList']);
                Route::get('user/order/{id}',['as'=>'order.single','uses'=>'OrderController@orderView']);
                //Route::get('user/order/paiement-a-la-livraison',['as'=>'order.postpayment','uses'=>'OrderController@livraison']);
                Route::get('user/events/{slug}',['as'=>'user.bookmarks','uses'=>'UserController@bookmark']);
				
				
Route::get('user/testtick/{id}',['as'=>'testtick','uses'=>'TicketController@testtick']);


                //Gadgets
                Route::get('/s/item/create',['as' => 'shop_item.create','uses' => 'ShopController@create']);
                Route::post('/s/item/save', ['as'=>'shop_item.store', 'uses'=>'ShopController@store']);
                Route::get('/s/item/manage', ['as'=>'shop.item.manage', 'uses'=>'ShopController@usergadgets']);
                Route::get('/s/item/edit/{id}',['as'=>'shop.item.edit','uses' => 'ShopController@gadget_edit']);
                Route::get('/s/item/dash/{id}', ['as'=>'shop.item.dshaboard', 'uses'=>'ShopController@gadgetDashboard']);
                Route::patch('/s/item/update/{id}',['as'=>'shop.item.update','uses'=>'ShopController@update']);

                //Boutique
                Route::post('/shop/cart/add', ['as'=>'shop_cart.store','uses'=>'CartController@store']);
                Route::get('/shop/my-cart', ['as'=>'shop_cart.index','uses'=>'CartController@index']);
                Route::patch('/shop/cart/{rowId}', ['as'=>'shop_cart.update','uses'=>'CartController@update']);
                Route::delete('/shop/cart/{rowId}', ['as'=>'shop_cart.destroy','uses'=>'CartController@destroy']);


                // Events Create
                Route::get('/e/create', ['as'=>'events.create', 'uses'=>'EventController@create']);
                Route::post('/e/save', ['as'=>'events.store', 'uses'=>'EventController@store']);
                Route::get('/e/manage', ['as'=>'events.manage', 'uses'=>'EventController@userevents']);
                Route::get('/e/dash/{id}', ['as'=>'events.dshaboard', 'uses'=>'EventController@eventDashboard']);
                Route::get('/e/edit/{id}',['as'=>'events.edit','uses' => 'EventController@event_edit']);
                Route::patch('/e/update/{id}',['as'=>'events.update','uses'=>'EventController@update']);
                Route::get('/e/delete/{id}',['as'=>'events.delete','uses'=>'EventController@delete']);
                Route::get('/e/bookmark',['as'=>'events.bookmark','uses'=>'EventController@bookmark']);
                Route::get('/e/attendee/{id}', ['as'=>'events.attendee', 'uses'=>'EventController@eventAttendee']);
                Route::get('/e/refund/{id}/{status?}',['as' => 'events.refund','uses' => 'EventController@refundsIndex']);
                Route::post('/e/event_link/', ['as'=>'events.generate', 'uses'=>'EventController@eventsGenerate' ]);

                // Route::post('/t/booking',['as'=>'ticket.booking','uses'=>'TicketController@booking']);
                // Route::get('/t/register/{token}',['as'=>'ticket.register','uses'=>'TicketController@register']);
                // Route::post('payment',['as'=>'ticket.payment','uses'=>'TicketController@payment']);

                // Order in Session
                Route::get('s/o/chack',['as'=>'session.order','uses'=>'OrderController@sessionOrder' ]);
                // Route::get('s/o/remove{oid}',['as'=>'session.removeOrder','uses'=>'OrderController@revmoveOrder' ]);
                // Route::get('s/o/cancle',['as'=>'remove.order','uses'=>'OrderController@removeCancleOrder' ]);

                //Route::get('/payment/{id}',['as'=>'ticket.payment','uses'=>'TicketController@payment']);
                // Route::get('/orderdone/{id}',['as'=>'ticket.oderdone','uses'=>'TicketController@orderDone']);
                // Route::get('/order/cancel/{id}',['as'=>'order.cancel','uses'=>'TicketController@ticketCancel']);
                // Route::get('/order/success/{id}',['as'=>'order.success','uses'=>'TicketController@ticketSuccess']);
                
                Route::get('coupons-checking',['as'=>'coupon.checking','uses' =>'EventController@CouponCheck']);
                


                //close Account
                Route::post('close',['as'=>'close.account','uses'=>'UserController@close']);

                //orgProfile
                Route::get('/org/index', ['as'=>'org.index', 'uses'=>'OrganizationController@index']);
                Route::get('/org/create', ['as'=>'org.create', 'uses'=>'OrganizationController@create']);
                Route::post('org/store',['as'=>'org.store','uses' => 'OrganizationController@store']);
                Route::get('org/edit/{slug}',['as'=>'org.edit','uses' => 'OrganizationController@edit']);
                Route::patch('org/update/{id}',['as'=>'org.update','uses' => 'OrganizationController@update']);
                Route::get('org/delete/{id}',['as'=>'org.delete','uses' =>'OrganizationController@delete']);
                Route::get('update/slug/org',['as' => 'update.org.slug','uses' => 'OrganizationController@updateSlug']);
                Route::post('/org/insert',['as'=>'org.insert','uses'=>'OrganizationController@org_insert']);
                Route::post('orgs/claim',['as' => 'claim.submit','uses' => 'OrganizationController@orgSubmit']);
                /* paypal */
        //    		 Route::get('payPremium', ['as'=>'payPremium','uses'=>'PaypalController@payPremium']);
        //    	     Route::post('getCheckout', ['as'=>'getCheckout','uses'=>'PaypalController@getCheckout']);
        //    	     Route::get('getDone/{id}', ['as'=>'getDone','uses'=>'PaypalController@getDone']);
        //    	     Route::get('getCancel/{id}', ['as'=>'getCancel','uses'=>'PaypalController@getCancel']);

                Route::post('paypal/directpay',['as' => 'pp.return','uses' => 'PaypalController@returnDirectPay']);

                /*  Prestataire  */

                Route::get('/prestataire/gestion', ['as'=>'pre.index', 'uses'=>'PrestataireController@index']);
                Route::get('/prestataire/create', ['as'=>'pre.create', 'uses'=>'PrestataireController@create']);
                Route::post('prestataire/store',['as'=>'pre.store','uses' => 'PrestataireController@store']);
                Route::get('prestataire/edit/{slug}',['as'=>'pre.edit','uses' => 'PrestataireController@edit']);
                Route::patch('prestataire/update/{slug}',['as'=>'pre.update','uses' => 'PrestataireController@update']);
                Route::get('prestataire/delete/{slug}',['as'=>'pre.delete','uses' =>'PrestataireController@delete']);
                Route::get('realisation/delete/{id}/{slug}',['as'=>'rea.delete','uses' =>'PrestataireController@reaDelete']);
                /*Route::get('prestataire/cinetpay/{id}/{amount}',['as'=>'pre.cinetpay','uses' =>'PrestataireController@generateForm']);*/
                Route::post('prestataire/cinetpay',['as'=>'pre.cinetpay','uses' =>'PrestataireController@generateForm']);

                //Route::get('prestataire/cinetpay/notify',['as'=>'pre.cinetpaynotify','uses' =>'PrestataireController@notifyUrl']);
                Route::post('prestataire/cinetpay/notify',['as'=>'pre.cinetpaynotify','uses' =>'PrestataireController@notifyUrl']);
                //Route::get('prestataire/cinetpay/return',['as'=>'pre.cinetpayreturn','uses' =>'PrestataireController@returnUrl']);
                Route::post('prestataire/cinetpay/return',['as'=>'pre.cinetpayreturn','uses' =>'PrestataireController@returnUrl']);
                Route::get('prestataire/cinetpay/cancel',['as'=>'pre.cinetpaycancel','uses' =>'PrestataireController@cancelUrl']);
                Route::post('prestataire/paypal-transaction-complete/{orderID}',['as' => 'pre.paypal','uses' => 'PaypalController@prestatairePayment']);
                Route::get('prestataire/paypal/cancel',['as'=>'pre.paypalcancel','uses' =>'PrestataireController@cancelUrl']);


                /*  Prestataire  */
                Route::get('/a_la_une/index', ['as'=>'alu.index', 'uses'=>'ALaUneController@index']);
                Route::get('/a_la_une/create', ['as'=>'alu.create', 'uses'=>'ALaUneController@getCreate']);
                Route::post('/a_la_une/create', ['as'=>'alu.create', 'uses'=>'ALaUneController@postCreate']);
                Route::post('a_la_une/store',['as'=>'alu.store','uses' => 'ALaUneController@store']);
                Route::get('a_la_une/edit/{slug}',['as'=>'alu.edit','uses' => 'ALaUneController@edit']);
                Route::patch('a_la_une/update/{id}',['as'=>'alu.update','uses' => 'ALaUneController@update']);
                Route::get('a_la_une/delete/{id}',['as'=>'alu.delete','uses' =>'ALaUneController@delete']);
                Route::post('a_la_une/pay',['as'=>'alu.pay','uses' =>'ALaUneController@generateForm']);
                Route::get('a_la_une/valider',['as'=>'alu.valider','uses' =>'ALaUneController@valider']);

                //Route::get('prestataire/cinetpay/notify',['as'=>'pre.cinetpaynotify','uses' =>'PrestataireController@notifyUrl']);
                Route::post('a_la_une/pay/notify',['as'=>'alu.cinetpaynotify','uses' =>'ALaUneController@notifyUrl']);

                //Route::get('prestataire/cinetpay/return',['as'=>'pre.cinetpayreturn','uses' =>'PrestataireController@returnUrl']);
                Route::post('a_la_une/pay/return',['as'=>'alu.cinetpayreturn','uses' =>'ALaUneController@returnUrl']);
                //Route::get('a_la_une/pay/return',['as'=>'alu.cinetpayreturn','uses' =>'ALaUneController@returnUrl']);

                Route::get('a_la_une/pay/cancel',['as'=>'alu.cinetpaycancel','uses' =>'ALaUneController@cancelUrl']);


                /* adaptive pay */
                Route::post('adaptivePay', ['as'=>'getAdaptiveCheckout','uses'=>'PaypalAdaptiveController@adaptiveChackout']);
                Route::get('getDones/{id}', ['as'=>'adaptive.getDone','uses'=>'PaypalAdaptiveController@getDone']);
                Route::get('getCancel/{id}', ['as'=>'adaptive.getCancel','uses'=>'PaypalAdaptiveController@getCancel']);
                /* paypal */

                /* Stripe Payment */
                // Route::post('p/stripPay', ['as'=>'stripe.payment','uses'=>'StripePaymentController@paymentDone']);
                /* Stripe Payment */

                //Bnak Detials
                Route::post('bank/details',['as' => 'ubank.details','uses'=>'UserController@bankDetials']);
                Route::post('bank/paypalEmail',['as' => 'upaypal.email','uses'=>'UserController@paypalEmail']);
                Route::post('attendee/book',['as' => 'attendee.book','uses' => 'TicketController@BookAttendes']);
                Route::post('manual/book',['as' => 'manual.book','uses' => 'TicketController@ManualRegister']);
                Route::post('attendees/contact_multi',['as' => 'contact.multi_attendes','uses' => 'TicketController@contactAttendeesMulti']);
                Route::post('/refund/request',['as' => 'refund.request','uses' => 'StripePaymentController@refundRequest']);

                // logout
                Route::get('/logout', ['as'=>'user.logout', 'uses'=>'AdminAuth\AuthController@logout']);
            });

        });


		Route::get('couponscheck',['as'=>'couponcheck','uses' =>'EventController@CouponCheck']);

        // Admin Side
        // Admin Route
        Route::group(['middleware'=>'login-check'],function(){
            Route::get('/ub7qfzTBzX8JXdr8V4kV7sq',['as'=>'login','uses'=>'Auth\LoginController@show_form']);
            Route::post('/ub7qfzTBzX8JXdr8V4kV7sq/post',['as'=>'login.post','uses'=>'Auth\LoginController@login_post']);
        });

        Route::get('/password/form',['as'=>'password.form','uses'=>'Auth\ForgotPasswordController@pwd_form']);
        Route::post('/password/form',['as'=>'password.reset','uses'=>'Auth\ForgotPasswordController@token_gen']);
        Route::get('/password/reset/{token}',['as'=>'password.token','uses'=>'Auth\ResetPasswordController@password_reset_form']);
        Route::patch('/password/update',['as'=>'password.update','uses'=>'Auth\ResetPasswordController@updatePassword']);

	

        Route::group(['middleware'=>'admin-check','prefix'=>'ub7qfzTBzX8JXdr8V4kV7sq'],function(){
            //Roles Route
            Route::get('/clear-cache', function() {
                Artisan::call('cache:clear');
                Artisan::call('view:clear');
                Artisan::call('route:clear');
                return "Cache is cleared";
            });
            Route::get('/update-guest-email/{id}/{newEmail}',['as'=>'guest-user.update-email','uses'=>'UserController@updateGuestEmail']);
            Route::get('/update-user-email/{oldEmail}/{newEmail}',['as'=>'user.update-email','uses'=>'UserController@updateUserEmail']);

            Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
            Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
            Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
            Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
            Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
            Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
            Route::get('roles/{id}',['as'=>'roles.remove','uses'=>'RoleController@remove','middleware' => ['permission:role-delete']]);

            Route::get('litige',['as'=>'litige','uses'=>'Admin\AdminController@litige']);
            Route::post('litige/send',['as'=>'litige.send','uses'=>'Admin\AdminController@litige_send']);
            Route::post('litige/by-email/send',['as'=>'litige.byEmail.send','uses'=>'Admin\AdminController@litige_send_by_email']);

            //Sliders routes
            Route::get('sliders',['as'=>'sliders.index','uses'=>'Admin\SliderController@index','middleware' => ['permission:slider-list|slider-create|slider-edit|slider-delete']]);
            Route::get('sliders/create',['as'=>'sliders.create','uses'=>'Admin\SliderController@create','middleware' => ['permission:slider-create']]);
            Route::post('sliders/create',['as'=>'sliders.store','uses'=>'Admin\SliderController@store','middleware' => ['permission:slider-create']]);
            Route::get('sliders/{id}',['as'=>'sliders.show','uses'=>'Admin\SliderController@show']);
            Route::get('sliders/{id}/edit',['as'=>'sliders.edit','uses'=>'Admin\SliderController@edit','middleware' => ['permission:slider-edit']]);
            Route::patch('sliders/{id}',['as'=>'sliders.update','uses'=>'Admin\SliderController@update','middleware' => ['permission:slider-edit']]);
            Route::get('sliders/{id}',['as'=>'sliders.remove','uses'=>'Admin\SliderController@remove','middleware' => ['permission:slider-delete']]);

         

            //Sliders routes
            Route::get('webtv',['as'=>'webtv.index','uses'=>'Admin\WebTvController@index','middleware' => ['permission:webtv-list|webtv-create|webtv-edit|webtv-delete']]);
            Route::get('webtv/create',['as'=>'webtv.create','uses'=>'Admin\WebTvController@create','middleware' => ['permission:webtv-create']]);
            Route::post('webtv/store',['as'=>'webtv.store','uses'=>'Admin\WebTvController@store','middleware' => ['permission:webtv-create']]);
            Route::get('webtv/{id}/edit',['as'=>'webtv.edit','uses'=>'Admin\WebTvController@edit','middleware' => ['permission:webtv-edit']]);
            Route::patch('webtv/{id}',['as'=>'webtv.update','uses'=>'Admin\WebTvController@update','middleware' => ['permission:webtv-edit']]);
            Route::get('webtv/{id}',['as'=>'webtv.delete','uses'=>'Admin\WebTvController@remove','middleware' => ['permission:webtv-delete']]);

            //Services routes
            Route::get('service',['as'=>'service.index','uses'=>'Admin\ServiceController@index','middleware' => ['permission:service-list|service-create|service-edit|service-delete']]);
            Route::get('service/create',['as'=>'service.create','uses'=>'Admin\ServiceController@create','middleware' => ['permission:service-create']]);
            Route::post('service/store',['as'=>'service.store','uses'=>'Admin\ServiceController@store','middleware' => ['permission:service-create']]);
            Route::get('service/{id}',['as'=>'service.show','uses'=>'Admin\ServiceController@show']);
            Route::get('service/{id}/edit',['as'=>'service.edit','uses'=>'Admin\ServiceController@edit','middleware' => ['permission:service-edit']]);
            Route::patch('service/{id}',['as'=>'service.update','uses'=>'Admin\ServiceController@update','middleware' => ['permission:service-edit']]);
            Route::get('service/{id}',['as'=>'service.remove','uses'=>'Admin\ServiceController@remove','middleware' => ['permission:service-delete']]);


            // Deshboard Route
            Route::get('dashboard',['as'=>'admin.index','uses'=>'Admin\AdminController@dashboard','middleware' => ['permission:dashboard-listing']]);
            Route::get('regularise/{element}',['as'=>'order.regularise','uses'=>'Admin\OrderController@regularise']);

            // User Route
            Route::get('users',['as'=>'users.index','uses'=>'Admin\UsersController@index','middleware' => ['permission:admin-user-cerate|admin-user-edit|admin-user-delete|admin-user-view|admin-user-listing']]);
            Route::get('users/create',['as'=>'users.create','uses'=>'Admin\UsersController@create','middleware' => ['permission:admin-user-cerate']]);
            Route::post('users/store',['as'=>'users.store','uses'=>'Admin\UsersController@store','middleware' => ['permission:admin-user-cerate']]);
            Route::get('users/edit/{id}',['as'=>'users.edit','uses'=>'Admin\UsersController@edit','middleware' => ['permission:admin-user-edit']]);
            Route::patch('users/update/{id}',['as'=>'users.update','uses'=>'Admin\UsersController@update','middleware' => ['permission:admin-user-edit']]);
            Route::get('users/delete/{id}',['as'=>'users.delete','uses'=>'Admin\UsersController@destroy','middleware' => ['permission:admin-user-delete']]);
            Route::get('users/show/{id}',['as'=>'users.show','uses'=>'Admin\UsersController@show','middleware' => ['permission:admin-user-view']]);

            Route::get('user',['as'=>'user.index', 'uses'=>'Admin\UserController@index']);
            Route::post('user/post',['as'=>'user.post', 'uses'=>'Admin\UserController@update_profile']);
            Route::post('user/password',['as'=>'user.password', 'uses'=>'Admin\UserController@update_password']);

            // Event and Event Category Route
            Route::get('events/list',['as'=>'event.list','uses'=>'Admin\EventController@index','middleware' =>['permission:event-view|event-ban-revoke|event-list']]);
            Route::get('events/view/{id}',['as'=>'events.view','uses'=>'Admin\EventController@shows','middleware' => ['permission:event-view']]);
            Route::get('events/ban/{id}',['as'=>'events.ban','uses'=>'Admin\EventController@ban','middleware' => ['permission:event-ban-revoke']]);
            Route::get('events/revoke/{id}',['as'=>'events.revoke','uses'=>'Admin\EventController@revoke','middleware' => ['permission:event-ban-revoke']]);
            Route::get('events/nofirst/{id}',['as'=>'events.nofirst','uses'=>'Admin\EventController@nofirst']);
            Route::get('events/first/{id}',['as'=>'events.first','uses'=>'Admin\EventController@first']);
            Route::get('events/accept/{id}',['as'=>'events.accept','uses'=>'Admin\EventController@accept']);
			
            Route::get('events/noimmanquable/{id}',['as'=>'events.noimmanquable','uses'=>'Admin\EventController@noimmanquable']);
            Route::post('events/save-immanquable/',['as'=>'events.save-immanquable','uses'=>'Admin\EventController@uploadBanImm']);			

            Route::get('events/immanquable/{id}',['as'=>'events.immanquable','uses'=>'Admin\EventController@immanquable']);						
			
            Route::get('events/export/{id}',['as'=>'events.export','uses'=>'Admin\EventController@export','middleware' =>['permission:event-view|event-ban-revoke|event-list']]);

            // Pour la Livraison
            Route::get('livraison-success/{id}',['as'=>'delivery.paid','uses'=>'Admin\EventController@deliverypaid']);
            Route::get('liste-livraison',['as'=>'delivery.list','uses'=>'Admin\EventController@deliverylist']);
			
			// Langue & Traduction
            Route::get('langue-details/{id}',['as'=>'langue.details','uses'=>'Admin\LanguesController@details']);
            Route::get('langues',['as'=>'langues.list','uses'=>'Admin\LanguesController@index']);
            Route::post('langue-store',['as'=>'langue.store','uses'=>'Admin\LanguesController@store']);

            // Mise à la une
            Route::get('a_la_une/list',['as'=>'alu.list','uses'=>'Admin\ALaUneController@index','middleware' =>['permission:a-la-une-view|a-la-une-ban-revoke|a-la-une-list']]);
            Route::get('a_la_une/view/{id}',['as'=>'alu.view','uses'=>'Admin\ALaUneController@shows','middleware' => ['permission:a-la-une-view']]);
            Route::get('a_la_une/pause/{id}',['as'=>'alu.pause','uses'=>'Admin\ALaUneController@pause']);
            Route::get('a_la_une/ban/{id}',['as'=>'alu.ban','uses'=>'Admin\ALaUneController@disable','middleware' => ['permission:a-la-une-ban-revoke']]);
            Route::get('a_la_une/revoke/{id}',['as'=>'alu.revoke','uses'=>'Admin\ALaUneController@enable','middleware' => ['permission:a-la-une-ban-revoke']]);

            // Prestataires
            Route::get('prestataire/list',['as'=>'pres.list','uses'=>'Admin\PrestataireController@index','middleware' =>['permission:prestataire-view|prestataire-ban-revoke|prestataire-list']]);
            Route::get('prestataire/view/{id}',['as'=>'pres.view','uses'=>'Admin\PrestataireController@shows','middleware' => ['permission:prestataire-view']]);
            Route::get('prestataire/ban/{id}',['as'=>'pres.ban','uses'=>'Admin\PrestataireController@ban','middleware' => ['permission:prestataire-ban-revoke']]);
            Route::get('prestataire/revoke/{slug}',['as'=>'pres.revoke','uses'=>'Admin\PrestataireController@revoke','middleware' => ['permission:prestataire-ban-revoke']]);
            Route::get('prestataire/activation/{slug}/{idTransaction}',['as'=>'pres.active','uses'=>'Admin\PrestataireController@activeFormule']);

            // Newsletter 

            //Route::get('/newsletter/subscribers', 'NewsletterSubscriptionController@showSubscribers')->name('newsletter.subscribers')->middleware('permission:newsletter-subscribers');
              Route::get('newsletter/abonnes',['as'=>'newsletter.abonnes','uses'=>'Admin\NewsletterSubscriptionController@showAbonnes','middleware' => ['newsletter-abonnes']]);

              
                Route::middleware(CheckNewsletterAbonnes::class)->group(function () {
                    // Vos routes protégées par le middleware ici
                    Route::get('newsletter/abonnes', 'Admin\NewsletterSubscriptionController@showAbonnes')->name('newsletter.abonnes');
                });

            // organization route
            Route::get('org/list',['as'=>'org.indexs','uses'=>'Admin\OrgController@index','middleware' => ['permission:organization-view|organization-ban-revoke|organization-list']]);
            Route::get('org/view/{id}',['as'=>'org.view','uses'=>'Admin\OrgController@shows','middleware' =>['permission:organization-view']]);
            Route::get('org/ban/{id}',['as'=>'org.ban','uses'=>'Admin\OrgController@ban','middleware' =>['permission:organization-ban-revoke']]);
            Route::get('org/revoke/{id}',['as'=>'org.revoke','uses'=>'Admin\OrgController@revoke','middleware' =>['permission:organization-ban-revoke']]);

            //Categoires Route
            Route::get('categories', ['as'=>'categories.index', 'uses'=>'Admin\EventCategoriesController@index','middleware' => ['permission:event-categories-create|event-categories-edit|event-categories-delete|event-categories-list']]);
            Route::get('categories/create', ['as'=>'categories.create', 'uses'=>'Admin\EventCategoriesController@create','middleware' => ['permission:event-categories-create'] ]);
            Route::post('categories/store', ['as'=>'categories.store', 'uses'=>'Admin\EventCategoriesController@store','middleware' => ['permission:event-categories-create']]);
            Route::get('categories/remove/{id}',['as'=>'categories.remove','uses'=>'Admin\EventCategoriesController@remove','middleware' => ['permission:event-categories-delete']]);
            Route::get('categories/edit/{id}', ['as'=>'categories.edit', 'uses'=>'Admin\EventCategoriesController@edit','middleware' => ['permission:event-categories-edit']]);
            Route::patch('categories/update/{id}', ['as'=>'categories.update', 'uses'=>'Admin\EventCategoriesController@update','middleware' => ['permission:event-categories-edit']]);

            //Front User
            Route::get('frontuser/index',['as'=>'frontuser.index','uses'=>'Admin\FrontuserController@index','middleware' => ['permission:front-user-list|front-user-view']]);
            Route::get('frontuser/getfrontusers',['as'=>'frontuser.getfrontusers','uses'=>'Admin\FrontuserController@getfrontusers','middleware' => ['permission:front-user-list|front-user-view']]);
			
            Route::get('frontuser/invites',['as'=>'frontuser.invites','uses'=>'Admin\FrontuserController@invites','middleware' => ['permission:front-user-list|front-user-view']]);
            Route::get('frontuser/getinvites',['as'=>'frontuser.getinvites','uses'=>'Admin\FrontuserController@getinvites','middleware' => ['permission:front-user-list|front-user-view']]);			
			
            Route::get('frontuser/show/{id}',['as'=>'frontuser.show','uses'=>'Admin\FrontuserController@show','middleware' => ['permission:front-user-view']]);
            Route::get('frontuser/showguest/{id}',['as'=>'frontuser.showguest','uses'=>'Admin\FrontuserController@showguest','middleware' => ['permission:front-user-view']]);
			
            Route::get('frontuser/delete/{id}',['as'=>'frontuser.delete','uses'=>'Admin\FrontuserController@delete','middleware' => ['permission:front-user-delete']]);
            Route::get('frontuser/deleteguest/{id}',['as'=>'frontuser.deleteguest','uses'=>'Admin\FrontuserController@deleteguest','middleware' => ['permission:front-user-delete']]);

			Route::get('frontuser/fus/{id}/{sid}',['as'=>'front.status','uses' => 'Admin\FrontuserController@change_status','middleware' => ['permission:front-user-view']]);

            //Wallet
            Route::post('/frontuser/show/{id}/add-or-substract-money-to-wallet',['as'=>'addOrSubstractMoneyToWallet','uses'=>'Admin\FrontuserController@addOrSubstractMoneyToWallet','middleware' => ['permission:front-user-view']]);


            Route::get('frontuser/exportfrontusers',['as'=>'frontuser.exportfrontusers','uses'=>'Admin\FrontuserController@exportfrontusers','middleware' => ['permission:front-user-list|front-user-view']]);
            Route::get('frontuser/exportguestusers',['as'=>'frontuser.exportguestusers','uses'=>'Admin\FrontuserController@exportguestusers','middleware' => ['permission:front-user-list|front-user-view']]);
            Route::get('frontuser/exportfrontusersnewsletter', ['as'=>'frontuser.exportfrontusersnewsletter', 'uses'=>'Admin\FrontuserController@exportfrontusersnewsletter', 'middleware' => ['permission:front-user-list|front-user-view']]);
            Route::get('frontuser/exportguestusersnewsletter', ['as'=>'frontuser.exportguestusersnewsletter', 'uses'=>'Admin\FrontuserController@exportguestusersnewsletter', 'middleware' => ['permission:front-user-list|front-user-view']]);

            //Feedback
            Route::get('feedback',['as'=>'feedback.index','uses'=>'Admin\ContactController@contact','middleware'=>['permission:feedback-list']]);
            Route::get('feedback/delete/{id}',['as'=>'feedback.delete','uses'=>'Admin\ContactController@contact_delete','middleware'=>['permission:feedback-delete']]);

            //Contact Page
            Route::get('contact/index',['as'=>'contact.index','uses'=>'Admin\ContactController@index','middleware'=>['permission:contact-page']]);
            Route::post('contact/update',['as'=>'contact.update','uses'=>'Admin\ContactController@contact_update','middleware' => ['permission:contact-page']]);

            //Terms Page
            Route::get('terms/index',['as'=>'terms.index','uses'=>'Admin\PagesController@terms_index','middleware'=>['permission:terms-page']]);
            Route::post('terms/update',['as'=>'terms.update','uses'=>'Admin\PagesController@terms_update','middleware' => ['permission:terms-page']]);

            //Privacy Policy
            Route::get('privacy/index',['as'=>'privacy.index','uses'=>'Admin\PagesController@privacy_index','middleware'=>['permission:privacy-page']]);
            Route::post('privacy/update',['as'=>'privacy.update','uses'=>'Admin\PagesController@privacy_update','middleware' => ['permission:privacy-page']]);

            //Faqs
            Route::get('faqs/index',['as'=>'faqs.index','uses'=>'Admin\PagesController@faqs_index','middleware'=>['permission:faq-page']]);
            Route::post('faqs/update',['as'=>'faqs.update','uses'=>'Admin\PagesController@faqs_update','middleware' => ['permission:faq-page']]);

            //Support
            Route::get('support/index',['as'=>'support.index','uses'=>'Admin\PagesController@support_index','middleware'=>['permission:support-page']]);
            Route::post('support/update',['as'=>'support.update','uses'=>'Admin\PagesController@support_update','middleware' => ['permission:support-page']]);

            //About us
            Route::get('aboutus/index',['as'=>'aboutus.index','uses'=>'Admin\PagesController@aboutus_index','middleware'=>['permission:aboutus-page']]);
            Route::post('aboutus/update',['as'=>'aboutus.update','uses'=>'Admin\PagesController@aboutus_update','middleware' => ['permission:aboutus-page']]);

            //Server Requirement
            Route::get('server-requirement/index',['as'=>'sreqrmnt.index','uses'=>'Admin\PagesController@sreqrmnt_index','middleware'=>['permission:server-requre-page']]);
            Route::post('server-requirement/update',['as'=>'sreqrmnt.update','uses'=>'Admin\PagesController@sreqrmnt_update','middleware' => ['permission:server-requre-page']]);

            Route::get('booking',['as'=>'booking.user','uses' =>'Admin\OrderController@index','middleware' => ['permission:booking-list']]);
			
			
			Route::get('booking-free',['as'=>'paiement-gratuit','uses' =>'Admin\OrderController@paiementgratuit','middleware' => ['permission:booking-list']]);
            Route::get('booking-failed',['as'=>'paiement-echoue','uses' =>'Admin\OrderController@paiementechoue','middleware' => ['permission:booking-list']]);

            Route::get('getallorders',['as'=>'booking.getallorders','uses' =>'Admin\OrderController@getAllOrders','middleware' => ['permission:booking-list']]);
            Route::get('getfreeorders',['as'=>'booking.getfreeorders','uses' =>'Admin\OrderController@getFreeOrders','middleware' => ['permission:booking-list']]);
            Route::get('getfailedorders',['as'=>'booking.getfailedorders','uses' =>'Admin\OrderController@getFailedOrders','middleware' => ['permission:booking-list']]);
            Route::get('vieworderdetails',['as'=>'booking.vieworderdetails','uses' =>'Admin\OrderController@ViewOrderDetails','middleware' => ['permission:booking-list']]);

            
            Route::get('coupons',['as'=>'coupons.tickets','uses' =>'Admin\EventController@CouponsList']);
            Route::post('nouveau-coupon',['as'=>'coupon.new','uses' =>'Admin\EventController@NewCoupon']);
            Route::post('coupon-update',['as'=>'coupon.update','uses' =>'Admin\EventController@CouponUpdate']);

	    Route::get('coupons-check',['as'=>'coupon.check','uses' =>'Admin\EventController@CouponCheck']);            

            Route::get('coupons-listallevents',['as'=>'coupons.listallevents','uses' =>'Admin\EventController@ListAllEvents']);
            Route::post('coupon-delete',['as'=>'coupon.delete','uses' =>'Admin\EventController@CouponDelete']); 
            Route::get('coupons-rbacks',['as'=>'coupon.rbacks','uses' =>'Admin\EventController@CouponInfos']);
            
            // Sold Tickets
            Route::get('sold/tickets',['as'=>'sold.tik','uses' =>'Admin\OrgController@sold_tikets']);
            Route::get('manage/events/{id}',['as' => 'manage.events' ,'uses' => 'Admin\EventManageController@events_list']);
            Route::get('order/earn/{event_id}',['as' => 'order.earning' ,'uses' => 'Admin\EventManageController@order_erniing']);
            Route::get('event/manage/dashbaboard/{event_id}',['as' => 'admin.event.dashbaboard' ,'uses' => 'Admin\EventManageController@manageEventDashboard']);

            Route::get('settings/index',['as'=>'settings.index','uses'=>'Admin\SettingsController@index','middleware' => ['permission:website-setting-data']]);
            Route::post('settings/update',['as'=>'settings.update','uses'=>'Admin\SettingsController@update','middleware' => ['permission:website-setting-data']]);
            Route::get('settings/configuration',['as' => 'settings.configuration' ,'uses' => 'Admin\SettingsController@siteConfiguration','middleware' => ['permission:website-setting-data']]);
            Route::post('configuration/update',['as' => 'configuration.update','uses' => 'Admin\SettingsController@confugratioUpdate']);


            Route::get('seometa/index',['as'=>'seometa.index','uses'=>'Admin\SettingsController@seoindex','middleware' => ['permission:seo-meta-settings']]);
            Route::post('seometa/update/{key}',['as'=>'seo.update','uses'=>'Admin\SettingsController@seoUpdate','middleware' => ['permission:seo-meta-settings']]);

            //Bank Detail
            // Route::get('bank/create',['as'=>'bank.create','uses'=>'Admin\BankController@create']);
            Route::post('bank/store',['as'=>'bank.store','uses'=>'Admin\BankController@store']);
            Route::get('bank/delete/{id}',['as'=>'bank.delete','uses'=>'Admin\BankController@delete']);


            // Create Page Route
            Route::get('pages/create',['as'=>'page.index','uses' => 'Admin\PageController@page_index']);
            Route::post('pages/store',['as' => 'page.store','uses'=>'Admin\PageController@page_create']);
            // Dynamic Page
            Route::get('pages/{slug}',['as'=>'pages.index','uses'=>'Admin\PageController@pages']);
            Route::patch('pages/update/{slug}',['as'=>'pages.update','uses'=>'Admin\PageController@pages_update']);
            Route::get('pages/delete/{id}',['as' => 'pages.delete','uses' => 'Admin\PageController@delete_pages']);


            // Menus Header And Footer
            Route::get('menu/index',['as' => 'menus.index','uses' => 'Admin\MenuController@index','middleware'=>['permission:menu-setting']]);
            Route::post('menu/store/{slug}',['as' => 'menus.store','uses' => 'Admin\MenuController@store','middleware'=>['permission:menu-setting']]);

            // Refund
            Route::get('refund/pending',['as' => 'request.refund','uses' => 'Admin\RefundController@pending']);
            Route::get('refund/accept',['as' => 'accept.refund','uses' => 'Admin\RefundController@accept']);
            Route::get('refund/reject',['as' => 'reject.refund','uses' => 'Admin\RefundController@reject']);
            Route::post('refund/payment',['as' => 'order.refund','uses' => 'Admin\RefundController@refundPayment']);
            Route::post('refund/cancel',['as' => 'refund.rejcte.cancel','uses' => 'Admin\RefundController@RejectReason']);

            Route::get('attendee/{id}', ['as'=>'admin.events.attendee', 'uses'=>'EventController@eventAttendee']);

            // Logout
            Route::get('logout',['as'=>'logout','uses'=>'Auth\LoginController@logout']);
			
			
			/**---------------------------------------------------------------------------------------------------------------------------
			 *                           MEDIA UPLOAD ROUTE
			 * ----------------------------------------------------------------------------------------------------------------------------*/
			Route::group(['prefix' => 'media-upload', 'namespace' => 'Admin'], function () {
				Route::post('/alt', 'MediaUploadController@alt_change_upload_media_file')->name('admin.upload.media.file.alt.change');
				Route::get('/page', 'MediaUploadController@all_upload_media_images_for_page')->name('admin.upload.media.images.page');
				Route::post('/delete', 'MediaUploadController@delete_upload_media_file')->name('admin.upload.media.file.delete');
			});


			/* media upload */
			Route::post('media-upload', 'Admin\MediaUploadController@upload_media_file')->name('admin.upload.media.file');
			Route::post('media-upload/all', 'Admin\MediaUploadController@all_upload_media_file')->name('admin.upload.media.file.all');
			Route::post('/media-upload/loadmore', 'Admin\MediaUploadController@get_image_for_loadmore')->name('admin.upload.media.file.loadmore');
			
			
			Route::get('/banner-store',['as'=>'admin.banner.store','uses'=>'Admin\BannerStoreController@index']);
			Route::post('/banner-store/add',['as'=>'admin.banner.store.add','uses'=>'Admin\BannerStoreController@add']);
			Route::post('/banner-store/edit',['as'=>'admin.banner.store.edit','uses'=>'Admin\BannerStoreController@edit']);
			Route::get('/banner-store/delete',['as'=>'admin.banner.store.delete','uses'=>'Admin\BannerStoreController@delete']);
			Route::get('/banner-store/getdatas',['as'=>'admin.banner.getdatas','uses'=>'Admin\BannerStoreController@getdatas']);
			
			
			Route::get('/banner-immanquables',['as'=>'admin.bannerimmanquables','uses'=>'Admin\BannerImmanquablesStoreController@index']);
			Route::post('/banner-immanquables/add',['as'=>'admin.bannerimmanquables.add','uses'=>'Admin\BannerImmanquablesStoreController@add']);
			Route::post('/banner-immanquables/edit',['as'=>'admin.bannerimmanquables.edit','uses'=>'Admin\BannerImmanquablesStoreController@edit']);
			Route::get('/banner-immanquables/delete/{id}',['as'=>'admin.bannerimmanquables.delete','uses'=>'Admin\BannerImmanquablesStoreController@delete']);
			Route::get('/banner-immanquables/getdatas',['as'=>'admin.bannerimmanquables.getdatas','uses'=>'Admin\BannerImmanquablesStoreController@getdatas']);			

			/*------------------------------------------
				PRODUCTS MODULES
			 ------------------------------------------*/
			Route::prefix('products')->namespace('Product')->group(function () {
				/*-----------------------------------
					PRODUCTS ROUTES
				------------------------------------*/
				Route::group(['as' => 'admin.products.'], function () {
					Route::get('/', 'ProductController@index')->name('all');
					Route::get('/new', 'ProductController@create')->name('new');
					Route::post('/new', 'ProductController@store');
					Route::get('edit/{item}', 'ProductController@edit')->name('edit');
					Route::post('update/{item}', 'ProductController@update')->name('update');
					Route::post('delete/{item}', 'ProductController@destroy')->name('delete');
					Route::post('clone/{item}', 'ProductController@clone')->name('clone');
					Route::post('/bulk-action', 'ProductController@bulk_action')->name('bulk.action');
				});

				/*-----------------------------------
					DELETED PRODUCTS ROUTES
				------------------------------------*/
				Route::group(['prefix' => 'deleted', 'as' => 'admin.products.deleted.'], function () {
					Route::get('/', 'DeletedProductsController@index')->name('all');
					Route::post('restore/{item}', 'DeletedProductsController@restore')->name('restore');
					Route::post('delete/{item}', 'DeletedProductsController@destroy')->name('permanent.delete');
					Route::post('/bulk-action', 'DeletedProductsController@bulk_action')->name('bulk.action');
				});

				/*-----------------------------------
					PRODUCTS RATINGS ROUTES
				------------------------------------*/
				Route::group(['prefix' => 'ratings', 'as' => 'admin.products.ratings.'], function () {
					Route::get('/', 'ProductRatingController@index')->name('all');
					Route::post('/approve', 'ProductRatingController@approve')->name('approve');
					Route::post('/delete/{rating}', 'ProductRatingController@destroy')->name('delete');
					Route::post('/bulk-action', 'ProductRatingController@bulk_action')->name('bulk.action');
				});
				/*--------------------------
					  * variant
				--------------------------*/
				Route::group(['prefix' => 'attributes', 'as' => 'admin.products.attributes.'], function () {
					Route::get('/', 'ProductAttributeController@index')->name('all');
					Route::get('/new', 'ProductAttributeController@create')->name('store');
					Route::post('/new', 'ProductAttributeController@store');
					Route::get('/edit/{item}', 'ProductAttributeController@edit')->name('edit');
					Route::post('/update', 'ProductAttributeController@update')->name('update');
					Route::post('/delete/{item}', 'ProductAttributeController@destroy')->name('delete');
					Route::post('/bulk-action', 'ProductAttributeController@bulk_action')->name('bulk.action');
					Route::post('/details', 'ProductAttributeController@get_details')->name('details');
					Route::post('/by-lang', 'ProductAttributeController@get_all_variant_by_lang')->name('admin.products.variant.by.lang');
				});
				/*-----------------------------------
					PRODUCTS  ORDERS ROUTES
				------------------------------------*/
				Route::group(['prefix' => 'product-order', 'as' => 'admin.product.order.'], function () {
					Route::get('/', 'ProductOrderController@orderLogs')->name('logs');
					Route::get('new-order', 'ProductOrderController@create')->name('new');
					Route::post('new-order', 'ProductOrderController@store');
					Route::get('view/{id}', 'ProductOrderController@show')->name('view');
					Route::post('delete/{id}', 'ProductOrderController@delete')->name('payment.delete');

					Route::post('filter-order', 'ProductOrderController@filterOrders')->name('filter'); // === later ===

					Route::post('/approve', 'ProductOrderController@product_order_payment_approve')->name('payment.approve');
					Route::post('/status-change', 'ProductOrderController@product_order_status_change')->name('status.change');
					Route::post('/bulk-action', 'ProductOrderController@product_order_bulk_action')->name('bulk.action');
					Route::post('/order-reminder', 'ProductOrderController@order_reminder')->name('reminder');

					Route::get('get-product-row', 'ProductOrderController@getProductRow')->name('product.row');
				});
				Route::get('generate-products-invoice', 'ProductOrderController@generateInvoice')->name('frontend.product.invoice.generate'); 

				Route::group(['prefix' => 'import', 'as' => 'admin.products.import.'], function () {
					Route::get('/', 'ProductImportController@import_settings')->name('all');
					Route::post('update-settings', 'ProductImportController@update_import_settings')->name('settings.update');
					Route::post('/', 'ProductImportController@import_to_database_settings')->name('to.database');
				});

				/*-----------------------------------
					PRODUCT CATEGORY  ROUTES
				------------------------------------*/
				Route::group(['prefix' => 'categories', 'as' => 'admin.products.category.'], function () {
					Route::get('/', 'ProductCategoryController@index')->name('all');
					Route::post('new', 'ProductCategoryController@store')->name('new');
					Route::post('update', 'ProductCategoryController@update')->name('update');
					Route::post('delete/{item}', 'ProductCategoryController@destroy')->name('delete');
					Route::post('bulk-action', 'ProductCategoryController@bulk_action')->name('bulk.action');
				});

				/*-----------------------------------
					PRODUCT SUB-CATEGORY  ROUTES
				------------------------------------*/
				Route::group(['prefix' => 'sub-categories', 'as' => 'admin.products.subcategory.'], function () {
					Route::get('/', 'ProductSubCategoryController@index')->name('all');
					Route::post('new', 'ProductSubCategoryController@store')->name('new');
					Route::post('update', 'ProductSubCategoryController@update')->name('update');
					Route::post('delete/{item}', 'ProductSubCategoryController@destroy')->name('delete');
					Route::post('bulk-action', 'ProductSubCategoryController@bulk_action')->name('bulk.action');

					Route::get('of-category/{id}', 'ProductSubCategoryController@getSubcategoriesOfCategory')->name('of.category');
				});

				/*-----------------------------------
					COUPON ROUTES
				------------------------------------*/
				Route::group(['prefix' => 'coupons', 'as' => 'admin.products.coupon.'], function () {
					Route::get('/', 'ProductCouponController@index')->name('all');
					Route::post('new', 'ProductCouponController@store')->name('new');
					Route::post('update', 'ProductCouponController@update')->name('update');
					Route::post('delete/{item}', 'ProductCouponController@destroy')->name('delete');
					Route::post('bulk-action', 'ProductCouponController@bulk_action')->name('bulk.action');
					Route::get('check', 'ProductCouponController@check')->name('check');
					Route::get('get-products', 'ProductCouponController@allProductsAjax')->name('products');
				});

				/*-----------------------------------
					TAG ROUTES
				------------------------------------*/
				Route::group(['prefix' => 'tags', 'as' => 'admin.products.tag.'], function () {
					Route::get('/', 'TagController@index')->name('all');
					Route::post('new', 'TagController@store')->name('new');
					Route::post('update', 'TagController@update')->name('update');
					Route::post('delete/{item}', 'TagController@destroy')->name('delete');
					Route::post('bulk-action', 'TagController@bulk_action')->name('bulk.action');
					Route::get('check', 'TagController@check')->name('check');
					Route::get('get-tags', 'TagController@getTagsAjax')->name('get.ajax');
				});

				/*-----------------------------------
					PRODUCT TAG ROUTES
				------------------------------------*/
				Route::group(['prefix' => 'product-tags', 'as' => 'admin.products.product.tag.'], function () {
					Route::get('/', 'ProductTagController@index')->name('all');
					Route::post('new', 'ProductTagController@store')->name('new');
					Route::post('update', 'ProductTagController@update')->name('update');
					Route::post('delete/{item}', 'ProductTagController@destroy')->name('delete');
					Route::post('bulk-action', 'ProductTagController@bulk_action')->name('bulk.action');
					Route::get('check', 'ProductTagController@check')->name('check');
				});

				/*-----------------------------------
					INVENTORY ROUTES
				------------------------------------*/
				Route::group(['prefix' => 'product-inventory', 'as' => 'admin.products.inventory.'], function () {
					Route::get('/', 'ProductInventoryController@index')->name('all');
					Route::get('edit/{item}', 'ProductInventoryController@edit')->name('edit');
					Route::post('update', 'ProductInventoryController@update')->name('update'); // [===== ??? =====]
					Route::post('delete', 'ProductInventoryController@destroy')->name('delete');
					Route::post('bulk-action', 'ProductInventoryController@bulk_action')->name('bulk.action');
				});
			});



			 			
			
			
			
			

        });
        Route::get('{slug?}',['as' => 'custom.slug','uses' => 'EventController@getBySlug']);
});



        /* Cinetpay */
        //Wallet & Cinetpay
        Route::post('paiement/wallet_cinetpay', ['as'=>'wallet_cinetpay.paiement','uses'=>'CinetPayController@generate_cinetpay_form']);
        //Fin Wallet & 
        
        Route::post('discount', [
            'as'=>'store.discount',
            'uses'=>'CinetPayController@storeDiscount']);

        Route::match(array('GET', 'POST'),'notification/cinetpay', ['as'=>'cinetpay.notification','uses'=>'CinetPayController@cinetpay_notification']);
        Route::match(array('GET', 'POST'),'retour/cinetpay', ['as'=>'cinetpay.return','uses'=>'CinetPayController@cinetpay_retour']);/*cinetpay_retour*/

        Route::get('annulation/cinetpay/{id}', ['as'=>'cinetpay.delete','uses'=>'CinetPayController@cinetpay_annulation']);
        Route::get('notification/cinetpay/{order_id}-{origine}', ['as'=>'orderdone.cinetpay','uses'=>'TicketController@orderDone']);
        Route::post('paiement/wallet', ['as'=>'cart_wallet.paiement','uses'=>'CartController@payWithWallet']);











        Route::match(array('GET', 'POST'),'shop/notification/cinetpay', ['as'=>'shop.cinetpay.notification','uses'=>'Product\ProductSellPaymentController@cinetpay_notification']);

        Route::match(array('GET', 'POST'),'shop/retour/cinetpay', ['as'=>'shop.cinetpay.return','uses'=>'Product\ProductSellPaymentController@cinetpay_retour']);
        Route::get('shop/notification/cinetpay/{id_transaction}', ['as'=>'shop.orderdone.cinetpay','uses'=>'Product\ProductSellPaymentController@orderDone']);
        Route::get('shop/annulation/cinetpay/{id}', ['as'=>'shop.cinetpay.delete','uses'=>'Product\ProductSellPaymentController@cinetpay_annulation']);


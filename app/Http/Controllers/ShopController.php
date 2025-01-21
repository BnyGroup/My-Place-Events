<?php

namespace App\Http\Controllers;

use Validator;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use PDF;
use Mail;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\RouteCollection;
use Illuminate\Http\Request;
use Hash;
use File;
use DivArt\ShortLink\Facades\ShortLink;
use Carbon\Carbon;
use App\orderTickets;
use App\Refund;
use App\Post;
use App\PaysList;
use App\Organization;
use App\ImageUpload;
use App\Http\Controllers\FrontController;
use App\Hit;
use App\EventTicket;
use App\EventCategory;
use App\Event;
/*use Corcel\Model\Post;*/
use App\Bookmark;
use App\Booking;
use Zebra_Pagination;
use Illuminate\Support\Facades\Auth;
use App\Color;
use App\Size;
use App\Gadget;
use Illuminate\Support\Facades\DB;

use App\Product\Product;
use App\Product\ProductAttribute;
use App\Product\ProductCategory;
use App\Product\ProductRating;
use App\Product\ProductSellInfo;
use App\Product\ProductSubCategory;
use App\Product\Tag;
use Illuminate\Support\Str;
use App\Action\CartAction;
use App\Helpers\CartHelper;
use App\Shipping\ShippingMethod;
use App\Shipping\UserShippingAddress;

use App\BannerStore;

class ShopController extends FrontController
{

    public function __construct() {
    	parent::__construct();
    	$this->event = new Event;
		$this->gadget = new Gadget;
    	$this->event_ticket = new EventTicket;
    	$this->event_category = new EventCategory;
    	$this->organization = new Organization;
    	$this->hit = new Hit;
    	$this->bookmark = new Bookmark;
    	$this->booking = new Booking;
    	$this->orderTickets = new orderTickets;
    	$this->refund = new Refund;
    	$this->pays = new PaysList;
	}

	
	/* ================================================ */
	/* LIST GADGET =================================== */
	/* ================================================ */
    public function index($url=null) {

 		setMetaData('La Boutique', '', 'create event,event,new event', for_logo());

		//$post = Post::find(39);
		$currentPageURL = URL()->current();
		$pageArray 		= explode('/', $currentPageURL);
		$pageActive 	= isset($pageArray[6]) ? $pageArray[6] : '';
		//dd($pageArray[4]);
		if(isset($pageActive) &&  $pageActive != '' ){
		 	$pageUrl = explode("--", $pageActive);
		}else{
		 	$pageUrl = explode("--", "cat--date--all");
		}
		$pageUrl_pric = explode('?', $pageUrl[2]);

 		$categories	= $this->event_category->get_Category_event();
 		$catdata = [];
 		if (isset($_GET['cat'])) {
 			$catdata = $this->event_category->findCategories($_GET['cat']);
 		}
		$event_tickets = $this->event_ticket;
		$gadgets = $this->gadget->geteventwithtickets();
		
		$ProductCategory = ProductCategory::where('status','publish')->get();
		
		$TopProducts = Product::where('products.status', 'publish')
            ->leftJoin('product_ratings', 'product_id','=','products.id')
            ->with('inventory')
            ->with('rating')		
			->with('category')
            ->orderBy('sold_count', 'DESC')
            ->take(10)
            ->get(['products.*']);
		
		$ConcertProducts = Product::where('products.status', 'publish')
            ->where('products.category_id', '1')
            ->with('inventory')
            ->with('rating')		
			->with('category')
            ->orderBy('sold_count', 'DESC')
            ->take(10)
            ->get();

        $pays = PaysList::orderBy('nom_pays','asc')->get();
        $banR1=BannerStore::where("position","r1")->where('statut','1')->orderby("idb","desc")->first();
        $banR2=BannerStore::where("position","r2")->where('statut','1')->orderby("idb","desc")->first();
        $banMain=BannerStore::where("position","m")->where('statut','1')->orderby("idb","desc")->get();
 		return view('theme.gadgets.gadget-list-remake',compact('categories','gadgets','pageActive','pays','event_tickets','banR1','banR2','banMain',
 		'ProductCategory','TopProducts','ConcertProducts'));

 	}

	
	public function showategory($id){
		
		setMetaData('Catégorie', '', 'create event,event,new event', for_logo());
		$idcat=intval($id);		
		
		$PCategory = ProductCategory::where('status','publish')->where('id', $idcat)->first();
		
		$allProducts = Product::where('products.status', 'publish')
            ->where('products.category_id', $idcat)
            ->with('inventory')
            ->with('rating')		
			->with('category')
            ->orderBy('sold_count', 'DESC')
            ->take(10)
            ->get();
		
		$ProductCategory = ProductCategory::where('status','publish')->get();
		$categories	= $this->event_category->get_Category_event();
		$pays = PaysList::orderBy('nom_pays','asc')->get();
		return view('theme.gadgets.shopcategory',compact('categories','pays','allProducts','ProductCategory','PCategory'));
 	}
	
	
	public function cartPage(Request $request)
    {
        $default_shipping_cost = CartAction::getDefaultShippingCost();
        $all_cart_items = CartHelper::getItems();

        // validate stock count here ...
        CartAction::validateItemQuantity();

        $all_cart_items = CartHelper::getItems();
        $products = Product::whereIn('id', array_keys($all_cart_items))->get();

        $subtotal = CartAction::getCartTotalAmount($all_cart_items, $products);
        $total = CartAction::calculateCoupon($request, $subtotal, $products);

		$ProductCategory = ProductCategory::where('status','publish')->get();
		$categories	= $this->event_category->get_Category_event();
		$pays = PaysList::orderBy('nom_pays','asc')->get();
		
		return view('theme.gadgets.cart.all', compact('all_cart_items', 'products', 'subtotal', 'total','ProductCategory','categories','pays'));
    }

/* ================================================ */
/* DISPLAY SINGLE Shop ========================== */
/* ================================================ */
	
	public function shopsingle($id){
		setMetaData('Catégorie', '', 'create event,event,new event', for_logo());
		$pid=intval($id);		
 		
		$product = Product::where('id', $pid)->with('additionalInfo')->first();

        if ($product) {
            $sub_category_arr = json_decode($product->sub_category_id, true);  
			if($sub_category_arr==null) $sub_category_arr= [];

            $related_products = Product::whereIn('sub_category_id', $sub_category_arr)
                ->with('campaignProduct', 'campaignSoldProduct')
                ->where('id', '!=', $product->id)->get();

            $user = auth()->guard('frontuser')->user();
            $user_has_item = false;

            if (!$related_products->count()) {
                $related_products = Product::where('category_id', $product->category_id)->with('inventory', 'campaignProduct', 'campaignSoldProduct')->where('id', '!=', $product->id)->get();
            }

            if ($user) {
                $user_has_item = !ProductSellInfo::where('user_id', $user->id)->where('product_id', $product->id)->count();
            }

            $ratings = ProductRating::where('product_id', $product->id)->where('status', 1)->with('user')->get();
            $avg_rating = $ratings->count() ? round($ratings->sum('rating') / $ratings->count()) : null;
 		 
		
		$ProductCategory = ProductCategory::where('status','publish')->get();
		$categories	= $this->event_category->get_Category_event();
		$pays = PaysList::orderBy('nom_pays','asc')->get();
		
		return view('theme.gadgets.shop_single',compact('categories','pays','ProductCategory', 'product', 'related_products', 'user_has_item', 'ratings', 'avg_rating'));
        }		
		return abort(404);
	}
	
	
 	public function singlegadget($slug,$snippet='') {
 		Carbon::setLocale('fr');
		//$date = Carbon::yesterday()-> diffForHumans();
 		//dd($date);
		 
 		if ($snippet != '') {
			$slug = \Crypt::decrypt($slug);
		}
		$fuser_id = (auth()->guard('frontuser')->check())?auth()->guard('frontuser')->user()->id:0;
 		$gadget = $this->gadget->getsingleevent($slug);
			//dd($gadget);
 		if(is_null($gadget)){
 		 	\App::abort(404, 'Event Not Found');
 		}
 		if($gadget->ban == 1){
 			$userid = (auth()->guard('frontuser')->check())?auth()->guard('frontuser')->user()->id:0;
 			if($userid != $gadget->item_create_by){
 				\App::abort(404, 'Event Not Found');
 			}
 		}
 		if ($gadget->item_status == 0) {
 			$userid = (auth()->guard('frontuser')->check())?auth()->guard('frontuser')->user()->id:0;
 			if ($userid != $event->event_create_by) {
 				\App::abort(404, 'Event Not Found');
 			}
 		}
 		$data = $this->hit->hits($gadget->item_unique_id);
	
 		if(is_null($data)){
 			$input['event_id'] = $gadget->item_unique_id;
 			$input['ip'] = \Request::ip();
 			$this->hit->countInsert($input);
		}
		$event_tickets = $this->event_ticket;
		
		$bookmark = $this->bookmark->getData($gadget->item_unique_id,$fuser_id);
 		//$count = count($data);
 		$event_ticket	= $this->event_ticket->event_tickets($gadget->item_unique_id);
		
 		return view('theme.gadgets.gadget-detail',compact('gadget', 'event_ticket','bookmark','event_tickets'));
 	}
	
	
	
	
    public function checkoutPage(Request $request)
    {
        $default_shipping_cost = CartAction::getDefaultShippingCost();
        $default_shipping = CartAction::getDefaultShipping();
        $user = auth()->guard('frontuser')->user();

        $all_user_shipping = [];

        if (auth()->guard('frontuser')->check()) {
            $all_user_shipping = UserShippingAddress::where('user_id', auth()->guard('frontuser')->user()->id)->get();
        }

        $countries = PaysList::get();

        // if not campaign
        $all_cart_items = CartHelper::getItems();  
        $products = Product::whereIn('id', array_keys($all_cart_items))->get();

        $subtotal = CartAction::getCartTotalAmount($all_cart_items, $products);
        $subtotal_with_tax = $subtotal + $default_shipping_cost;
        $total = CartAction::calculateCoupon($request, $subtotal_with_tax, $products);
        $coupon_amount = CartAction::calculateCoupon($request, $subtotal_with_tax, $products, 'DISCOUNT');
		
		$ProductCategory = ProductCategory::where('status','publish')->get();
		$categories	= $this->event_category->get_Category_event();
		$pays = PaysList::orderBy('nom_pays','asc')->get();		
        
        return view('theme.gadgets.cart.checkout', compact(
            'all_cart_items',
            'all_user_shipping',
            'products',
            'subtotal',
            'countries',
            'default_shipping_cost',
            'default_shipping',
            'total',
            'user',
            'coupon_amount','categories','pays','ProductCategory'	
        ));
    }
     /**
     * Store a newly created resource in storage. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function product_rating_store(Request $request)
    {
        $user = auth('web')->user();
        if (!$user) {
            return back()->with(FlashMsg::explain('danger', __('Login to submit rating')));
        }

        $this->validate($request, [
            'id' => 'required|exists:products',
            'rating' => 'required|string',
            'comment' => 'required|string',
        ]);

        $rating = abs($request->rating) == 0 ? 1 : abs($request->rating);

        if ($request->rating > 5) {
            $rating = 5;
        }

        // ensure rating not inserted before
        $user_rated_already = !! ProductRating::where('product_id', $request->id)->where('user_id', $user->id)->count();
        if ($user_rated_already) {
            return back()->with(FlashMsg::explain('danger', __('You have rated before')));
        }

        $rating = ProductRating::create([
            'product_id' => $request->id,
            'user_id' => $user->id,
            'status' => 0,
            'rating' => $rating,
            'review_msg' => $request->comment,
        ]);

        return $rating->id
            ? back()->with(FlashMsg::create_succeed('rating'))
            : back()->with(FlashMsg::create_failed('rating'));
    }

	
	
	
	
	

/* ================================================ */
/* CREATE GADGET =================================== */
/* ================================================ */
 	public function create() {

		$colors = Color::orderBy('id','asc')->get();
		$sizes = Size::orderBy('id','asc')->get();
        $categories	= $this->event_category->get_Category_event();
        $id = Auth::guard('frontuser')->id();
        $listorg = $this->organization->orgList($id);
	    $datas = Organization::where('user_id',$id)->get();
	    $pays = PaysList::orderBy('nom_pays','asc')->get();
		//$events = Event::where('event_status',1)->orderBy('created_at','desc')->get();
		$events = Event::all();


 		return view('theme.gadgets.gadget-create',compact('categories','listorg','datas','pays','colors', 'sizes','events'));
 	}
/* ================================================ */
/* STORE GADGET =================================== */
/* ================================================ */
 	public function store(Request $request){
		$input = $request->all();

		//dd($input);
		$this->validate($request, [
			'item_name'			=> 'required',
			'item_location'		=> 'required',
            'start_date'			=> 'required|date_format:d/m/Y',
			'start_time'			=> 'required',
            'end_date'			    => 'required|date_format:d/m/Y',
            'end_time'				=> 'required',
			'item_category'		=> 'required',
			'item_description'		=> 'required',
			'item_org_name'		=> 'required',
			'item_country'         => 'required',
			'item1_image'     		=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
		]);

    	$path = 'upload/gadgets/'.date('Y').'/'.date('m');
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }
        if (!empty($request->file('item1_image'))) {
            $input['item1_image'] = ImageUpload::upload($path,$request->file('item1_image'),'gadget-image');
            list($width, $height, $type, $attr) = getimagesize($request->file('item1_image'));
            ImageUpload::uploadThumbnail($path,$input['item1_image'],360,360,'thumb');
            ImageUpload::uploadThumbnail($path,$input['item1_image'],$width,$height,'resize');
        	$input['item1_image'] = save_image($path,$input['item1_image']);
        }
        $item_unique_id 	= str_shuffle(time());
        $item_slug			= str_slug($input['item_name']).'-'.$item_unique_id;

        $input['item_status'] = 2;
		$input['item_remaining'] = isset($input['item_remaining'])?$input['item_remaining']:0;


		// date and time 
		$stardt	= $input['start_date']." ".$input['start_time'];
		$enddt	= $input['end_date']." ".$input['end_time'];


        $start_datetime = Carbon::createFromFormat('d/m/Y H:i', $stardt)->format('Y-m-d H:i:s');
        $end_datetime 	= Carbon::createFromFormat('d/m/Y H:i', $enddt)->format('Y-m-d H:i:s');

        // date and time
		$input['item_start_datetime'] = $start_datetime;
		$input['item_end_datetime'] = $end_datetime;
    	$input['item_slug'] = $item_slug;
        $input['item_unique_id'] = $item_unique_id;
        $input['item_qrcode'] = '0';
        $input['item_qrcode_image'] = '0';
        $input['item_create_by'] = auth()->guard('frontuser')->user()->id;
		$input['item_color'] = json_encode($request->input('item_color'));
		$input['item_size'] = json_encode($request->input('item_size'));


        // EVENT TICKETS
        if(isset($input['ticket_type'])) {

        	$nooftickets	= count($input['ticket_type']);
	        $tickets_array 	= array();
		    for($i=0; $i<$nooftickets; $i++){

		    	$ticket_id 			= strtoupper(str_shuffle(str_random(5)).str_shuffle($item_unique_id).str_shuffle(str_random(5)));
		    	$ticket_type		= $input['ticket_type'][$i];
		    	$event_commission 	= event_commission();
                $ticket_price		= $input['ticket_price_actual'][$i];
		    	$services_fee		= $input['ticket_services_fee'][$i];
		    	if($ticket_type == 0){
		    		$ticket_price = 0;
		    		$event_commission = 0;
		    	}
		    	if($ticket_type == 2){
		    		$ticket_price = 0;
		    	}
		    	$event_fees			= ($ticket_price) * ($event_commission / 100);
		    	if($services_fee == 1){
                    $buyer_price	= $ticket_price;
                    $ticket_price	= $ticket_price - $event_fees;
		    	}else{
		    		$buyer_price	= $ticket_price;
		    	}

		    	$desc_status 	= isset($input['ticket_desc_status'][$i])?1:0;
		    	$ticket_status 	= isset($input['ticket_status'][$i])?1:0;

		    	$tickets_array['ticket_id'] 			= implode('-', str_split(str_shuffle($ticket_id), 5));
		    	$tickets_array['event_id']				= $item_unique_id;
		    	$tickets_array['ticket_title'] 			= $input['ticket_title'][$i];
		    	$tickets_array['ticket_description'] 	= $input['ticket_description'][$i];
		    	$tickets_array['ticket_desc_status'] 	= $desc_status;
		    	$tickets_array['ticket_qty'] 			= $input['ticket_qty'][$i];
		    	$tickets_array['ticket_remaning_qty']	= $input['ticket_qty'][$i];
		    	$tickets_array['ticket_type'] 			= $ticket_type;
		    	$tickets_array['ticket_status']			= $ticket_status;
		    	$tickets_array['ticket_services_fee'] 	= $services_fee;
                $tickets_array['ticket_price_buyer'] 	= number_format($buyer_price,0,",","");
                $tickets_array['ticket_price_actual'] 	= number_format($ticket_price,0,",","");
                $tickets_array['ticket_commission'] 	= number_format($event_commission,0,",","");

		    	$data = $this->event_ticket->insertData($tickets_array);
		    }
		}

        $orderData = (object)$input;

        /* A implémenter après
        $mail = array(
                'charlene.valmorin@gmail.com',
                'contact@myplace-events.com',
                //'williamscedricdabo@gmail.com',
                'christelle.abeu@myplace-events.com');

        
        try {
            Mail::send('theme.pdf.new-event-added',['orderData'=>$orderData],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Evénement créé');
            });
        } catch (\Exception $e) {
            dd($e);
            //return redirect()->route('index');
        }
        */  
		$link = route('shop_item.details', $item_slug);
		// $url = ShortLink::bitly($link);
		$input['short_url'] 	= $link;
		$input['refund_policy'] = $input['refund'];
        $data = $this->gadget->insertData($input);
       	return redirect()->route('shop.item.manage')->with('success',trans('Votre annonce est en cours d\'approbation'));
 	}

/* ================================================ */
/* UPDATE GADGET =================================== */
/* ================================================ */
	public function update(Request $request, $id)
	{
		$input = $request->all();
		//dd($input);
		$price_change = $this->booking->priceChange($id);
		$this->validate($request, [
			'item_name'			=> 'required',
			'item_location'		=> 'required',
            'start_date'			=> 'required|date_format:d/m/Y',
			'start_time'			=> 'required',
            'end_date'			    => 'required|date_format:d/m/Y',
            'end_time'				=> 'required',
			'item_category'		=> 'required',
			'item_description'		=> 'required',
			'item_org_name'		=> 'required',
			'item_country'         => 'required',
			'item1_image'     		=> 'image|mimes:jpeg,png,jpg,gif|max:2048',
		]);

		$input['item_color'] = json_encode($request->input('item_color'));
		$input['item_size'] = json_encode($request->input('item_size'));


		if ($input['radio-group'] != 1) {
			$input['item_color'] = NULL;
			$input['item_size'] = NULL;
		}

		$path = 'upload/gadgets/'.date('Y').'/'.date('m');
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }

        $input['map_display'] = isset($input['map_display'])?1:0;

        /* date and time */
		$stardt	= $input['start_date']." ".$input['start_time'];
		$enddt	= $input['end_date']." ".$input['end_time'];

        $start_datetime = Carbon::createFromFormat('d/m/Y H:i', $stardt)->format('Y-m-d H:i:s');
        $end_datetime 	= Carbon::createFromFormat('d/m/Y H:i', $enddt)->format('Y-m-d H:i:s');
		/* date and time */

		$input['item_start_datetime'] = $start_datetime;
		$input['item_end_datetime'] = $end_datetime;

		if (isset($input['refund'])) {
			$input['refund_policy'] = $input['refund'];
		}
		if (!empty($input['item1_image'])) {
			$input['item1_image'] = ImageUpload::upload($path,$request->file('item1_image'),'event-image');
            list($width, $height, $type, $attr) = getimagesize($request->file('item1_image'));
            ImageUpload::uploadThumbnail($path,$input['item1_image'],360,360,'thumb');
            ImageUpload::uploadThumbnail($path,$input['item1_image'],$width,$height,'resize');
        	$input['item1_image'] = save_image($path,$input['item1_image']);

			if (!empty($input['old_image'])) {
				$datas = image_delete($input['old_image']);
                $path = $datas['path'];
                $image = $datas['image_name'];
                $image_thum = $datas['image_thumbnail'];
                $image_resize = 'resize-'.$datas['image_name'];
                ImageUpload::removeFile($path,$image,$image_thum,$image_resize);
			}
			$this->gadget->updateData($id,$input);
		}
		else
		{
			$input['item1_image'] = $input['old_image'];

			$this->gadget->updateData($id,$input);
		}

		/* EVENT TICKETS */
        if(isset($input['ticket_type'])) {

        	$nooftickets =  count($input['ticket_type']);
	        $tickets_array = array();
		    for($i=0; $i<$nooftickets; $i++){
		    	if(isset($input['ticket_id'][$i]) && $input['ticket_id'][$i] != ''){

		    		$desc_status = $input['ticket_desc_status'][$i];
			    	$ticket_status = $input['ticket_status'][$i];
			    	$sold_tickets	= intval($input['old_qty'][$i]) - intval($input['remaning_qty'][$i]);
			    	if($input['old_qty'][$i] == $input['ticket_qty'][$i]){
			    		$remaning_qty = $input['remaning_qty'][$i];
			    	}else if($input['old_qty'][$i] > $input['ticket_qty'][$i]){
			    		if($input['ticket_qty'][$i] <= $sold_tickets) {
			    			$input['ticket_qty'][$i] = $sold_tickets;
			    			$remaning_qty = 0;
			    		}else{
			    			$remaning_qty = intval($input['ticket_qty'][$i]) - intval($sold_tickets);
			    		}
			    	}else{
		    			$remaning_qty = intval($input['ticket_qty'][$i]) - intval($sold_tickets);
			    	}
			    	$ticket_type		= $input['ticket_type'][$i];
			    	$event_commission 	= event_commission();
			    	$ticket_price		= $input['ticket_price_actual'][$i];
			    	$services_fee		= $input['ticket_services_fee'][$i];
			    	if($ticket_type == 0){
			    		$ticket_price = 0;
			    		$event_commission = 0;
			    	}
			    	$event_fees			= ($ticket_price) * ($event_commission / 100);
			    	if($services_fee == 1){
			    		$buyer_price	= $ticket_price/*+ $event_fees*/;
			    		$ticket_price = $ticket_price - $event_fees;
			    	}else{
			    		$buyer_price	= $ticket_price;
			    	}
		    		$tickets_array['ticket_title'] 			= $input['ticket_title'][$i];
			    	$tickets_array['ticket_description'] 	= $input['ticket_description'][$i];
			    	$tickets_array['ticket_desc_status'] 	= $desc_status;
			    	$tickets_array['ticket_qty'] 			= $input['ticket_qty'][$i];
					$tickets_array['ticket_remaning_qty']	= $remaning_qty;
			    	$tickets_array['ticket_status']			= $ticket_status;
                    //$tickets_array['ticket_price_actual'] 	= number_format($buyer_price,2,"."," ");
                    //$tickets_array['ticket_price_actual'] 	= number_format($ticket_price,2,"."," ");
			    	$tickets_array['ticket_price_buyer'] 	= number_format($buyer_price,0,".","");
			    	$tickets_array['ticket_price_actual'] 	= number_format($ticket_price,0,".","");
			    	$tickets_array['ticket_services_fee'] 	= $services_fee;
			    	$this->event_ticket->updateData($input['ticket_id'][$i],$tickets_array);
		    	}else{
			    	$ticket_id = strtoupper(str_shuffle(str_random(5)).str_shuffle($id).str_shuffle(str_random(5)));
			    	$ticket_type		= $input['ticket_type'][$i];

			    	$event_commission 	= event_commission();
			    	$ticket_price		= $input['ticket_price_actual'][$i];
			    	$services_fee		= $input['ticket_services_fee'][$i];
			    	if($ticket_type == 0){
			    		$ticket_price = 0;
			    		$event_commission = 0;
			    	}
			    	if($ticket_type == 2){
			    		$ticket_price = 0;
			    	}
			    	$event_fees			= ($ticket_price) * ($event_commission / 100);
			    	if($services_fee == 1){
			    		$buyer_price	= $ticket_price /*+ $event_fees*/;
                        $ticket_price = $ticket_price - $event_fees;
			    	}else{
			    		$buyer_price	= $ticket_price;
			    	}

			    	$desc_status = isset($input['ticket_desc_status'][$i])?1:0;
			    	$ticket_status = isset($input['ticket_status'][$i])?1:0;
			    	$tickets_array['ticket_id'] 			= implode('-', str_split(str_shuffle($ticket_id), 5));
			    	$tickets_array['event_id']				= $id;
			    	$tickets_array['ticket_title'] 			= $input['ticket_title'][$i];
			    	$tickets_array['ticket_description'] 	= $input['ticket_description'][$i];
			    	$tickets_array['ticket_desc_status'] 	= $desc_status;
			    	$tickets_array['ticket_qty'] 			= $input['ticket_qty'][$i];
			    	$tickets_array['ticket_remaning_qty']	= $input['ticket_qty'][$i];
			    	$tickets_array['ticket_type'] 			= $ticket_type;
			    	$tickets_array['ticket_status']			= $ticket_status;
			    	$tickets_array['ticket_services_fee'] 	= $services_fee;

			    	/*$tickets_array['ticket_price_buyer'] 	= number_format($buyer_price,2,".","");
			    	$tickets_array['ticket_price_actual'] 	= number_format($ticket_price,2,".","");
			    	$tickets_array['ticket_commission'] 	= number_format($event_commission,2,".","");*/

                    $tickets_array['ticket_price_buyer'] 	= number_format($buyer_price,0,",","");
                    $tickets_array['ticket_price_actual'] 	= number_format($ticket_price,0,",","");
                    $tickets_array['ticket_commission'] 	= number_format($event_commission,0,",","");

			    	$data = $this->event_ticket->insertData($tickets_array);
		    	}
		    }
		}
		return redirect()->route('shop.item.manage')->with('success',trans('words.msg.gad_update'));
	}
/* ================================================ */
/* USER EVENTS LIST =============================== */
/* ================================================ */
	public function usergadgets() {

		$id		 = auth()->guard('frontuser')->user()->id;
		$uGadgets = Gadget::where('item_create_by',$id)->orderBy('created_at','desc')->paginate(10);

		$totalcount = Gadget::where('item_create_by',$id)->count();

		$darftCount = Gadget::where('item_create_by',$id)->where('item_status',0)->count();

		$datas		= Carbon::now();
        $start    	= Carbon::today()->addHours(23)->addMinutes(59)->addSeconds(59);
        $currenEve 	= Gadget::where('item_create_by',$id)->whereBetween('item_start_datetime',[$datas,$start])->count();

		$futereve 	= Gadget::where('item_create_by',$id)->where('item_start_datetime','>=',$datas)->count();
        $pastevev 	= Gadget::where('item_create_by',$id)->where('item_start_datetime','<=',$datas)->count();

        $draft      = Gadget::where('item_status',0)->get();
        $curentEven = Gadget::where('item_create_by',$id)->whereBetween('item_start_datetime',[$datas,$start])->get();
        $futerseve 	= Gadget::where('item_create_by',$id)->where('item_start_datetime','>=',$datas)->get();
        $pastevents = Gadget::where('item_create_by',$id)->where('item_start_datetime','<=',$datas)->get();


		return view('theme.gadgets.gadget-user', compact('uGadgets','totalcount','darftCount','currenEve','futereve','pastevev','draft','curentEven','futerseve','pastevents'));
	}


/* ================================================ */
/* USER EVENTS Edit  */
/* ================================================ */
	public function gadget_edit($unique_id)
	{
		$categories	= $this->event_category->get_Category_event();
		$colors = Color::orderBy('id','asc')->get();
		$sizes = Size::orderBy('id','asc')->get();
		// $childs		= $this->event_category->childs();
        $id = auth()->guard('frontuser')->user()->id;
        $listorg = $this->organization->orgList($id);
		// $categories = $this->event_category->getCategorylist();
		$gadgets = $this->gadget->findData($unique_id);
		$datas = Organization::where('user_id',$id)->get();
		$ticket = $this->event_ticket->event_tickets($unique_id);
		$price_change = $this->booking->priceChange($unique_id);
        $pays = PaysList::orderBy('nom_pays','asc')->get();
		//$events = Event::where('event_status',1)->orderBy('created_at','desc')->get();
		$events = Event::all();


		return view('theme.gadgets.gadget-edit',compact('categories','listorg','gadgets','ticket','datas','price_change','pays','colors', 'sizes','events'));
	}


/* ================================================ */
/*  */
/* ================================================ */
	public function gadgetDashboard($id){

		$userid	= auth()->guard('frontuser')->user()->id;

        $gadget = Gadget::where('item_create_by',$userid)->where('item_unique_id',$id)->first();

		$tickets = EventTicket::where('event_id', $id)->get();
        //$tickets = $this->event_ticket->get_paid_tickets($id);
		$event_tickets = $this->event_ticket->event_total_tickets($id);
        $eventOrderTickets = $this->event_ticket->eventOrderTickets($id);

        $totalOrderTickss = $this->orderTickets->totalOrderTickss($id);
        $totalChackInTickss = $this->orderTickets->totalChackInTickss($id);

		$bookedeve = $this->booking->getEventbook($id);
		// dd($bookedeve);
		//$data = Booking::where('event_id',$id)->get();
		$data = Booking::where('event_id',$id)->where('order_status','1')->get();
		$databook = $this->bookmark->getUserBook($id);
		$eventTicket = $this->orderTickets->orderTicketsByEvent($id);
		$contactAttendes 	= $this->booking->contactDetailAttends($userid,$id);
		return view('theme.gadgets.gadget-dashboard', compact('gadget', 'tickets','data','databook','bookedeve','eventTicket','event_tickets','eventOrderTickets','totalOrderTickss','totalChackInTickss','contactAttendes'));
	}


	public function delete($id)
	{
		$this->event->deleteData($id);
		$this->event_ticket->deleteTicket($id);
		return redirect()->route('events.manage')->with('success',trans('words.msg.eve_delete'));
	}

	public function eventAttendee($event_id)
	{
		$eventData		= $this->event->eventByUid($event_id);
		$eventTicket 	= $this->orderTickets->orderTicketsByEvent($event_id);
        //dd($eventData,$eventTicket);
		$pdf = PDF::loadView('theme.pdf.attendee',compact('eventTicket','eventData'));
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
		return $pdf->download($eventData->event_name.'\'s attendee list.pdf');
		//return $pdf->stream('attendee.pdf');
		//$pdf->save('public/'.$pdf_save_path);
		// dd($eventTicket);
	}

	public function bookmark(Request $request) {
		$getdata = $request->all();
		$input['event_id'] = $getdata['eid'];
		$input['user_id'] = $getdata['uid'];
		$data = $this->bookmark->getData($getdata['eid'],$getdata['uid']);
		if (is_null($data)) {
			$this->bookmark->createData($input);
			return response()->json(['title'=> trans('words.save_eve_save_eve'),'message'=>trans('words.save_eve_save_succ'),'status'=>'1']);
		}else{
			$this->bookmark->removeData($getdata['eid'],$getdata['uid']);
			return response()->json(['title'=>trans('words.save_eve_save_eve'),'message'=>trans('words.save_eve_remove'),'status'=>'0']);
		}
	}


	public function searchdata(Request $request)
	{
		$query = $request->get('term','');
		$start  = Carbon::today();
		$products=Event::where('event_name','LIKE','%'.$query.'%')->whereNull('event_code')->where('event_status',1)->where('ban',0)->where('event_end_datetime','>=', $start )->get();

        $data=array();

        foreach ($products as $product) {
            $data[]=array('id'=>$product->id,'name'=>$product->event_name);
        }
        if(count($data)):
            return response()->json($data);
        else:
            return ['name'=>trans('words.msg.red_found')];
        endif;
	}

	public function snippet($slug)
	{
		$slugUrl = \Crypt::decrypt($slug);
		$data = $this->event->getsingleevent($slugUrl);
		if (!is_null($data)) {
			return view('theme.events.snippet', compact('data', 'slug'));
		} else {
			\App::abort(404, 'Something went to wrong.');
		}
	}

	public function refundsIndex($id)
	{
		$event = $this->event->findData($id);
		$pending = $this->refund->pendingListEventWise($id);
		$accept = $this->refund->acceptListEventWise($id);
		$reject = $this->refund->rejectListEventWise($id);
		return view('theme.events.refund',compact('event','pending','accept','reject'));
	}

	public function eventsGenerate(Request $request){
		$input = $request->all();
        $input['event_link_slug'] = str_slug($input['event_link_slug']);
        $validator = Validator::make($input,[
          'event_link_slug' => 'required|unique:events,event_link_slug,'.$input['id'],
        ]);

        if($validator->fails()){
          return response()->json($validator->errors()->first());
        }

        $getRouteCollection = \Route::getRoutes();
        $url = [];
        foreach ($getRouteCollection as $route) {
            $url = explode('/',$route->uri());
            $data[] = $url[0];
        }
        $data = array_unique($data);
        $reserveurl = array_values($data);

        if(in_array($input['event_link_slug'],$reserveurl)){
          return response()->json('This url is reserved by system.');
        }
        $data = $input['event_link_slug'];
     	$this->event->updateDataCustom($input['id'],$data);
        return response()->json(['success' => 'Custom url generate successfully.','url' => route('custom.slug',$data)]);
	}

	public function getBySlug($slug='') {
		if($slug != ''){
			$getLinkedEvent = event::where('event_link_slug',$slug)->first();
			if($getLinkedEvent != null){
				return redirect()->route('events.details',$getLinkedEvent->event_slug);
			}else{
				$getLinkedOrganization = Organization::where('org_link_slug',$slug)->first();
				if($getLinkedOrganization != null){
					return redirect()->route('org.detail',$getLinkedOrganization->url_slug);
				}else{
					\App::abort(404, 'Event Not Found');
				}
			}
		}
		\App::abort(404, 'Event Not Found');
	}

	public function evenLocation($location){
		$locations = str_replace(', ','%',$location);
		return response()->json(route('events').'?location='.$locations);
	}
}

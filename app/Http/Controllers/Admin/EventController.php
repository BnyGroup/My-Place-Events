<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Event;
use App\EventCategory;
use App\ImageUpload;
use App\EventTicket;
use App\orderPayment;
use App\Booking;
use Hash;
use Mail;
use App\EventTicketsCoupon;
use App\CouponEnum;
use PDF;
use File;
use App\orderTickets;
use DB;

class EventController extends AdminController
{
 	public function __construct() {
    	parent::__construct();
    	$this->event = new Event;
        $this->event_ticket = new EventTicket();
        $this->ticket_booking = new Booking;
        $this->order_payment = new orderPayment;
		$this->orderTickets = new orderTickets;
    }
    public function index() {
        $data = $this->event->geteventwithtickets();
        $recentEvent = $this->event->geteventwithticketsforrecentevent();
        //dd($data, $recentEvent);
    	return view('Admin.Event.eventdisplay',compact('data','recentEvent'));
    }

    public function shows($id)
    {
    	$data = $this->event->getDatas($id);
        $tik = $this->event_ticket->event_tickets($data->event_unique_id);
        return view('Admin.Event.viewevents',compact('data','tik'));
    }
	
	public function export($event_id){

		ini_set('memory_limit', '512M');

		//echo phpinfo(); die("--");
		$eventData = $this->event->eventByUid($event_id);
		//$eventTicket 	= $this->orderTickets->orderTicketsByEvent($event_id);
		//\DB::enableQueryLog();
		$eventTicket = DB::table("event_booking")->select('event_booking.*','event_tickets.ticket_title as TICKE_TITLE','event_tickets.ticket_price_buyer as TICKE_PRICE', 'frontusers.firstname as USER_FNAME', 'frontusers.lastname as USER_LNAME', 'frontusers.email as USER_EMAIL', 'order_tickets.*' ,'order_tickets.created_at as ORDER_ON','order_payment.payment_gateway', 'event_booking.order_status as order_status')
        		->leftjoin('order_payment','order_payment.payment_order_id','=','event_booking.order_id')
        		->leftjoin('events','events.event_unique_id','=','event_booking.event_id')
        		->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
		        ->leftjoin('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
		        ->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
			            ->leftjoin('event_tickets','order_tickets.ot_ticket_id','=','event_tickets.ticket_id')
		//->where('order_payment.payment_state','1')	
		//->where('order_payment.payment_number','!=',null)
		->where('event_booking.order_status','1')
		->where('order_tickets.ot_event_id',$event_id)
        	->orderBy('event_booking.created_at', 'DESC')
		->get();
		//dd(\DB::getQueryLog());
		
		 
		
		
        //dd($eventData,$eventTicket);
		$pdf = PDF::loadView('theme.pdf.list-user-export',compact('eventTicket','eventData'));
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
	

	
    public function ban($id)
    {
        Event::where('id',$id)->update(['ban'=>1,'event_status'=>0]);
        return redirect()->back()->with('error','L\'événement a été désactivé avec succès.');
    }
    public function revoke($id)
    {
        Event::where('id',$id)->update(['ban'=>0,'event_status'=>1]);
        return redirect()->back()->with('success','L\'événement a été activé avec succès.');
    }

    public function first($id)
    {
        Event::where('id',$id)->update(['event_home_status'=>1,'event_status'=>1,'ban'=>0]);
        return redirect()->back()->with('success','L\'événement a bien été ajouté dans first.');
    }

    public function nofirst($id)
    {
        Event::where('id',$id)->update(['event_home_status'=>0]);
        return redirect()->back()->with('success','L\'événement a été supprimé avec succès de first.');
    }

    public function immanquable($id)
    {
        Event::where('id',$id)->update(['event_immanquable'=>1,'event_status'=>1,'ban'=>0]);
        return redirect()->back()->with('success','L`événement a bien été ajouté dans Immanquable.');
    }

    public function noimmanquable($id)
    {
        Event::where('id',$id)->update(['event_immanquable'=>0]);
        return redirect()->back()->with('success','L\'événement a été supprimé avec succès de Immanquable.');
    }	
	
	
	public function uploadBanImm(Request $request){
		$path = 'upload/events/'.gmdate('Y').'/'.gmdate('m');
        if(!is_dir(public_path($path))){
            File::makeDirectory(public_path($path),0777,true);
        }
        if(!empty($request->file('event_img_immanquable'))){
			$input = $request->all();
			$fileImg = array();
            $iinput['event_img_immanquable'] = ImageUpload::upload($path,$request->file('event_img_immanquable'),'event-image');
            //ImageUpload::uploadThumbnail($path,$iinput['event_image'],250,130,'thumb');
            //ImageUpload::uploadThumbnail($path,$iinput['event_image'],800,400,'resize');
            list($width, $height, $type, $attr) = getimagesize($request->file('event_img_immanquable'));
            ImageUpload::uploadThumbnail($path,$iinput['event_img_immanquable'],360,360,'thumb');
            //ImageUpload::uploadThumbnail($path,$iinput['event_image'],1440,960,'resize');
            //ImageUpload::uploadThumbnail($path,$iinput['event_img_immanquable'],$width,$height,'resize');
        	$imgName = save_image($path,$iinput['event_img_immanquable']); print_r($imgName);
			$fileImg['event_img_immanquable'] = $imgName;
			$data = Event::where('event_unique_id',$request->event_unique_id)->update($fileImg); echo"Added-".$request->event_unique_id;
			return redirect()->back()->with('success','La bannière a été enregistrée avec succès dans les Immanquables.');
        }else{
			echo'Error';
		}
		
		return redirect()->back()->with('error','La bannière  n\'a pu être enregistrée dans les Immanquables.');
	}
 
	
    public function accept($id){
        Event::where('id',$id)->update(['event_status'=>1,'ban'=>0]);
        $orderData = $this->event->geteventwithticketswithid($id);
        $mail = array($orderData->email);
        try {
            Mail::send('Admin.mail.event-accepted-notification',['orderData'=>$orderData],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Événement approuvé');
            });
        } catch (\Exception $e) {
            dd($e);
            //return redirect()->route('index');
        }
        return redirect()->back()->with('success','L\'événement a été accepté avec succès.');
    }

    public function deliverylist(){
 	    $deliveryList = $this->ticket_booking->getDataToDelivery();
        $deliveryListPaid = $this->ticket_booking->getDataToDeliveryPaid();
 	    return view('Admin.delivery.delivery-list',compact('deliveryList','deliveryListPaid'));
    }

    public function deliverypaid($order_id){

 	    $bookingdata	= $this->ticket_booking->singleOrder($order_id);

 	    if($bookingdata->gust_id != null)$order_payment['payment_guest_id'] = $bookingdata->gust_id;
        if($bookingdata->gust_id == null)$order_payment['payment_user_id'] = $bookingdata->user_id;
        
        //$order_payment['payment_user_id']		= $bookingdata->user_id;
        $order_payment['payment_order_id']		= $bookingdata->order_id;
        $order_payment['payment_event_id']		= $bookingdata->event_id;
        $order_payment['payment_amount']		= $bookingdata->order_amount;
        // Au cas le montant du billet n'est pas celui payé -- donc en cas de fraude ---

        $order_payment['payment_currency']		= 'FCFA';
        $order_payment['payment_status']		= 'Done';
        $order_payment['payment_gateway']		= 'LIVRAISON';

        // Traitez dans la base de donnée et delivrez le service au client
       // $input_order['order_status']  = '3';

        //$this->ticket_booking->updateData($input_order,$bookingdata->order_id);
        $orderData	= $this->ticket_booking->getOrderData($bookingdata->order_id);
        //dd($orderData);
        $data = $this->order_payment->insertData($order_payment);
        $this->send_message_to_admin_for_new_booking($orderData);
        return redirect()->route('ticket.oderdone', $order_id);
    }

    public function send_message_to_admin_for_new_booking($mailtoadmin){
        /*dd($mailtoadmin);*/
        $orderData = $mailtoadmin;
        //dd($orderData);
        $mail = array('charlene.valmorin@gmail.com','contact@myplace-events.com'/*,'williamscedricdabo@gmail.com'*/,'christelle.abeu@myplace-events.com');
        try {
            Mail::send('Admin.mail.ticket-delivered',['orderData'=>$orderData],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Livraison effectuée');
            });
        } catch (\Exception $e) {
            dd($e);
            //return redirect()->route('index');
        }
    }
    
    public function CouponsList(){
        
        $all_product_coupon = EventTicketsCoupon::all(); 
        $coupon_apply_options = CouponEnum::discountOptions();
        $all_categories = EventCategory::all();

        return view('Admin.coupons.couponslist')->with([
            'all_product_coupon' => $all_product_coupon,
            'coupon_apply_options' => $coupon_apply_options,
            'all_categories' => $all_categories,
        ]);
        
    }
    
    
    public function NewCoupon(Request $request){
        
        
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'code' => 'required|string|max:191|unique:event_tickets_coupons',
            'discount_on' => 'required|string|max:191',
            'category' => 'nullable|numeric',
            'subcategory' => 'nullable|numeric',
            'products' => 'nullable|array',
            'discount' => 'required|string|max:191',
            'discount_type' => 'required|string|max:191',
            'expire_date' => 'required|string|max:191',
            'status' => 'required|string|max:191',
        ]);

        $discount_details = '';
        if ($request->discount_on == 'category') {
            $discount_details = json_encode($request->category);
        } elseif ($request->discount_on == 'subcategory') {
            $discount_details = json_encode($request->subcategory);
        } elseif ($request->discount_on == 'product') {
            $products = sanitizeArray($request->products);
            $discount_details = json_encode($products);
        }

        $product_coupon = EventTicketsCoupon::create([
            'title' => $request->input('title'),
            'code' => $request->input('code'),
            'discount' => $request->input('discount'),
            'discount_type' => $request->input('discount_type'),
            'expire_date' => $request->input('expire_date'),
            'status' => $request->input('status'),
            'discount_on' =>  $request->input('discount_on'),
            'discount_on_details' => $discount_details,
        ]);

        return $product_coupon->id 
            ? back()->with('success','Code Coupon ajouté avec succès !')
            : back()->with('error','Echec ajout de Code Coupon !');
    }   
    
    
    public function CouponUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'code' => 'required|string|max:191',
            'discount_on' => 'required|string|max:191',
            'category' => 'nullable|numeric',
            'subcategory' => 'nullable|numeric',
            'products' => 'nullable|array',
            'discount' => 'required|string|max:191',
            'discount_type' => 'required|string|max:191',
            'expire_date' => 'required|string|max:191',
            'status' => 'required|string|max:191',
        ]);

        $discount_details = '';
        if ($request->discount_on == 'category') {
            $discount_details = json_encode($request->category);
        } elseif ($request->discount_on == 'subcategory') {
            $discount_details = json_encode($request->subcategory);
        } elseif ($request->discount_on == 'product') {
            $products = $request->products;
            $discount_details = json_encode($products);
        }

        $updated = EventTicketsCoupon::find($request->id)->update([
            'title' => $request->input('title'),
            'code' => $request->code,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'expire_date' => $request->expire_date,
            'status' => $request->status,
            'discount_on' =>  $request->input('discount_on'),
            'discount_on_details' => $discount_details,
        ]);

        return $updated
            ? back()->with('success','Code Coupon ajouté avec succès !')
            : back()->with('error','Echec ajout de Code Coupon !');
    }
    
    public function CouponCheck(Request $request)
    {
        return EventTicketsCoupon::where('code', $request->code)->where('status','publish')->count();
    }   
    

    public function ListAllEvents()
    {
		$data = DB::table("event_tickets")->select("events.event_name","event_tickets.ticket_id","event_tickets.id as id")
        ->join('events','events.event_unique_id','=','event_tickets.event_id')
        ->where('event_tickets.ticket_status','1')
        ->where('events.event_status','1')
			->take(200)
        ->orderby('events.event_start_datetime','desc')->get();		
		
        //$all_products = EventTicket::select('id', 'ticket_title','ticket_id')->where('ticket_status', '1')->get();
        return response()->json($data);
    }       
    
    public function CouponDelete(Request $request)
    {
        $id=$request->id;
        $del=EventTicketsCoupon::where('id', $id)->delete();
        return $del ? back()->with('success','Code Coupon supprimé avec succès!')
            : back()->with('error','Echec suppression de Code Coupon !');
    }
    
    public function CouponInfos(Request $request)
    {
        $code=$request->code;
        $all_products = EventTicketsCoupon::select('id', 'discount','discount_type')->where('code', $code)->get();
        return response()->json($all_products);
    }
    
    
    
    
}

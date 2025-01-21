<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Booking;
use App\orderTickets;
use App\EventTicket;
use App\StoreRegularise;
use App\GuestUser;
use App\Frontuser;
use DB;
use Carbon\Carbon;

class OrderController extends AdminController
{
    public function __construct() {
    	parent::__construct();
        $this->booking = new Booking;
        $this->order_tickets = new orderTickets;
        $this->event_ticket = new EventTicket;
        $this->regularises = new StoreRegularise;
    }

	public function index()
    {
    	return view('Admin.booking.index');
    }
	
	public function getPaymentInfo($order_id){
		$records = DB::table("order_payment")->select('order_payment.payment_method as METHOD','order_payment.payment_gateway as GATEWAY','order_payment.payment_number as PAYMENT_NUMBER')
		/*->where('order_payment.payment_state','1')	
		->where('order_payment.payment_number','!=',null)*/
		->where('order_payment.payment_order_id',$order_id)
        ->orderBy('created_at', 'DESC')
		->first();
		return $records;
	}
	
    public function getAllOrders(Request $request)
    {
		
		$draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
		if(empty($rowperpage)) $rowperpage=30;
		if(empty($start)) $start=0;

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
		
		
		// Total records
        $totalRecords = Booking::select('count(*) as allcount')
        //->leftjoin('order_payment','order_payment.payment_order_id','=','event_booking.order_id')
        ->leftjoin('events','events.event_unique_id','=','event_booking.event_id')
        //->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
        //->leftjoin('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
        //->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
		//->where('order_payment.payment_state','1')	
		//->where('order_payment.payment_number','!=',null)			
		->where('event_booking.order_status','1')
		->count();
		
        $totalRecordswithFilter = Booking::select('count(*) as allcount')
        //->leftjoin('order_payment','order_payment.payment_order_id','=','event_booking.order_id')
        ->leftjoin('events','events.event_unique_id','=','event_booking.event_id')
        //->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
        //->leftjoin('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
        //->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
		//->where('order_payment.payment_state','1')	
		//	->where('order_payment.payment_number','!=',null)
		->where('event_booking.order_status','1')
		->where('events.event_name', 'like', '%' .$searchValue . '%')	
		->count();
			
			
			//Employees::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
		//\DB::enableQueryLog();   
    	$records = Booking::select('event_booking.*','events.event_name as enm','event_booking.updated_at as upat')
       // ->leftjoin('order_payment','order_payment.payment_order_id','=','event_booking.order_id')
        ->leftjoin('events','events.event_unique_id','=','event_booking.event_id')
        //->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
        //->leftjoin('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
       // ->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
		//->where('order_payment.payment_state','1')	
		//->where('order_payment.payment_number','!=',null)
		->where('event_booking.order_status','1')
		->where('event_booking.order_amount','>',0)
        ->orderBy('event_booking.created_at', 'DESC')
        ->skip($start)
		->take($rowperpage);
		 
		
		if(!empty($searchValue)){
			$records->where('events.event_name', 'like', '%' .$searchValue . '%')
				->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
				->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
				->orwhere('frontusers.firstname', 'like', '%' .$searchValue . '%')
				->orwhere('frontusers.lastname', 'like', '%' .$searchValue . '%')
				->orwhere('frontusers.email', 'like', '%' .$searchValue . '%')
				->orwhere('guest_user.user_name', 'like', '%' .$searchValue . '%')
				->orwhere('guest_user.guest_email', 'like', '%' .$searchValue . '%');
				/*->leftjoin('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
				->orwhere('order_tickets.ot_f_name', 'like', '%' .$searchValue . '%')
				->orwhere('order_tickets.ot_l_name', 'like', '%' .$searchValue . '%')
				->orwhere('order_tickets.ot_email', 'like', '%' .$searchValue . '%')
				->orwhere('order_tickets.ot_cellphone', 'like', '%' .$searchValue . '%');*/
		}
		
		$recs=$records->get(); 
		//dd(\DB::getQueryLog());
		
		
		$guestInfo= new GuestUser;
		$frontusers=new Frontuser;
			
		$data_arr = array();
		$key="1";
		
        foreach($recs as $record){
           $id = $record->id;
           $order_id = $record->order_id;
           $event_id = $record->event_id;
           $enm = $record->enm;
           $gust_id = $record->gust_id;
           $user_id = $record->user_id;
           //$lastname = $record->lastname;
		   $pp=$this->getPaymentInfo($order_id);
		   if(!empty($pp)){	
			   $GATEWAY = ($pp->GATEWAY != null)?$pp->GATEWAY:"-";
			   $METHOD = ($pp->METHOD != null)?$pp->METHOD:"-";
			   $PAYMENT_NUMBER = ($pp->PAYMENT_NUMBER != null)?$pp->PAYMENT_NUMBER:"-";
		   }else{
			   $GATEWAY = "-";
			   $METHOD = "-";
			   $PAYMENT_NUMBER ="-";
		   }	
			
           $updated_at = $record->upat;
		   $dateUp = date_create($updated_at); 	
           $order_tickets = $record->order_tickets;
			
           $order_amount = $record->order_amount;           
		   $order_status = $record->order_status;           
		   //$delivred_status = $record->delivred_status;           
		   $event_id = $record->event_id;	
			$createinvoice = $record->createinvoice;	
			
			if($gust_id != null){
				if(!empty($gust_id)){
					$g=$guestInfo->findData($gust_id);
					$Username=$g->user_name;
					
					$gx=$g->guest_email .'<br>'. $g->cellphone;
					if($GATEWAY == 'CINETPAY'){
						$gx.='<br>'.$METHOD.' : '.$PAYMENT_NUMBER;
					}
				}else{
					$Username="-"; $gx="";
				}
			 }
			else{ 
				if(!empty($user_id)){
					$f=$frontusers->findData($user_id);										 
					$Username=$f->firstname.' '.$f->lastname;
					$gx=$f->email.' ('.$f->cellphone.')';
					if($GATEWAY == 'CINETPAY'){
						$gx.='<br> '.$METHOD.' : '.$PAYMENT_NUMBER;
					}					
				}else{
					$Username="-"; $gx="";
				}
			}
			
			if($order_amount == 0.00){
				$stusP="LIBRE";
			}else{
				$stusP="$order_amount";
			}
			
			if($GATEWAY == 'CINETPAY'){
				$gtway=$METHOD.' / '.$GATEWAY;
			}elseif($GATEWAY == 'LIVRAISON'){
				$gtway=$GATEWAY;
			}elseif($GATEWAY == "PAYSTACK"){
				$gtway='CARTE VISA';
			}else{
				$gtway='Portefeuille Virtuel / WALLET';
			}
			
			if ($createinvoice){
				$cInvoic='<span class="btn btn-info btn-flat label-success">OUI</span>';
			}else{
				$cInvoic='<span class="btn btn-info btn-flat label-danger">NON</span>';
			}
			$payStatus=paymentstatus2($order_status);
			$action='<a href="javascript:void(0)" class="viewdetails btn btn-info btn-flat" data-order="'.$order_id.'">Vue<i class="fa fa-eye"></i></a>'; 
			
			if($order_status == 1){
				if($order_status != 4){
					
					   $data_arr[] = array(
						   "key" => $key,
						   "order_id" => $order_id,
						   "event_id" => $event_id,
						   "eventname" => $enm,
						   "Username" => $Username,
						   "gateway" => $gx,
						   "updated_at" => date_format($dateUp,'d-m-y h:i A'),
						   "order_tickets" => $order_tickets,
						   "stusP" => $stusP,
						   "gtway" => $gtway,
						   "paymentstatus" => $payStatus,
						   "createinvoice" => $cInvoic,
						   "action" => $action,						   
					   );
					
				}
			}
			
			$key++;
		}
		
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        return response()->json($response); 
		 		
    	//return view('Admin.booking.index',compact('data'));
    }
	
	
	public function paiementgratuit(){
    	return view('Admin.booking.paiement-gratuit');		
	}
	
		
    public function getFreeOrders(Request $request)
    {
		  		
		$draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
		if(empty($rowperpage)) $rowperpage=30;
		if(empty($start)) $start=0;

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
		
		
		// Total records
        $totalRecords = Booking::select('count(*) as allcount')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
           // ->join('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
            ->where('event_booking.order_amount','<=',0)
			->where('event_booking.order_status','1')
            ->orderBy('event_booking.id','desc')
            ->count();
		
        $totalRecordswithFilter = Booking::select('count(*) as allcount')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
           // ->join('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
            ->where('event_booking.order_amount','<=',0)
			->where('events.event_name', 'like', '%' .$searchValue . '%')	
			->where('event_booking.order_status','1')
            ->orderBy('event_booking.id','desc')
            ->count();
 		 
        // Fetch records //
		 
    	$records = Booking::select('event_booking.*','events.event_name as ename','events.created_at as EVENT_CREATED_AT','order_tickets.ot_cellphone as ORDER_TICKETS_CELLPHONE','event_booking.updated_at as upat')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->join('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
            ->where('event_booking.order_amount','<=',0)
			->where('event_booking.order_status','1')
            ->orderBy('event_booking.id','desc')
			->orderBy('created_at', 'DESC')
			->skip($start)
			->take($rowperpage);
		
		if(!empty($searchValue)){
			$records->where('events.event_name', 'like', '%' .$searchValue . '%');
				/*->orwhere('order_tickets.ot_f_name', 'like', '%' .$searchValue . '%')
				->orwhere('order_tickets.ot_l_name', 'like', '%' .$searchValue . '%')
				->orwhere('order_tickets.ot_email', 'like', '%' .$searchValue . '%')
				->orwhere('order_tickets.ot_cellphone', 'like', '%' .$searchValue . '%');*/
		}
		
		$recs=$records->get();
		 
		$guestInfo= new GuestUser;
		$frontusers=new Frontuser;
			
		$data_arr = array();
		$key="1";
		
        foreach($recs as $record){
           $id = $record->id;
           $order_id = $record->order_id;
           $event_id = $record->event_id;
           $enm = $record->ename;
           $gust_id = $record->gust_id;
           $user_id = $record->user_id;
           //$lastname = $record->lastname;
           $GATEWAY = $record->GATEWAY;
           $METHOD = $record->METHOD;
           $PAYMENT_NUMBER = $record->PAYMENT_NUMBER;
		   $ORDER_TICKETS_CELLPHONE = $record->ORDER_TICKETS_CELLPHONE;	
			
           $updated_at = $record->upat;
		   $dateUp = date_create($updated_at); 	
           $order_tickets = $record->order_tickets;
			
           $order_amount = $record->order_amount;           
		   $order_status = $record->order_status;           
		   //$delivred_status = $record->delivred_status;           
  			
			if($gust_id != null){
				$g=$guestInfo->findData($gust_id);
				$Username=$g->user_name;
				$cellphone  = is_null($g->cellphone) ? $ORDER_TICKETS_CELLPHONE : $g->cellphone;
				$uContact=$g->guest_email.'<br/>'.$cellphone;
				
			 }else{ 
				$f=$frontusers->findData($user_id);										 
				$Username=$f->firstname.' '.$f->lastname;
				$cellphone = is_null($f->cellphone) ? $ORDER_TICKETS_CELLPHONE : $f->cellphone;
				$uContact=$f->email.'<br/>'.$cellphone;
			}
			
			if($gust_id != null){
				$gx=$g->guest_email .'<br>'. $g->cellphone;
					if($GATEWAY == 'CINETPAY'){
						$gx.='<br>'.$METHOD.' : '.$PAYMENT_NUMBER;
					}
				 
			}else{
				 
					$gx=$f->email.' ('.$f->cellphone.')';
					if($GATEWAY == 'CINETPAY'){
						$gx.='<br> '.$METHOD.' : '.$PAYMENT_NUMBER;
					}				 
			}
			
			if($order_amount == 0.00){
				$stusP="LIBRE";
			}else{
				$stusP="$order_amount";
			}
 
			$payStatus=paymentstatus2($order_status);
			$action='<button href="" type="button" class="btn btn-info btn-flat viewdetails" data-order="'.$order_id.'" data-toggle="modal" data-target="#'.$order_id.'-modal-default">Vue<i class="fa fa-eye"></i></button>'; 
			
			if($order_amount >= 0){
 					
					   $data_arr[] = array(
						   "key" => $key,
						   "order_id" => $order_id,
						   "event_id" => $event_id,
						   "eventname" => $enm,
						   "Username" => $Username,
						   "contact" => $uContact,
						   "updated_at" => date_format($dateUp,'d-m-y h:i A'),
						   "order_tickets" => $order_tickets,
						   "stusP" => $stusP,
						   "paymentstatus" => $payStatus,
						   "action" => $action,						   
					   );
 				 
			}
			
			$key++;
		}
		
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        return response()->json($response); 
		 		
    	//return view('Admin.booking.index',compact('data'));
    }	
	
 	
	
	public function paiementechoue(){
    	//$fixedDate = Carbon::create(2020, 11, 01, 0, 0, 0, 'GMT');
    	return view('Admin.booking.paiement-echoue');		
	}
 	
			
    public function getFailedOrders(Request $request)
    {
		  		
		$draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
		if(empty($rowperpage)) $rowperpage=30;
		if(empty($start)) $start=0;

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
		
		
		// Total records
        $totalRecords = Booking::select('count(*) as allcount')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->join('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
			->where('order_tickets.delivred_status','0')
			->where('event_booking.order_amount','>',0)
			->where('event_booking.order_status','!=',4)
            ->orderBy('event_booking.id','desc')
            ->count();
		
        $totalRecordswithFilter = Booking::select('count(*) as allcount')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->join('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
			->where('order_tickets.delivred_status','0')
			->where('event_booking.order_amount','>',0)
			->where('event_booking.order_status','!=',4)
			->where('events.event_name', 'like', '%' .$searchValue . '%')				
            ->orderBy('event_booking.id','desc')
            ->count();
 		 
        // Fetch records //
		 
    	$records = Booking::select('event_booking.*','events.event_name as ename','events.created_at as EVENT_CREATED_AT','order_tickets.delivred_status as delivred_status','order_tickets.ot_cellphone as ORDER_TICKETS_CELLPHONE','event_booking.updated_at as upat')
            ->join('events','events.event_unique_id','=','event_booking.event_id')
            ->join('order_tickets','order_tickets.ot_order_id','=','event_booking.order_id')
			->where('order_tickets.delivred_status','0')
			->where('event_booking.order_amount','>',0)
			->where('event_booking.order_status','!=',4)            
			//->orderBy('event_booking.id','desc')
			->orderBy('created_at', 'DESC')
			->skip($start)
			->take($rowperpage);
		
		if(!empty($searchValue)){
			$records->where('events.event_name', 'like', '%' .$searchValue . '%')/*
				->orwhere('order_tickets.ot_f_name', 'like', '%' .$searchValue . '%')
				->orwhere('order_tickets.ot_l_name', 'like', '%' .$searchValue . '%')
				->orwhere('order_tickets.ot_email', 'like', '%' .$searchValue . '%')
				->orwhere('order_tickets.ot_cellphone', 'like', '%' .$searchValue . '%')*/;
		}
		
		$recs=$records->get();
		 
		$guestInfo= new GuestUser;
		$frontusers=new Frontuser;
			
		$data_arr = array();
		$key="1";
		
        foreach($recs as $record){
           $id = $record->id;
           $order_id = $record->order_id;
           $event_id = $record->event_id;
           $enm = $record->ename;
           $gust_id = $record->gust_id;
           $user_id = $record->user_id;
           //$lastname = $record->lastname;
           $GATEWAY = $record->GATEWAY;
           $METHOD = $record->METHOD;
           $PAYMENT_NUMBER = $record->PAYMENT_NUMBER;
		   $ORDER_TICKETS_CELLPHONE = $record->ORDER_TICKETS_CELLPHONE;	
			
           $updated_at = $record->upat;
		   $dateUp = date_create($updated_at); 	
           $order_tickets = $record->order_tickets;
			
           $order_amount = $record->order_amount;           
		   $order_status = $record->order_status;           
		   //$delivred_status = $record->delivred_status;           
  			
			if($gust_id != null){
				$g=$guestInfo->findData($gust_id);
				$Username=$g->user_name;
				$cellphone  = is_null($g->cellphone) ? $ORDER_TICKETS_CELLPHONE : $g->cellphone;
				$uContact=$g->guest_email.'<br/>'.$cellphone;
				
			 }else{ 
				$f=$frontusers->findData($user_id);										 
				$Username=$f->firstname.' '.$f->lastname;
				$cellphone = is_null($f->cellphone) ? $ORDER_TICKETS_CELLPHONE : $f->cellphone;
				$uContact=$f->email.'<br/>'.$cellphone;
			}
			
			if($gust_id != null){
				$gx=$g->guest_email .'<br>'. $g->cellphone;
					if($GATEWAY == 'CINETPAY'){
						$gx.='<br>'.$METHOD.' : '.$PAYMENT_NUMBER;
					}
				 
			}else{
				 
					$gx=$f->email.' ('.$f->cellphone.')';
					if($GATEWAY == 'CINETPAY'){
						$gx.='<br> '.$METHOD.' : '.$PAYMENT_NUMBER;
					}				 
			}
			
			if($order_amount == 0.00){
				$stusP="LIBRE";
			}else{
				$stusP="$order_amount";
			}
 
			$payStatus=paymentstatus2($order_status);
			$action='<button href="" type="button" class="btn btn-info btn-flat viewdetails" data-order="'.$order_id.'" data-toggle="modal" data-target="#'.$order_id.'-modal-default">Vue<i class="fa fa-eye"></i></button>'; 
			
			if($order_amount >= 0){
 					
					   $data_arr[] = array(
						   "key" => $key,
						   "order_id" => $order_id,
						   "event_id" => $event_id,
						   "eventname" => $enm,
						   "Username" => $Username,
						   "contact" => $uContact,
						   "updated_at" => date_format($dateUp,'d-m-y h:i A'),
						   "order_tickets" => $order_tickets,
						   "stusP" => $stusP,
						   "paymentstatus" => $payStatus,
						   "action" => $action,						   
					   );
 				 
			}
			
			$key++;
		}
		
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        return response()->json($response); 
		 		
    	//return view('Admin.booking.index',compact('data'));
    }	
	
	
	
	
public function ViewOrderDetails(Request $request){
	
 $val = DB::table("order_tickets")->select('event_booking.*','events.event_name as enm','events.event_start_datetime','events.event_end_datetime','event_booking.updated_at as upat','order_payment.payment_method as METHOD','order_payment.payment_gateway as GATEWAY','order_payment.payment_number as PAYMENT_NUMBER',"frontusers.firstname as fnm","frontusers.lastname as lnm","frontusers.email as email")
        ->leftjoin('order_payment','order_payment.payment_order_id','=','order_tickets.ot_order_id')
       	->leftjoin('event_booking','event_booking.order_id','=','order_tickets.ot_order_id')
        ->leftjoin('events','events.event_unique_id','=','order_tickets.ot_event_id')
        ->leftjoin('frontusers','frontusers.id','=','event_booking.user_id')
        ->leftjoin('guest_user','guest_user.guest_id','=','event_booking.gust_id')
		->where('order_tickets.ot_order_id', $request->orderid)
		->first();		 
$guestInfo= new GuestUser;		 
?>
		<table class="table table-bordered table-striped">
		  <tbody>
			<tr class="text-center">
			  <td colspan="2"><h3><?php echo $val->enm; ?></h3></td>
			</tr>
			<tr class="text-center">
			  <td colspan="2">Commande #<?php echo $val->order_id." du ".Carbon::parse($val->upat)->format('d F Y'); ?>
				  <br>
				  <?php  
					$startdate  = Carbon::parse($val->event_start_datetime)->format('l, F j, Y');
					$enddate  = Carbon::parse($val->event_end_datetime)->format('l, F j, Y');
					$starttime  = Carbon::parse($val->event_start_datetime)->format('h:i A');
					$endtime  = Carbon::parse($val->event_end_datetime)->format('h:i A');

				  if($startdate == $enddate){
					echo $startdate."<br>";
					echo $starttime ." à ".$endtime;
				  }else{
					echo $startdate .",". $starttime." To ".$enddate .",". $endtime;
				  }
				 ?>
			  </td>
			</tr>
		  </tbody>  
		</table>

            <?php 
              $tickets  = unserialize($val->order_t_id);
              $ttitle   = unserialize($val->order_t_title);
              $tqty   = unserialize($val->order_t_qty);
              $tprice   = unserialize($val->order_t_price);
              $tfees    = unserialize($val->order_t_fees);
				
			  if(!empty($val->fnm) || !empty($val->lnm)){
				  $name=$val->fnm." ".$val->lnm;
			  }else if(!empty($val->gust_id)){
				  $g=$guestInfo->findData($val->gust_id);
				  $name=$g->user_name;
			  }
            ?>
            <span class="tickets-pays text-left"><b>Tickets</b></span>
            <span class="tickets-pays text-right pull-right"><p><b>Acheteur de billets - </b> <?php echo $name; ?></p></span>
              <table class="table table-bordered table-striped">
                <thead class="text-center">
                  <th class="text-center">Nom du Ticket</th>
                  <th class="text-center">Prix du Tickte</th>
                  <th class="text-center">Qté de Tickets</th>
                  <th class="text-center">Sous Total de Ticket</th>
                </thead>
                <tbody>
				<?php	
                 foreach($tickets as $key => $ticket){ ?>
                    <tr class="text-center">
                      <td><?php echo $ttitle[$key]; ?></td>
                      <td>
                        <?php echo (floatval($tprice[$key]) == 0 )?'Gratuit': floatval($tprice[$key]) ; ?>
                    </td>
                      <td><?php echo $tqty[$key]; ?></td>
                      <td><?php echo (floatval($tprice[$key]) == 0 )?'Gratuit': (floatval($tprice[$key]) ) * intval($tqty[$key]); ?></td>
                    </tr>
                <?php } ?>          
                <tr>
                  <th colspan="3" class="text-right">Commande Totale</th>
                  <th class="text-center"><?php echo $val->order_amount; ?></th>
                </tr>
                  </tbody>
              </table>

<?php
	 }
	
	
	
	public function bookingsearch(Request $request){
		
	}
	
    public function regularise($element)
    {
        $order = explode('-',$element);
        if($order[0] == '') return redirect()->back();
        array_pop($order);
        $storeOrderId = [];
        foreach( $order as $key => $number){
            if(in_array($number, $storeOrderId)){
                continue;
            }else{
                //dd($number);
                // recuperer les information du tickets
                $orderTicketInfo_all = orderTickets::where('ot_order_id',$number)->get();
                $eventBooking = Booking::where('order_id', $number)->first();
                $qty = $eventBooking->order_tickets;

                //Convertir les données en texte
                $orderTicketInfo_encode  = json_encode($orderTicketInfo_all);
                $eventBooking_encode = json_encode($eventBooking);

                //save on store regularise database
                //$store = $this->regularises->insertData(['order_id' => $number, 'order_tickets' => $orderTicketInfo_encode, 'event_booking' => $eventBooking_encode]);
                $orderTicketInfo_first = orderTickets::where('ot_order_id',$number)->first();
                $this->event_ticket->incres_ticket_qty($orderTicketInfo_first->ot_ticket_id, $qty);
                //$this->order_tickets->deleteOrder($number);
                //$this->booking->deleteBooking($number);

                //inserer order_id dans courant dans un tableau
                $storeOrderId[$key] = $number;
            }

        }
        unset($storeOrderId);
        return redirect()->back();
    }
}

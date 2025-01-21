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
use App\Gadget;
/*use Corcel\Model\Post;*/
use App\Bookmark;
use App\Booking;
use Zebra_Pagination;
use RealRashid\SweetAlert\Facades\Alert;
 
use DB;
use App\EventTicketsCoupon;
use App\CouponEnum;
use Illuminate\Support\Facades\Log;

class EventController extends FrontController
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
/* INDEX FUNCTION - DISPLAY LIST OF EVENTS ======== */
/* ================================================ */
 	public function index($url=null){ 

 		     setMetaData('Event List', '', 'create event,event,new event', for_logo());
  
		     //$post = Post::find(30);
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

		  // $categories	= $this->event_category->childs();
		  // $child = $this->event_category->getCategorylist();
		  $categories	= $this->event_category->get_Category_event();
		  $catdata = [];
		  if (isset($_GET['cat'])) {
			  $catdata = $this->event_category->findCategories($_GET['cat']);
		  } 
          
          //$events	= $this->event->geteventwithticketssearch($pageUrl[0], $pageUrl[1], $pageUrl_pric[0],$catdata);
		  $pays = PaysList::orderBy('nom_pays','asc')->get();

		  //$events	= $this->event->geteventwithticketssearch($pageUrl[0], $pageUrl[1], $pageUrl_pric[0],$catdata);

            $now  = Carbon::today();
            $data = DB::table("events")->select("events.*","frontusers.firstname as fnm","frontusers.lastname as lnm","frontusers.email as email",
            DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                    WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                    GROUP BY event_tickets.event_id) as event_min_price"),
            DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                    WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                    GROUP BY event_tickets.event_id) as event_max_price"))
            ->join('frontusers','frontusers.id','=','events.event_create_by')
            ->where('event_status','1')
	        ->where('event_end_datetime','>=',$now)
            //->orWhere('event_status','0')
            ->orderby('events.event_start_datetime','desc');

            if (isset($_GET['fuser']) && !empty($_GET['fuser'])) {
                $datas = explode(' ', $_GET['fuser']);
                $data = $data->where('frontusers.firstname','LIKE','%'.$datas[0].'%');
                $data = $data->where('frontusers.lastname','LIKE','%'.$datas[1].'%');
            }
            if (isset($_GET['duration']) && !empty($_GET['duration'])) {
            if ($_GET['duration'] == 'Current') {
                $datas      = Carbon::now();
                $data = $data->where('event_end_datetime','<=',$datas);
                $data = $data->where('event_end_datetime','>=',$datas);
            }
            if ($_GET['duration'] == 'Upcoming') {
                $datas = Carbon::now();
                $data = $data->where('event_end_datetime','>=',$datas);
            }
            }
            if (isset($_GET['status']) && !empty($_GET['status']) ) {
                if ($_GET['status'] == 'Publish') {
                    $data = $data->where('event_status','LIKE','%'.'1'.'%');
                }
                if ($_GET['status'] == 'Draft') {
                    $data = $data->where('event_status','LIKE','%'.'0'.'%');
                }
                if ($_GET['status'] == 'Ban') {
                    $data = $data->where('events.ban','LIKE','%'.'1'.'%');
                }
            }
            $events=$data->paginate(15);

		  return view('theme.events.event-list-remake',compact('categories','events','pageActive','pays'));
 	}

    public function index_by_cat($url=null) {

        setMetaData('Event List', '', 'create event,event,new event', for_logo());

        $currentPageURL = URL()->current();
        $pageArray 		= explode('/', $currentPageURL);
        $pageActive 	= isset($pageArray[5]) ? $pageArray[5] : '';
        /*dd($pageArray[5]);*/
        $input=array();
        $date1 = $date2 = '';
        $pays = PaysList::orderBy('nom_pays','asc')->get();
        $categories	= $this->event_category->get_Category_event();
        //dd($pageArray[5]);
        $events	= $this->event->geteventlistbynewsearch("","", $pageArray[5],"","","");
        return view('theme.events.event-list-remake',compact('categories','events','pageActive','pays','date1','date2'));
//        if(isset($pageActive) &&  $pageActive != '' ){
//            $pageUrl = explode("--", $pageActive);
//        }else{
//            $pageUrl = explode("--", "cat--date--all");
//        }
//        $pageUrl_pric = explode('?', $pageUrl[2]) ;
//
//        // $categories	= $this->event_category->childs();
//        // $child = $this->event_category->getCategorylist();
//        $categories	= $this->event_category->get_Category_event();
//        $catdata = [];
//        if (isset($_GET['cat'])) {
//            $catdata = $this->event_category->findCategories($_GET['cat']);
//        }
//        $events	= $this->event->geteventwithticketssearch($pageUrl[0], $pageUrl[1], $pageUrl_pric[0],$catdata);
//        $pays = PaysList::orderBy('nom_pays','asc')->get();
//        return view('theme.events.event-list-remake',compact('categories','events','pageActive','pays','post'));

    }

    public function index_by_country($url=null) {

        setMetaData('Event List', '', 'create event,event,new event', for_logo());

        $currentPageURL = URL()->current();
        $pageArray 		= explode('/', $currentPageURL);
        $pageActive 	= isset($pageArray[5]) ? $pageArray[5] : '';
        /*dd($pageArray[5]);*/
        $input=array();
        $date1 = $date2 = '';
        $pays = PaysList::orderBy('nom_pays','asc')->get();
        $categories	= $this->event_category->get_Category_event();
        //dd($pageArray[5]);
        $events	= $this->event->geteventlistbynewsearch("",$pageArray[5], "","","","");
        return view('theme.events.event-list-remake',compact('categories','events','pageActive','pays','date1','date2'));
    }


    /* ================================================ */
    /* INDEX 2 ========================== */
    /* ================================================ */

    public function SearchEvent(Request $request) {
        $input = $request->all();
        setMetaData('Event List', '', 'create event,event,new event', for_logo());
 
        if(isset($_POST['cat']) && !empty($_POST['cat'])){
            $catByGetMethode = $_POST['cat'];
        }
		
		$currentPageURL = URL()->current();
		$pageArray = explode('/', $currentPageURL);
		$pageActive = isset($pageArray[6]) ? $pageArray[6] : '';
		//dd($pageArray[4]);
		if(isset($pageActive) &&  $pageActive != '' ){
			  $pageUrl = explode("--", $pageActive);
		}else{
			  $pageUrl = explode("--", "cat--date--all");
		}
		
		$pageUrl_pric = explode('?', $pageUrl[2]);		
 		
		$categories = $this->event_category->get_Category_event();
         
        $date1='';
        $date2='';
        if(!empty($input['start_date']) && !empty($input['end_date'])){
            $this->validate($request,[
                'start_date' => 'required|date_format:d/m/Y',
                'end_date' => 'required|date_format:d/m/Y'
                ]);

            $dateD = $input['start_date']." 00:00:00";
            $dateF = $input['end_date']." 00:00:00";

            $dateD = Carbon::createFromFormat('d/m/Y H:i:s', $dateD)->format('Y-m-d H:i:s');
            $dateF = Carbon::createFromFormat('d/m/Y H:i:s', $dateF)->format('Y-m-d H:i:s');

            $date1= $dateD;
            $date2= $dateF;

            $events	= $this->event->geteventlistbynewsearch($input['e_name'], $input['event_country'], $input['event_category'], $input['date'], $date1, $date2);
			
        
		}elseif(empty($input['start_date']) && !empty($input['end_date'])){
            $this->validate($request,[
                'end_date'			=> 'required|date_format:d/m/Y',
            ]);

            $dateD = Carbon::today();
            $dateF = $input['end_date']." 00:00:00";

            $dateD = Carbon::createFromFormat('Y-m-d H:i:s', $dateD)->format('Y-m-d H:i:s');
            $dateF = Carbon::createFromFormat('d/m/Y H:i:s', $dateF)->format('Y-m-d H:i:s');

            $date1= $dateD;
            $date2= $dateF;

            $events = $this->event->geteventlistbynewsearch($input['e_name'], $input['event_country'], $input['event_category'], $input['date'], $date1, $date2);
        
		
		}elseif(!empty($input['start_date']) && empty($input['end_date'])){
            $this->validate($request,[
                'start_date' => 'required|date_format:d/m/Y',
            ]);

            $dateD = $input['start_date']." 00:00:00";
            $dateF = $input['start_date']." 23:59:59";

            $dateD = Carbon::createFromFormat('d/m/Y H:i:s', $dateD)->format('Y-m-d H:i:s');
            $dateF = Carbon::createFromFormat('d/m/Y H:i:s', $dateF)->format('Y-m-d H:i:s');

            $date1= $dateD;
            $date2= $dateF;
            $events = $this->event->geteventlistbynewsearch($input['e_name'], $input['event_country'], $input['event_category'], $input['date'], $date1, $date2);
        }
        $catdata = [];
        if (isset($_POST['cat'])) {
            $catdata = $this->event_category->findCategories($_POST['cat']);
        }
		
		$events	= $this->event->geteventlistbynewsearch($input['e_name'], $input['event_country'], $input['event_category'], $input['date'], $date1, $date2);

        $pays = PaysList::orderBy('nom_pays','asc')->get();
 

        return view('theme.events.event-list-remake',compact('categories','events','pageActive','pays','date1', 'date2'));
    }


    public function eventsbycats() {
        $xx=""; $cat="";
        if(isset($_GET['page'])){
            $offset=($_GET['page']*15);
        }else{
             $offset=0;
        }
        
        if(isset($_GET['cat'])){
            $cat=$_GET['cat']; 
            if($_GET['cat']=='all') $cat='';
        }
        
        $start  = Carbon::today();
        $dataInfos = DB::table("events")->select("events.*","frontusers.firstname as fnm","frontusers.lastname as lnm","frontusers.email as email",
            DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                    WHERE event_tickets.event_id = events.event_unique_id
                    GROUP BY event_tickets.event_id) as event_min_price"),
            DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                    WHERE event_tickets.event_id = events.event_unique_id
                    GROUP BY event_tickets.event_id) as event_max_price"))
            ->join('frontusers','frontusers.id','=','events.event_create_by')
            ->where('event_status','1')
	    ->where('event_end_datetime','>=',$start)
            ->orderby('events.event_start_datetime','desc') 
            ->offset($offset)->limit(15)->get();
            //$dataInfos->paginate(15);
        
        if ($cat != '') {  
            $catdata = DB::table('event_category')->where('event_category.category_name', $cat)->get();
            $ids = array();
            foreach ($catdata as $key => $value) {
                $ids[] = $value->id;
            }
            //dd($ids);
            $cids = array_push($ids, $cat);            
            
            $dataInfos = DB::table("events")->select("events.*","frontusers.firstname as fnm","frontusers.lastname as lnm","frontusers.email as email",
            DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                    WHERE event_tickets.event_id = events.event_unique_id
                    GROUP BY event_tickets.event_id) as event_min_price"),
            DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                    WHERE event_tickets.event_id = events.event_unique_id
                    GROUP BY event_tickets.event_id) as event_max_price"))
            ->join('frontusers','frontusers.id','=','events.event_create_by')
            ->where('event_status','1')
            ->whereIn('event_category', $ids)
	    ->where('event_end_datetime','>=',$start)
            ->orderby('events.event_start_datetime','desc') 
            ->offset($offset)->limit(15)->get();
        }
        
        foreach($dataInfos as $data){
            if($data->event_status == 1){
               
$xx.='<div class="col-lg-4 col-md-6 col-sm-12 hover " style="" >
           
    <div class="box-icon pull-right share-listing">
        <a href="javascript:void()" data-toggle="tooltip"
           data-original-title="Partager"
           data-placement="right" class="event-share"
           data-url="'.route('events.details',$data->event_slug).'"
           data-name="'.$data->event_name.'" data-loca="'.$data->event_location.'">
            <i class="fas fa-share"></i>
        </a>
    </div>';   
    
  $xx.='<div class="box-icon pull-right like-listing">';
        if(auth()->guard('frontuser')->check()){
            $userid = auth()->guard('frontuser')->user()->id;
        }else{
            $userid = '';
        }
                
    $xx.='<a href="javascript:void(0)" data-toggle="tooltip"
           data-original-title="Enregistrer dans les favoris"
           data-placement="right" id="save-event" class="save-event" data-user="'.$userid.'"
           data-event="'.$data->event_unique_id.'" data-mark="0">';
                
            if(is_null(getbookmark($data->event_unique_id, $userid)))
                $xx.='<i class="far fa-heart"></i>';
            else
                $xx.='<i class="fas fa-heart"></i>';
            
        $xx.='</a>
        <!-- <i class="fa fa-bookmark-o"><a href="#"></a></i> -->
    </div>';
    
   $xx.='<div class="box" style="position: relative;">

        
       <a href="'.route('events.details',$data->event_slug).'"><div class="bunique" style="background-image: url(\''.getImage($data->event_image, 'thumb').'\'); "></div></a>

        <div class="box-content card__padding">
            <div class="innercardbox">
                
                <div class="left_innerbox">
                    <h4 class="card-title"><a href="'.route('events.details',$data->event_slug).'">'.$data->event_name.'</a></h4>
                    <div class="prix">
                        <a href="'.route('events.details',$data->event_slug).'" class=""><span class="">';
                                if($data->event_min_price == 0)
                                  $xx.='GRATUIT';
                                else
                                     $xx.=number_format($data->event_min_price, 0, "."," ").' '.use_currency()->symbol;
                               
                                if($data->event_min_price != $data->event_max_price)
                                    $xx.='- '.number_format($data->event_max_price, 0, "."," ").' '.use_currency()->symbol;
                                
                        $xx.='</span></a>
                    </div> ';
                   $xx.=' <div class="card__location">
                        <div class="card__location-content">
                            <i class="fas fa-map-marker-alt primary-color"></i>
                            <a href="" rel="tag"
                               class="third-color bold"> '.$data->event_location.'</a>
                        </div>
                    </div>
                </div>';
                
               $xx.=' <div class="right_innerbox">';
                
                    $startdate 	= ucwords(Date::parse($data->event_start_datetime)->format('l j F Y'));
                    $enddate 	= ucwords(Date::parse($data->event_end_datetime)->format('l j F Y'));
                    $starttime	= Carbon::parse($data->event_start_datetime)->format('H:i');
                    $endtime	= Carbon::parse($data->event_end_datetime)->format('H:i');
                                    
                    $xx.='<div class="badge category col-sm-4 col-sm-offset-1" style="cursor: default">
                          <span class="">';
                              $xx.=Event::getCategoryById($data->event_category);
                           $xx.='
                          </span>
                    </div>'; 
                    $xx.='<div class="datexp">';
                          if($startdate == $enddate){
                            $xx.='<div class="date-times bold third-color">
                                       <table cellpadding="0" cellspacing="0" border="0">';                                   
                                         
                                            $stdate=explode(" ",$startdate);
                                            $nbstdate=count($stdate);
                
                                            for($x=0;$x<$nbstdate;$x++){
                                                if($x==1){ $tpc='class="secdatexp"'; }else{ $tpc=''; } 
                                                $xx.='<tr '.$tpc.' ><td style="text-align: center">'.$stdate[$x].'</td></tr>';
                                            }                                        

                                 $xx.='</table>   
                            </div>';
                          }else{
                              $xx.='<div class="both" style="float: left; width: 43%">
                                <table cellpadding="0" cellspacing="0" border="0">';                                   
                                     
                                        $stdate=explode(" ",$startdate);
                                        $nbstdate=count($stdate);
                                        for($xy=0;$xy<$nbstdate;$xy++){
                                            if($xy==1){ $tpc='class="secdatexp"'; }else{ $tpc=''; } 
                                     
                                        $xx.='<tr '.$tpc.'><td>'.$stdate[$xy].'</td></tr>';
                                        }                                      
                                    
                               $xx.=' </table>                                
                            </div>    
                            <div class="sepa"><span class="separator">-</span></div>
                            <div class="both" style="float: right; width: 43%">
                                
                                 <table cellpadding="0" cellspacing="0" border="0"> ';                                  
                                     
                                        $edate=explode(" ",$enddate);
                                        $nbedate=count($edate);
                                        for($y=0;$y<$nbedate;$y++){
                                            if($y==1){ $tps='class="secdatexp"'; }else{ $tps=''; } 
                                            $xx.='<tr '.$tps.' ><td style="text-align: left">'.$edate[$y].'</td></tr>';
                                       }                                      
                                    
                              $xx.='</table>   
                                
                            </div>';

                        }                    
                   $xx.='</div>
                    
                </div>  
                
           </div>
            <div style="clear:both;"></div>
        </div>
    </div>

</div>';               
               
               
            }
        }
        if($_GET['cat']!='all'){ if($xx==null) $xx=0; }
        return $xx;
    }


    public function eventsbycatsfilter() {
        $xx=""; $cat="";
        
        if(isset($_GET['cat'])){
            $cat=$_GET['cat']; 
            //if($_GET['cat']=='all') $cat='';
        }

        $offset=0;
        $start  = Carbon::today();
 			if($cat!='all'){
				$catdata = DB::table('event_category')->where('event_category.category_name', $cat)->get();
				$ids = array();
				foreach ($catdata as $key => $value) {
					$ids[] = $value->id;
				}
				//dd($ids);
				$cids = array_push($ids, $cat);   
			}
 //DB::enableQueryLog();
            $dataInfos = DB::table("events")->select("events.*","frontusers.firstname as fnm","frontusers.lastname as lnm","frontusers.email as email",
            DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                    WHERE event_tickets.event_id = events.event_unique_id
                    GROUP BY event_tickets.event_id) as event_min_price"),
            DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                    WHERE event_tickets.event_id = events.event_unique_id
                    GROUP BY event_tickets.event_id) as event_max_price"))
            ->join('frontusers','frontusers.id','=','events.event_create_by')
            ->where('events.event_status','1')
	    ->where('event_end_datetime','>=',$start)
            ->orderby('events.event_start_datetime','desc');
				
			if(!empty($_GET['pays'])){
				$pays=$_GET['pays']; 
				$dataInfos->where('event_country',$pays);
			}
			if($cat!='all'){
				$dataInfos->whereIn('event_category', $ids);
			}
			if(!empty($_GET['date'])){
				$date=$_GET['date']; 
				$d=explode("-",$date);
				$date1=trim($d[0]);
				//$date1=date_format($date1,"Y/m/d H:i:s");
				
				$date2=trim($d[1]);
				//$date2=date_format($date2,"Y-m-d H:i:s");
				
				  echo $date1.' '.$date2;
				$dataInfos->whereBetween('event_start_datetime',[$date1,$date2]);				
			}
			$dataInfos->offset($offset)->limit(15)->get();				
		
//dd(DB::getQueryLog());        
 		  if($dataInfos->count()>0){
 
		    foreach($dataInfos->get() as $data){   
		  	  if($data->event_status == 1){

$xx.='<div class="col-lg-4 col-md-6 col-sm-12 hover " style="" >

	<div class="box-icon pull-right share-listing">
		<a href="javascript:void()" data-toggle="tooltip"
		   data-original-title="Partager"
		   data-placement="right" class="event-share"
		   data-url="'.route('events.details',$data->event_slug).'"
		   data-name="'.$data->event_name.'" data-loca="'.$data->event_location.'">
			<i class="fas fa-share"></i>
		</a>
	</div>';   

  $xx.='<div class="box-icon pull-right like-listing">';
		if(auth()->guard('frontuser')->check()){
			$userid = auth()->guard('frontuser')->user()->id;
		}else{
			$userid = '';
		}

	$xx.='<a href="javascript:void(0)" data-toggle="tooltip"
		   data-original-title="Enregistrer dans les favoris"
		   data-placement="right" id="save-event" class="save-event" data-user="'.$userid.'"
		   data-event="'.$data->event_unique_id.'" data-mark="0">';

			if(is_null(getbookmark($data->event_unique_id, $userid)))
				$xx.='<i class="far fa-heart"></i>';
			else
				$xx.='<i class="fas fa-heart"></i>';

		$xx.='</a>
		<!-- <i class="fa fa-bookmark-o"><a href="#"></a></i> -->
	</div>';

   $xx.='<div class="box" style="position: relative;">


	   <a href="'.route('events.details',$data->event_slug).'"><div class="bunique" style="background-image: url(\''.getImage($data->event_image, 'thumb').'\'); "></div></a>

		<div class="box-content card__padding">
			<div class="innercardbox">

				<div class="left_innerbox">
					<h4 class="card-title"><a href="'.route('events.details',$data->event_slug).'">'.$data->event_name.'</a></h4>
					<div class="prix">
						<a href="'.route('events.details',$data->event_slug).'" class=""><span class="">';
								if($data->event_min_price == 0)
								  $xx.='GRATUIT';
								else
									 $xx.=number_format($data->event_min_price, 0, "."," ").' '.use_currency()->symbol;

								if($data->event_min_price != $data->event_max_price)
									$xx.='- '.number_format($data->event_max_price, 0, "."," ").' '.use_currency()->symbol;

						$xx.='</span></a>
					</div> ';
				   $xx.=' <div class="card__location">
						<div class="card__location-content">
							<i class="fas fa-map-marker-alt primary-color"></i>
							<a href="" rel="tag"
							   class="third-color bold"> '.$data->event_location.'</a>
						</div>
					</div>
				</div>';

			   $xx.=' <div class="right_innerbox">';

					$startdate 	= ucwords(Date::parse($data->event_start_datetime)->format('l j F Y'));
					$enddate 	= ucwords(Date::parse($data->event_end_datetime)->format('l j F Y'));
					$starttime	= Carbon::parse($data->event_start_datetime)->format('H:i');
					$endtime	= Carbon::parse($data->event_end_datetime)->format('H:i');

					$xx.='<div class="badge category col-sm-4 col-sm-offset-1" style="cursor: default">
						  <span class="">';
							  $xx.=Event::getCategoryById($data->event_category);
						   $xx.='
						  </span>
					</div>'; 
					$xx.='<div class="datexp">';
						  if($startdate == $enddate){
							$xx.='<div class="date-times bold third-color">
									   <table cellpadding="0" cellspacing="0" border="0">';                                   

											$stdate=explode(" ",$startdate);
											$nbstdate=count($stdate);

											for($x=0;$x<$nbstdate;$x++){
												if($x==1){ $tpc='class="secdatexp"'; }else{ $tpc=''; } 
												$xx.='<tr '.$tpc.' ><td style="text-align: center">'.$stdate[$x].'</td></tr>';
											}                                        

								 $xx.='</table>   
							</div>';
						  }else{
							  $xx.='<div class="both" style="float: left; width: 43%">
								<table cellpadding="0" cellspacing="0" border="0">';                                   

										$stdate=explode(" ",$startdate);
										$nbstdate=count($stdate);
										for($xy=0;$xy<$nbstdate;$xy++){
											if($xy==1){ $tpc='class="secdatexp"'; }else{ $tpc=''; } 

										$xx.='<tr '.$tpc.'><td>'.$stdate[$xy].'</td></tr>';
										}                                      

							   $xx.=' </table>                                
							</div>    
							<div class="sepa"><span class="separator">-</span></div>
							<div class="both" style="float: right; width: 43%">

								 <table cellpadding="0" cellspacing="0" border="0"> ';                                  

										$edate=explode(" ",$enddate);
										$nbedate=count($edate);
										for($y=0;$y<$nbedate;$y++){
											if($y==1){ $tps='class="secdatexp"'; }else{ $tps=''; } 
											$xx.='<tr '.$tps.' ><td style="text-align: left">'.$edate[$y].'</td></tr>';
									   }                                      

							  $xx.='</table>   

							</div>';

						}                    
				   $xx.='</div>

				</div>  

		   </div>
			<div style="clear:both;"></div>
		</div>
	</div>

</div>';               


			}
		    }

		    if($_GET['cat']!='all'){ if($xx==null) $xx=0; }
			return $xx;
		  }else{
			return 0;
		  }
		
    }	
    /* ================================================ */
    /* DISPLAY SINGLE EVENTS ========================== */
    /* ================================================ */
    
 	public function singleevent($slug,$snippet='') {
 		Carbon::setLocale('fr');
		//$date = Carbon::yesterday()-> diffForHumans();
 		//dd($date);
		 
 		if ($snippet != '') {
			$slug = \Crypt::decrypt($slug);
		}
		$fuser_id = (auth()->guard('frontuser')->check())?auth()->guard('frontuser')->user()->id:0;
		
		//Log::info('Slug : '.$slug);
 		$event = $this->event->getsingleevent(strtolower($slug));

		if(empty($event)){
		  \App::abort(404, 'Event Not Found');
		}

		$e = Event::where('id', $event->id)->first();
		$gadgets = $e->gadgets()->get();

 		if(is_null($event)){
 		 	\App::abort(404, 'Event Not Found');
 		}
 		if($event->ban == 1){
 			$userid = (auth()->guard('frontuser')->check())?auth()->guard('frontuser')->user()->id:0;
 			if($userid != $event->event_create_by){
 				\App::abort(404, 'Event Not Found');
 			}
 		}
 		if ($event->event_status == 0) {
 			$userid = (auth()->guard('frontuser')->check())?auth()->guard('frontuser')->user()->id:0;
 			if ($userid != $event->event_create_by) {
 				\App::abort(404, 'Event Not Found');
 			}
 		}
 		$data = $this->hit->hits($event->event_unique_id);
 		if(is_null($data)){
 			$input['event_id'] = $event->event_unique_id;
 			$input['ip'] = \Request::ip();
 			$this->hit->countInsert($input);
		}
		$event_tickets = $this->event_ticket;
		$bookmark = $this->bookmark->getData($event->event_unique_id,$fuser_id);
 		//$count = count($data);

 		$event_ticket	= $this->event_ticket->event_tickets($event->event_unique_id);
 		return view('theme.events.event-detail',compact('event', 'event_ticket','bookmark','event_tickets','gadgets'));
 	}


 	public function eventByCountry($pays){
 	    //$pays = ucwords(str_replace('_',' ', $pays));
        //dd($pays);
 	    return view('theme.events.event-by-country')->with('pays',$pays);
    }

    public function eventByCode($code){
 	    $paysList = PaysList::where('code_pays',$code)->first();
 	    //dd($paysList->nom_pays, $code);
 	    if($paysList != null){
            $pays = strtolower(str_replace(' ','_', $paysList->nom_pays));
            return redirect()->route('events.country',$pays);
        }else{
            \App::abort(404, 'Something went to wrong.');
        }
    }



/* ================================================ */
/* CREATE EVENT =================================== */
/* ================================================ */
 	public function create() {
        // $categories = $this->event_category->getCategorylist();
        // $childs		= $this->event_category->childs();
        $categories	= $this->event_category->get_Category_event();
        $id = auth()->guard('frontuser')->user()->id;
        $listorg = $this->organization->orgList($id);
	    $datas = Organization::where('user_id',$id)->get();
	    $pays = PaysList::orderBy('nom_pays','asc')->get();

 		return view('theme.events.event-create',compact('categories','listorg','datas','pays'));
 	}
/* ================================================ */
 	public function store(Request $request){

 		$input = $request->all();
		$this->validate($request, [
			'event_name'			=> 'required',
			//'color'			=> 'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i',
			//'background'			=> 'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i',
			'event_location'		=> 'required',
            'start_date'			=> 'required|date_format:d/m/Y',
			'start_time'			=> 'required',
          	'end_date'				=> 'required|date_format:d/m/Y|after_or_equal:start_date',
           	'end_time'				=> 'required',
			'event_category'		=> 'required',
			'event_description'		=> 'required',
			'event_org_name'		=> 'required',
			'event_country'        	=> 'required',
			// 'event_url'			=> 'nullable|url',
			'event_image'     		=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
			'ticket_title'			=> 'required',
			'event_code'			=> 'required_if:radio-group,1|same:confirm_event_code',
			'confirm_event_code'	=> 'required_if:radio-group,1',
		],[
			'event_code.required_if' => 'The event code field is required.',
    		'event_code.same' => 'The event code and confirm event code must match.',
    		'confirm_event_code.required_if' => 'The confirm event code field is required.',
			'ticket_title.required'=>'Veuillez crÃ©er au moins un ticket',
			'end_date.after'=>'La date de fin doit Ãªtre postÃ©rieure Ã  la date de dÃ©but'
		]);


		// $location = getLocationData($input['event_latitude'],$input['event_longitude']);
		// $input['event_location'] 	= $location->location;
		// $input['event_city'] 		= $location->city;
		// $input['event_state'] 		= $location->state;
		// $input['event_country'] 		= $location->country;
		// $input['event_latitude'] 	= $location->lat;
		// $input['event_longitude'] 	= $location->long;

    	$path = 'upload/events/'.date('Y').'/'.date('m');
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }
        if (!empty($request->file('event_image'))) {
            $iinput['event_image'] = ImageUpload::upload($path,$request->file('event_image'),'event-image');
            //ImageUpload::uploadThumbnail($path,$iinput['event_image'],250,130,'thumb');
            //ImageUpload::uploadThumbnail($path,$iinput['event_image'],800,400,'resize');
            list($width, $height, $type, $attr) = getimagesize($request->file('event_image'));
            ImageUpload::uploadThumbnail($path,$iinput['event_image'],360,360,'thumb');
            //ImageUpload::uploadThumbnail($path,$iinput['event_image'],1440,960,'resize');
            ImageUpload::uploadThumbnail($path,$iinput['event_image'],$width,$height,'resize');
        	$input['event_image'] = save_image($path,$iinput['event_image']);
        }
        $event_unique_id = str_shuffle(time());
        $event_slug = str_slug($input['event_name']).'-'.$event_unique_id;

    $input['event_status'] = 2;
	$input['event_remaining'] = isset($input['event_remaining'])?$input['event_remaining']:0;


	/* date and time */
	$stardt	= $input['start_date']." ".$input['start_time'];
	$enddt	= $input['end_date']." ".$input['end_time'];

	$start_datetime = Carbon::createFromFormat('d/m/Y H:i', $stardt)->format('Y-m-d H:i:s');
	$end_datetime 	= Carbon::createFromFormat('d/m/Y H:i', $enddt)->format('Y-m-d H:i:s');
        //return dd($enddt, $stardt, $start_datetime, $end_datetime);

        /* date and time */
	/* ------------------------- */
	$input['event_start_datetime'] = $start_datetime;
	$input['event_end_datetime'] = $end_datetime;
    	$input['event_slug'] = $event_slug;
        $input['event_unique_id'] = $event_unique_id;
        $input['event_qrcode'] = '0';
        $input['event_qrcode_image'] = '0';
        $input['event_create_by'] = auth()->guard('frontuser')->user()->id;
		/* ------------------------- */
        /* EVENT TICKETS */
        if(isset($input['ticket_type'])) {

        	$nooftickets	= count($input['ticket_type']);
	        $tickets_array 	= array();
			$moreinfos_field = array();
			
		    for($i=0; $i<$nooftickets; $i++){

		    	$ticket_id 			= strtoupper(str_shuffle(str_random(5)).str_shuffle($event_unique_id).str_shuffle(str_random(5)));
		    	$ticket_type		= $input['ticket_type'][$i];
		    	$event_commission 	= event_commission();
		    	/*$ticket_price		= $input['ticket_price_actual'][$i];*/
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
		    		/*$buyer_price	= $ticket_price + $event_fees;*/
                    $buyer_price	= $ticket_price;
                    $ticket_price	= $ticket_price - $event_fees;
		    	}else{
		    		$buyer_price	= $ticket_price;
		    	}

		    	$desc_status 	= isset($input['ticket_desc_status'][$i])?1:0;
		    	$ticket_status 	= isset($input['ticket_status'][$i])?1:0;

		    	$tickets_array['ticket_id'] 			= implode('-', str_split(str_shuffle($ticket_id), 5));
		    	$tickets_array['event_id']				= $event_unique_id;
		    	$tickets_array['ticket_title'] 			= $input['ticket_title'][$i];
		    	$tickets_array['ticket_description'] 	= $input['ticket_description'][$i];
		    	$tickets_array['ticket_desc_status'] 	= $desc_status;
		    	$tickets_array['ticket_qty'] 			= $input['ticket_qty'][$i];
		    	$tickets_array['ticket_remaning_qty']	= $input['ticket_qty'][$i];
		    	$tickets_array['ticket_type'] 			= $ticket_type;
		    	$tickets_array['ticket_status']			= $ticket_status;
		    	$tickets_array['ticket_services_fee'] 	= $services_fee;
		    	//$tickets_array['ticket_price_buyer'] 	= number_format($buyer_price,2,".","");
		    	//$tickets_array['ticket_price_actual'] 	= number_format($ticket_price,2,".","");
		    	//$tickets_array['ticket_commission'] 	= number_format($event_commission,2,".","");
                $tickets_array['ticket_price_buyer'] 	= number_format($buyer_price,0,",","");
                $tickets_array['ticket_price_actual'] 	= number_format($ticket_price,0,",","");
                $tickets_array['ticket_commission'] 	= number_format($event_commission,0,",","");
				
				$n=count($input['nbvalue']); //Nbre de tickets


				
				
				if($n>0){
					 
						//$vv=count($input['value'][$w]); 
						$nbtitreChamp=count($input['field_title']);
						$nbtypeChamp=count($input['field_type']);
						$nbtitreChamp=count($input['field_title']);
						$vchamp="";
					 
					
						for ($y = 0; $y < $nbtypeChamp; $y++) { // Recupere les valeurs par champ
							if (isset($input['field_type'][$i + 1]) && isset($input['field_type'][$i + 1][0])) {
								$vchamp .= "type=" . $input['field_type'][$i + 1][$y] . "@title=" . $input['field_title'][$i + 1][$y];
								
								if (isset($input['field_type'][$i + 1][$y]) && $input['field_type'][$i + 1][$y] == 'list') {
									if (isset($input['value'][$i + 1][$y]) && is_array($input['value'][$i + 1][$y])) {
										$nval = count($input['value'][$i + 1][$y]);
										$vchamp .= "@nbval=$nval";
										for ($g = 0; $g < $nval; $g++) {
											if (isset($input['value'][$i + 1][$y][$g])) {
												$vchamp .= "@values=" . $input['value'][$i + 1][$y][$g];
											}
										}
									}
								}

								$vchamp .= "|";
								$moreinfos_field[] = $vchamp;
							}
						}
						$tickets_array['moreinfos_field'] = $vchamp;
				}
				//dd($input); die("--++++");
				
                //dd(number_format($buyer_price,0,",",""), number_format($ticket_price,0,",",""), number_format($event_commission,0,",",""));
				//echo"<pre>";print_r($tickets_array);echo"</pre>";

				//die;

		    	$data = $this->event_ticket->insertData($tickets_array);
		    }   
		}
 
        $orderData = (object)$input;
        $mail = array(
                'charlene.valmorin@gmail.com',
                'contact@myplace-events.com',
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

		$link = route('events.details',$event_slug);
		// $url = ShortLink::bitly($link);
		$input['short_url'] 	= $link;
		$input['refund_policy'] = $input['refund'];
        $data = $this->event->insertData($input);
        return redirect()->route('events.details',$event_slug)->with('success',trans('Succ�s, l\'�v�nement cr�e est en cours d\'approbation'));
 	}
/* ================================================ */
/* USER EVENTS LIST =============================== */
/* ================================================ */
	public function userevents() {

		$id		 = auth()->guard('frontuser')->user()->id;
        $uEvents = Event::where('event_create_by',$id)->orderBy('created_at','desc')->paginate(10);

        $totalcount = Event::where('event_create_by',$id)->count();

        $darftCount = Event::where('event_create_by',$id)->where('event_status',0)->count();

        $datas		= Carbon::now();
        $start    	= Carbon::today()->addHours(23)->addMinutes(59)->addSeconds(59);
        $currenEve 	= Event::where('event_create_by',$id)->whereBetween('event_start_datetime',[$datas,$start])->count();

        $futereve 	= Event::where('event_create_by',$id)->where('event_start_datetime','>=',$datas)->count();

        $pastevev 	= Event::where('event_create_by',$id)->where('event_start_datetime','<=',$datas)->count();

        $draft      = Event::where('event_status',0)->where('event_create_by',$id)->get();
        $curentEven = Event::where('event_create_by',$id)->whereBetween('event_start_datetime',[$datas,$start])->get();
        $futerseve 	= Event::where('event_create_by',$id)->where('event_start_datetime','>=',$datas)->get();
        $pastevents = Event::where('event_create_by',$id)->where('event_start_datetime','<=',$datas)->get();

		return view('theme.events.event-user', compact('uEvents','totalcount','darftCount','currenEve','futereve','pastevev','draft','curentEven','futerseve','pastevents'));
	}

/* ================================================ */
/*  */
/* ================================================ */
	public function eventDashboard($id){

		$userid	= auth()->guard('frontuser')->user()->id;

        $event = Event::where('event_unique_id',$id)->first();
		//dd($userid);


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
		//dd($data, $databook, $eventTicket, $contactAttendes);
		return view('theme.events.event-dashboard', compact('event', 'tickets','data','databook','bookedeve','eventTicket','event_tickets','eventOrderTickets','totalOrderTickss','totalChackInTickss','contactAttendes'));
	}
	
/* ================================================ */
/* USER EVENTS Edit  */
/* ================================================ */
	public function event_edit($unique_id)
	{
		$categories	= $this->event_category->get_Category_event();
		// $childs		= $this->event_category->childs();
        $id = auth()->guard('frontuser')->user()->id;
        $listorg = $this->organization->orgList($id);
		// $categories = $this->event_category->getCategorylist();
		$events = $this->event->findData($unique_id);
		$datas = Organization::where('user_id',$id)->get();
		$ticket = $this->event_ticket->event_tickets($unique_id);
		$price_change = $this->booking->priceChange($unique_id);
        $pays = PaysList::orderBy('nom_pays','asc')->get();

		return view('theme.events.event-edit',compact('categories','listorg','events','ticket','datas','price_change','pays'));
	}

	public function update(Request $request, $id)
	{
		$input = $request->all();
		//dd($input);
		$price_change = $this->booking->priceChange($id);
		$this->validate($request,[
			'event_name'		=> 'required',
    		'event_location'	=> 'required',
			//'start_date'		=> 'required|date',
            'start_date'			=> 'required|date_format:d/m/Y',
			'start_time'		=> 'required',
            'end_date'			=> 'required|date_format:d/m/Y',
			//'end_date'			=> 'required|date',
			'end_time'			=> 'required',
			'event_category'	=> 'required',
			'event_description'	=> 'required',
			//'event_address'		=> 'required',
			'event_org_name'	=> 'required',
			//'event_url'			=> 'nullable|url',
            'event_country'         => 'required',
			'event_image'     	=> 'image|mimes:jpeg,png,jpg,gif|max:2048',
			'event_code'			=> 'required_if:radio-group,1|same:confirm_event_code',
			'confirm_event_code'	=> 'required_if:radio-group,1',
            //'event_status'	    => 'required',
		],[
			'event_code.required_if' => 'The event code field is required.',
    		'event_code.same' => 'The event code and confirm event code must match.',
    		'confirm_event_code.required_if' => 'The confirm event code field is required.',
		]);

		// $location = getLocationData($input['event_latitude'],$input['event_longitude']);
		// $input['event_location'] 	= $location->location;
		// $input['event_city'] 		= $location->city;
		// $input['event_state'] 		= $location->state;
		// $input['event_country'] 	= $location->country;
		// $input['event_latitude'] 	= $location->lat;
		// $input['event_longitude'] 	= $location->long;

		if ($input['radio-group'] != 1) {
			$input['event_code'] = NULL;
		}

		$path = 'upload/events/'.date('Y').'/'.date('m');
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }

        $input['map_display'] = isset($input['map_display'])?1:0;
        $input['event_remaining'] = isset($input['event_remaining'])?1:0;
        //$input['event_status'] = isset($input['event_status'])?1:0;
        //$input['event_status'] = (isset($input['event_status']) && $input['event_status'] == 1)?1:(isset($input['event_status']) && $input['event_status'] == 2)?2:0;

        /* date and time */
		$stardt	= $input['start_date']." ".$input['start_time'];
		$enddt	= $input['end_date']." ".$input['end_time'];
		//$start_datetime = Carbon::createFromFormat('m/d/Y H:i A', $stardt)->format('Y-m-d H:i:s');
		//$end_datetime 	= Carbon::createFromFormat('m/d/Y H:i A', $enddt)->format('Y-m-d H:i:s');

        $start_datetime = Carbon::createFromFormat('d/m/Y H:i', $stardt)->format('Y-m-d H:i:s');
        $end_datetime 	= Carbon::createFromFormat('d/m/Y H:i', $enddt)->format('Y-m-d H:i:s');
		/* date and time */

		$input['event_start_datetime']	= $start_datetime;
		$input['event_end_datetime'] 	= $end_datetime;

		if (isset($input['refund'])) {
			$input['refund_policy'] = $input['refund'];
		}
		if (!empty($input['event_image'])) {
			$input['event_image'] = ImageUpload::upload($path,$request->file('event_image'),'event-image');
            list($width, $height, $type, $attr) = getimagesize($request->file('event_image'));
            ImageUpload::uploadThumbnail($path,$input['event_image'],360,360,'thumb');
            //ImageUpload::uploadThumbnail($path,$input['event_image'],800,400,'resize');
            ImageUpload::uploadThumbnail($path,$input['event_image'],$width,$height,'resize');
        	$input['event_image'] = save_image($path,$input['event_image']);

			if (!empty($input['old_image'])) {
				$datas = image_delete($input['old_image']);
                $path = $datas['path'];
                $image = $datas['image_name'];
                $image_thum = $datas['image_thumbnail'];
                $image_resize = 'resize-'.$datas['image_name'];
                ImageUpload::removeFile($path,$image,$image_thum,$image_resize);
			}
			$this->event->updateData($id,$input);
		}
		else
		{
			$input['event_image'] = $input['old_image'];

			$this->event->updateData($id,$input);
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
			    	$event_commission 	= '3.5';
			    	$ticket_price		= $input['ticket_price_actual'][$i];
			    	$services_fee		= $input['ticket_services_fee'][$i];
			    	if($ticket_type == 0){
			    		$ticket_price = 0;
			    		$event_commission = 0;
			    	}
			    	$event_fees = ($ticket_price) * ($event_commission / 100);
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

			    	$event_commission 	= '3.5';
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
		return redirect()->route('events.manage')->with('success',trans('words.msg.eve_update'));
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
        //dd(var_dump($eventData,$eventTicket));
		$pdf = PDF::loadView('theme.pdf.attendee',compact('eventTicket','eventData'));
		//dd(ini_get('memory_limit'));
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
        return response()->json(['success' => 'URL personnalis� avec succ�s.','url' => route('custom.slug',$data)]);
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
    
        
    public function CouponInfos(Request $request)
    {
        $code=$request->code;
        $all_products = EventTicketsCoupon::select('id', 'discount','discount_type')->where('code', $code)->get();
        return response()->json($all_products);
    }
    
    
    public function CouponCheck(Request $request)
    {   
        $date = date('Y-m-d');
        return EventTicketsCoupon::where('code', $request->code)->where('status','publish')->where('expire_date','>=',$date)->count();
    } 
    
}
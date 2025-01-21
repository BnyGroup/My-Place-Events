<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\ImageUpload;
use App\EventCategory;

class Event extends Model
{
	protected $table = 'events';
 	protected $fillable = [
        'event_unique_id', 'event_slug','refund_policy','event_qrcode', 'event_qrcode_image', 'event_create_by', 'event_category',
        'event_name', 'event_description', 'event_location', 'map_display', 'event_address', 'event_start_datetime', 'event_end_datetime',
        'event_image', 'event_url', 'event_org_name', 'event_facebook','short_url', 'evetn_twitter', 'event_instagaram', 'event_status', 'event_remaining','event_code','event_link_slug','event_latitude','event_longitude','event_city','event_state','event_country','event_immanquable','event_home_status'];

    public function insertData($input) {
    	return static::create(array_only($input,$this->fillable));
    }

    public function getAll() {
    	return static::get();
    }
    public function CountAllEvent() {
    	return static::count();
    }
    public function geteventwithtickets() {
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
		//->where('event_end_datetime','>=',$now)
        ->orWhere('event_status','0')
        ->orderby('events.event_end_datetime','desc');

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
        return $data 
        ->paginate(120);
        //->get();
    }
	
	
	public function geteventwithtickets2() {
	    $now  = Carbon::today();
        $data = DB::table("events")->select("events.*","frontusers.firstname as fnm","frontusers.lastname as lnm","frontusers.email as email",
        DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
        DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"))
        ->join('frontusers','frontusers.id','=','events.event_create_by')
        ->where('events.event_status','1')
		->where('events.event_end_datetime','>=',$now)
        //->orWhere('event_status','0')
        ->orderby('events.event_end_datetime','desc');

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
        return $data->paginate(15);
        //->get();
    }


    public function geteventwithticketswithid($id) {
        return $data = DB::table("events")->select("events.*","frontusers.firstname as fnm","frontusers.lastname as lnm","frontusers.email as email","organizations.organizer_name as ORG_NAME")
            ->join('frontusers','frontusers.id','=','events.event_create_by')
            ->join('organizations','organizations.id','=','events.event_org_name')
            ->where('events.id', $id)
            ->first();
    }


    public function geteventwithticketsforrecentevent() {
        $data = DB::table("events")->select("events.*","frontusers.firstname as fnm","frontusers.lastname as lnm",
            DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
            DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"))
            ->join('frontusers','frontusers.id','=','events.event_create_by');

        if (isset($_GET['fuser']) && !empty($_GET['fuser'])) {
            $datas = explode(' ', $_GET['fuser']);
            $data = $data->where('frontusers.firstname','LIKE','%'.$datas[0].'%');
            $data = $data->where('frontusers.lastname','LIKE','%'.$datas[1].'%');
        }
        if (isset($_GET['duration']) && !empty($_GET['duration'])) {
            if ($_GET['duration'] == 'Current') {
                $datas      = Carbon::now();
                $data = $data->where('event_start_datetime','<=',$datas);
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
        return $data->where('event_status','2')
                ->orderby('ban','asc')
                ->get();
    }


    public function geteventwithticketssearch($cat='', $date='', $price='',$catdata='') {
 
        if($price != ''){
            switch ($price) {
                case 'free':
                    $price = "OR (event_tickets.ticket_price_buyer) = 0 ";
                    break;
                case 'paid':
                    $price = "OR (event_tickets.ticket_price_buyer) != 0 ";
                    break;
                default:
                    $price = '';
                    break;
            }
        }
        $start  = Carbon::today();
        $data = DB::table("events")->select("events.*",
            DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
            DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"),
            DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_category"),
            DB::raw("(SELECT category_image FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_image"))
            ->where('event_end_datetime','>=',$start)
            ->orderby('event_end_datetime','desc');
        
        if(!empty($catdata)){
            $data->whereIn('events.event_category',$catdata);
        }
        
        $data->where('event_status',1);
        $data->where('ban',0);
        if($cat != '' && is_numeric($cat)){  
            $catdata  = DB::table('event_category')->where('event_category.category_parent',$cat)->get();
            $ids = array();
            foreach ($catdata as $key => $value) {
                $ids[] = $value->id;
            }
            $cids = array_push($ids, $cat);
            $data->whereIn('event_category',$ids);
        }

        if($date != ''){
            switch ($date) {
                case 'today':
                    $start  = Carbon::today();
                    $end    = Carbon::today()->addHours(23)->addMinutes(59);
                    $data->whereBetween('event_start_datetime', [$start, $end] );
                    break;

                case 'tomorrow':
                    $start  = Carbon::today()->addHours(24);
                    $end    = Carbon::today()->addHours(47)->addMinutes(59);
                    $data->whereBetween('event_start_datetime', [$start, $end] );
                    break;

                case 'this_week':
                    $start  = Carbon::now()->startOfweek();
                    $end    = Carbon::now()->endOfweek();
                    $data->whereBetween('event_start_datetime', [$start, $end] );
                    break;

                case 'this_month':
                    $start  = Carbon::now()->startOfMonth();
                    $end    = Carbon::now()->endOfMonth();
                    $data->whereBetween('event_start_datetime', [$start, $end] );
                    break;

                case 'cdate':
                    if(isset($_GET['ds']) && isset($_GET['de'])){
                        if( isValidTimeStamp($_GET['ds']) && isValidTimeStamp($_GET['de']) ) {
                            $startdate  = Carbon::createFromTimestamp($_GET['ds'])->format('Y-m-d H:i:s');
                            $enddate    = Carbon::createFromTimestamp($_GET['de'])->format('Y-m-d H:i:s');
                        } else if( isValidTimeStamp($_GET['ds']) && !isValidTimeStamp($_GET['de']) ) {
                            $startdate  = Carbon::createFromTimestamp($_GET['ds'])->format('Y-m-d H:i:s');
                            $enddate    = Carbon::parse($startdate)->addMonth();
                        } else {
                            $startdate  = Carbon::today();
                            $enddate    = Carbon::today()->addMonth();
                        }
                    }
                    $start  = Carbon::today();
                    $end    = Carbon::today()->addMonth();
                    $data->whereBetween('event_start_datetime', [$start, $end] );
                    break;

                default:
                    //$start  = Carbon::today();
                    //$data->where('event_start_datetime','>=', $start);
                    break;
            }
        }


        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $data->where('events.event_name','LIKE','%'.$_GET['search'].'%');
        }
        $data->whereNull('event_code');

        if(isset($_GET['location']) && !empty($_GET['location'])){
            $reo = str_replace('%',',',$_GET['location']);
            $log = addressFormLagLong($reo);
            $data->where('events.event_location','LIKE','%'.$log->location.'%');
            // $data->Orwhere('events.event_city','LIKE','%'.$log->city.'%');
            // $data->Orwhere('events.event_state','LIKE','%'.$log->state.'%');
            // $data->Orwhere('events.event_country','LIKE','%'.$log->country.'%');
        }
            
        return $data
            //->orderBy('event_start_datetime', 'asc')
            ->paginate(15);
    }

    /* ================================================ */
    /* INDEX 2 ========================== */
    /* ================================================ */

    public function geteventlistbynewsearch($name='', $country='', $cat='', $date='', $startD='', $endD='')
    {
		
        $data = DB::table("events")->select("events.*",
            DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
            DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"),
            DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_category"))
            ->orderby('event_start_datetime', 'desc');

        $data->where('event_status', 1);
        $data->where('ban', 0);

        if ($name != '') {
            $data->where('events.event_name', 'like', '%' . $name . '%');
        }

        if ($country != '') {
            $data->where('events.event_country', $country);
        }

        if ($cat != '') {
            $catdata = DB::table('event_category')->where('event_category.category_name', $cat)->get();
            $ids = array();
            foreach ($catdata as $key => $value) {
                $ids[] = $value->id;
            }
            //dd($ids);
            $cids = array_push($ids, $cat);
            $data->whereIn('event_category', $ids);
        }

        if (!empty($startD) || !empty($startD) && $date == "Custom Date") {
            if (isset($startD) && isset($endD)) {
                if (($startD) && ($endD)) {
                    /*$startdate = Carbon::parse($startD);
                    $enddate = Carbon::parse($endD);
                    $startdate = Carbon::createFromTimestamp($startdate);
                    $enddate = Carbon::createFromTimestamp($enddate);*/
                    $data->whereBetween('event_start_datetime', [$startD, $endD]);
                  //  return dd($date, '1');
                } else {
                    $startdate = Carbon::today();
                    $enddate = Carbon::today()->addMonth();
                    $data->whereBetween('event_start_datetime', [$startdate,$enddate]);
                 //   return dd($date, '2');
                }
            }
        }elseif ($date != '') {
           // return dd($date, '3');
                $date = strtolower($date);
                switch ($date) {
                    case 'aujourd\'hui':
                        $start = Carbon::today();
                        $end = Carbon::today()->addHours(23);
                        $data->whereBetween('event_start_datetime', [$start, $end]);
                        //dd($date, '3');
                        break;

                    case 'today':
                        $start = Carbon::today();
                        $end = Carbon::today()->addHours(23);
                        $data->whereBetween('event_start_datetime', [$start, $end]);
                        break;

                    case 'demain':
                        $start = Carbon::today()->addHours(24);
                        $end = Carbon::today()->addHours(47)->addMinutes(59);
                        $data->whereBetween('event_start_datetime', [$start, $end]);
                        break;

                    case 'tomorrow':
                        $start = Carbon::today()->addHours(24);
                        $end = Carbon::today()->addHours(47)->addMinutes(59);
                        $data->whereBetween('event_start_datetime', [$start, $end]);
                        break;

                    case 'cette semaine':
                        $start = Carbon::now()->startOfweek();
                        $end = Carbon::now()->endOfweek();
                        $data->whereBetween('event_start_datetime', [$start, $end]);
                        break;

                    case 'this week':
                        $start = Carbon::now()->startOfweek();
                        $end = Carbon::now()->endOfweek();
                        $data->whereBetween('event_start_datetime', [$start, $end]);
                        break;

                    case 'ce mois':
                        $start = Carbon::now()->startOfMonth();
                        $end = Carbon::now()->endOfMonth();
                        $data->whereBetween('event_start_datetime', [$start, $end]);
                        break;

                    case 'this month':
                        $start = Carbon::now()->startOfMonth();
                        $end = Carbon::now()->endOfMonth();
                        $data->whereBetween('event_start_datetime', [$start, $end]);
                        break;

                    default:
                        $start = Carbon::today()->format('Y-m-d H:i:s');
                        //$data->where('event_start_datetime', '>=', $start);
                        break;
                }
            }
		
         
		if (isset($_GET['search']) && !empty($_GET['search'])) {
			$data->where('events.event_name', 'LIKE', '%' . $_GET['search'] . '%');
		}
		$data->whereNull('event_code');

		if (isset($_GET['location']) && !empty($_GET['location'])) {
			$reo = str_replace('%', ',', $_GET['location']);
			$log = addressFormLagLong($reo);
			$data->where('events.event_location', 'LIKE', '%' . $log->location . '%');
			// $data->Orwhere('events.event_city','LIKE','%'.$log->city.'%');
			// $data->Orwhere('events.event_state','LIKE','%'.$log->state.'%');
			// $data->Orwhere('events.event_country','LIKE','%'.$log->country.'%');
		}
		return $data->paginate(15);
    }
    
    
    

    public function geteventlistbycat($cat)
    {
		$now = Carbon::now();
        $data = DB::table("events")->select("events.*",
            DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
            DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"),
            DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_category"))
            ->orderby('event_start_datetime', 'DESC');

        $data->where('event_status', 1)->where('event_end_datetime','>=', $now);
        $data->where('ban', 0);

         
        if ($cat != '') {
            $catdata = DB::table('event_category')->where('event_category.category_name', $cat)->get();
            $ids = array();
            foreach ($catdata as $key => $value) {
                $ids[] = $value->id;
            }
            //dd($ids);
            $cids = array_push($ids, $cat);
            $data->whereIn('event_category', $ids);
        }
          
            
         return $data->paginate(15);
    }
	

    public function getsingleevent($slug){
        $data = DB::table("events")
        ->select("events.*","organizations.profile_pic","organizations.cover","organizations.organizer_name as org_name","organizations.about_organizer as org_about","organizations.url_slug as org_slug","organizations.user_id",
        DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
        DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"),
         DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_category"))

        ->leftjoin('organizations','organizations.id','=','events.event_org_name')
        ->where('event_slug',$slug)->first();
        return $data;
    }

    public function findData($id) {
        return static::where('event_unique_id',$id)->first();
    }

    public function deleteData($id) {
        $data = static::where('event_unique_id',$id)->first();
                if(isset($data['event_image']) && $data['event_image'] != '') {
                    $datas = image_delete($data['event_image']);
                    $path = $datas['path'];
                    $image = $datas['image_name'];
                    $image_thum = $datas['image_thumbnail'];
                    $image_resize = 'resize-'.$datas['image_name'];
                    ImageUpload::removeFile($path,$image,$image_thum,$image_resize);
                }
        return $data->delete();
    }

    public function updateData($id,$input) {
        return static::where('event_unique_id',$id)->update(array_only($input,$this->fillable));
    }

    public function event_by_org($org_id) {
        $data = DB::table("events")
        ->select("events.*","organizations.organizer_name as org_name","organizations.about_organizer as org_about","organizations.url_slug as org_slug",
        DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
        DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"),
        DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_category"))
        ->join('organizations','organizations.id','=','events.event_org_name')
        ->where('event_org_name',$org_id)
        ->where('organizations.ban',0)
        ->orderBy('event_start_datetime','asc')
        ->get();
        return $data;
    }

    public function hits_events() {
        $start  = Carbon::today();
        return $data = DB::table("events")
          ->select("events.*",
            DB::raw("(SELECT COUNT(hits.event_id) FROM hits
                    WHERE hits.event_id = events.event_unique_id
                    GROUP BY hits.event_id)  as hitsRec" ),
            DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id  AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
            DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id  AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"),
            DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_category"))
            ->where('ban',0)
            /*->where('event_start_datetime','>=', $start )*/
            ->take(6)
            ->orderby('event_start_datetime','asc')
            ->get();
    }

    public function hits_events_no_limitation() {
        $start  = Carbon::today();
        return $data = DB::table("events")
            ->select("events.*",
                // DB::raw("(SELECT COUNT(hits.event_id) FROM hits
                //     WHERE hits.event_id = events.event_unique_id
                //     GROUP BY hits.event_id)  as hitsRec" ),
                // DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                // WHERE event_tickets.event_id = events.event_unique_id
                // GROUP BY event_tickets.event_id) as event_min_price"),
                // DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                // WHERE event_tickets.event_id = events.event_unique_id
                // GROUP BY event_tickets.event_id) as event_max_price"),
                DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_category"))
                // DB::raw("(SELECT category_image FROM event_category
                // WHERE event_category.id = events.event_category)
                // as this_event_image"))
            ->where('ban',0)
            /*->where('event_start_datetime','>=', $start )*/
            ->orderby('event_start_datetime','asc')
            ->get();
    }

    public function hits_passed_events_with_home_status() {
        $start  = Carbon::today();
        return $data = DB::table("events")
            ->select("events.*",
                DB::raw("(SELECT COUNT(hits.event_id) FROM hits
                    WHERE hits.event_id = events.event_unique_id
                    GROUP BY hits.event_id)  as hitsRec" ),
                DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
                DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"),
                DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_category"))
            ->where('ban',0)
            ->where('event_home_status', 1)
            ->where('event_start_datetime','<=', $start )
            ->take(6)
            ->orderby('event_start_datetime','desc')
            ->get();
    }

    public function hits_upcoming_events_with_home_status() {
        $start  = Carbon::today();
        return $data = DB::table("events")
            ->select("events.*",
                DB::raw("(SELECT COUNT(hits.event_id) FROM hits
                    WHERE hits.event_id = events.event_unique_id
                    GROUP BY hits.event_id)  as hitsRec" ),
                DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
                DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"),
                DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_category"))
            ->where('ban',0)
            ->where('event_home_status', 1)
            ->where('event_end_datetime','>=', $start )
            ->take(6)
            ->orderby('event_end_datetime','asc')
            ->get();
    }

    public function hits_all_events() {
        $start  = Carbon::today();
        echo "'event_end_datetime','<=', $start )"; die("---");
        return $data = DB::table("events")
            ->select("events.*",
                DB::raw("(SELECT COUNT(hits.event_id) FROM hits
                    WHERE hits.event_id = events.event_unique_id
                    GROUP BY hits.event_id)  as hitsRec" ),
                DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
                DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"),
                DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = events.event_category)
                as this_event_category"))
            ->where('ban',0)
            ->where('event_start_datetime','<=', $start )
            //->take(6)
            ->orderby('event_start_datetime','desc')
            ->get();
    }

    public function checkEvent($id) {
        return static::where('event_category',$id)->first();
    }

    public function getDatas($id) {
        $data = DB::table("events")
        ->select("events.*","frontusers.firstname as fnm","frontusers.lastname as lnm","event_category.category_name as cnm","organizations.organizer_name as org_name",
        DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"),
        DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"))
        ->join('frontusers','frontusers.id','=','events.event_create_by')
        ->join('event_category','event_category.id','=','events.event_category')
        ->join('organizations','organizations.id','=','events.event_org_name')
        ->where('events.id',$id)
        ->first();
        return $data;
    }

    public function searchData($input) {
        $data = static::select("events.*");
        if (isset($input)) {
           $data = $data->where('events.event_name','LIKE','%'.$input.'%')
                        ->where('ban',0)
                        ->where('event_status',1);
        }
        return $data->paginate(15);
    }

    public function getResEve() {
        return static::select("events.*")
        ->orderby('id','desc')
        ->take(10)
        ->get();
    }

    public function currentEve() {
        $datas      = Carbon::now();
        return static::select("events.*")
        ->where('event_start_datetime','<=',$datas)
        ->where('event_end_datetime','>=',$datas)
        ->take(10)
        ->get();
    }
    public function futureEvents() {
        $datas      = Carbon::now();
        return static::select("events.*")
        ->where('event_end_datetime','>=',$datas)
        ->take(10)
        ->get();
    }

    public function liveEvent($id) {
        $datas      = Carbon::now();
        return static::select('id','event_unique_id','event_category','event_name','event_location','event_address','event_start_datetime', 'event_end_datetime','event_image', 'event_org_name', 'event_status', 'event_remaining',
            DB::raw("(SELECT sum(event_tickets.ticket_qty) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id ) as EVENT_TOTAL_TICKETS"),
            DB::raw("(SELECT sum(event_booking.order_tickets) FROM event_booking
                WHERE event_booking.event_id = events.event_unique_id AND event_booking.order_status = 1 ) as EVENT_ORDERD_TICKETS"))
        //->where('event_start_datetime','>=',$datas)
        ->where('event_end_datetime','>=',$datas)
        ->where('event_create_by',$id)
        ->get();
    }
    public function pastEvent($id)
    {
        $datas= Carbon::now();
        return static::select('id','event_unique_id','event_category','event_name','event_location','event_address','event_start_datetime', 'event_end_datetime','event_image', 'event_org_name', 'event_status', 'event_remaining',
            DB::raw("(SELECT sum(event_tickets.ticket_qty) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id ) as EVENT_TOTAL_TICKETS"),
            DB::raw("(SELECT sum(event_booking.order_tickets) FROM event_booking
                WHERE event_booking.event_id = events.event_unique_id ) as EVENT_ORDERD_TICKETS"))
        ->where('event_end_datetime','<=',$datas)
        ->where('event_create_by',$id)
        ->get();
    }


    public function eventByUid($event_id) {
        return static::select('id','event_unique_id','events.event_create_by','events.event_name','events.event_location','events.event_start_datetime','events.event_end_datetime','events.event_org_name','events.event_status')
        ->where('event_unique_id',$event_id)
        ->first();
    }


/* ==================================================================================== */
/* ==================================================================================== */
/* ==================================================================================== */
/* ===================================== API CODE ===================================== */
/* ==================================================================================== */
/* ==================================================================================== */
/* ==================================================================================== */
    /*select feature  Event List for api*/
    public function getfeatureevent() {
        $datas= Carbon::now();
        $output = static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','events.event_slug');
        $output->where('event_end_datetime','>=',$datas);
        return $output->paginate(15);
    }
    /*select single  Event for api*/
    public function getsingle_event($id) {
        $datas= Carbon::now();
        return static::select('events.id','events.event_unique_id','events.event_slug','events.event_name','events.event_image','events.event_start_datetime','events.event_end_datetime','events.event_address','events.event_description',
         'events.event_location','organizations.organizer_name','organizations.about_organizer',
         'organizations.url_slug',
         DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_max_price"),
        DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = events.event_unique_id AND event_tickets.ticket_status='1'
                GROUP BY event_tickets.event_id) as event_min_price"))
        ->join('event_tickets','event_tickets.event_id','=','events.event_unique_id')
        ->join('organizations','organizations.id','=','events.event_org_name')
        ->where('events.event_unique_id',$id)
        ->first();
    }
    /*Get Today Event API*/
    public function gettodayevent($cid) {
        $start= Carbon::today();
        $end = Carbon::today()->addHours(23)->addMinutes(59);
        return static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','event_category.id')
        ->join('event_category','event_category.id','=','events.event_category')
        ->where(function($query) use ($cid){
            if(isset($cid) && intval($cid)){
                $query->where('event_category.id',$cid);
            }
        })
        ->whereBetween('event_start_datetime',[$start,$end])
        ->paginate(15);
    }
    /*Get Tomorrow Event API*/
    public function gettomorrowevents($cid) {
        $start  = Carbon::today()->addHours(24);
        $end    = Carbon::today()->addHours(47)->addMinutes(59);
        return static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','event_category.id')
        ->join('event_category','event_category.id','=','events.event_category')
        ->where(function($query) use ($cid){
            if(isset($cid) && intval($cid)){
                $query->where('event_category.id',$cid);
            }
        })
        ->whereBetween('event_start_datetime', [$start, $end])
        ->paginate(15);
    }
    /*Get This Week API*/
    public function getthisweekevents($cid) {
       $start  = Carbon::now()->startOfweek();
         $end    = Carbon::now()->endOfweek();
        return static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','event_category.id')
        ->join('event_category','event_category.id','=','events.event_category')
        ->where(function($query) use ($cid){
            if(isset($cid) && intval($cid)){
                $query->where('event_category.id',$cid);
            }
        })
        ->whereBetween('event_start_datetime', [$start, $end] )
        ->paginate(15);
    }
    /*Get category wise API */
    public function getcategorywiseeventapi($id) {
        $datas= Carbon::now();
        return static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','event_category.id','event_category.category_name','event_category.category_slug')
        ->join('event_category','event_category.id','=','events.event_category')
        ->where('event_end_datetime','>=',$datas)
        ->where('event_category',$id)
        ->paginate(15);
    }
    public function getcategory($id){
        return static::select('id','category_name','category_slug')->where('id','=',$id)->get();
    }
    //Select Event List
    public function SelectData() {
        $datas = Carbon::now();
        return static::select('id','event_unique_id','event_name','event_slug','event_image')
            ->where('event_end_datetime','>=',$datas)
            ->take(10)
            ->get();
    }
    public function get_single_event_data($event_id) {
        return static::select('events.id','events.event_unique_id','events.event_name',
            'events.event_start_datetime','events.event_end_datetime',
            'events.event_location', 'events.event_address',
            'organizations.organizer_name')
        ->join('organizations','organizations.id','=','events.event_org_name')
        ->where('events.event_unique_id',$event_id)
        ->first();
    }
    public function children() {
        return $this->hasMany('App\EventTicket','event_id','event_unique_id');
    }
    public function orgWiseEvents($id) {
        return static::with('children')
            ->select('events.*')
            ->where('event_org_name',$id)
            ->orderBy('event_start_datetime','desc')
            ->get();
    }
    public function updateDataCustom($id,$data) {
        return static::where('id',$id)->update(['event_link_slug' => $data]);
    }

    public function getBotEvnetsList($category_id,$location) {
        $datas= Carbon::now();
        $output = static::select('events.id','events.event_unique_id','events.event_name','events.event_image','events.event_start_datetime','events.event_location','events.event_slug');

        $output->where('events.event_end_datetime','>=',$datas);

        $output->where('events.event_location','LIKE', '%'.$location.'%');
        if(!empty($category_id)){
            $output->whereIn('events.event_category', $category_id);
        }
        return $output->paginate(15);
    }

    public function getEventByCountry($pays){
        $datas = static::where('event_country',$pays)
                ->get();
        return $datas->paginate(10);
    }

    public static  function getCategoryById($id){
		
		$xx=EventCategory::where('id',$id)->first();
		return $xx->category_name;
       /* if($id == 1) {
            return 'Atelier';
        }elseif($id == 2) {
           return 'Formation';
        }elseif($id == 3) {
            return 'Compétition';
        }elseif($id == 4) {
            return 'Concert';
        }elseif($id == 5) {
            return 'Défilé';
        }elseif($id == 6) {
            return 'Dégustation';
        }elseif($id == 7) {
            return 'Exposition';
        }elseif($id == 8) {
            return 'Festival';
        }elseif($id == 10) {
            return 'Forum';
        }elseif($id == 11) {
            return 'Soirée';
        }elseif($id == 12) {
            return 'Randonnée';
        }elseif($id == 13) {
            return 'Spectacle';
        }elseif($id == 14) {
            return 'Cours';
        }*/
    }

    public function gadgets()
    {
        $data = $this->hasMany('App\Gadget');
        return $data
        ->orderby('created_at','desc')
        ->take(9);
    }

    public function user()
    {
        return $this->belongsTo(Frontuser::class);
    }

}

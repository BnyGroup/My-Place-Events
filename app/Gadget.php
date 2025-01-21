<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\ImageUpload;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;
use Bavix\Wallet\Interfaces\Product;
use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Objects\Cart;



class Gadget extends Model implements Buyable, Product
{
    use HasWallet, HasWallets;

    protected $table = 'gadgets';

    
 	protected $fillable = [
        'item_unique_id','event_id', 'item_slug','item_qrcode', 'item_qrcode_image', 'item_create_by', 'item_category',
        'item_name', 'item_description', 'item_location', 'map_display', 'item_address', 'item_start_datetime', 'item_end_datetime',
        'item1_image', 'item_url', 'item_org_name', 'item_facebook', 'item_twitter', 'item_instagaram', 'item_status', 'item_remaining','item_code','item_link_slug','item_city','item_state','item_color','item_size','item_country'];

    public function getBuyableIdentifier($options = null) {
        return $this->id;
    }

    public function getBuyableDescription($options = null) {
        return $this->name;
    }

    public function getBuyablePrice($options = null) {
        return $this->price;
    }
        public function insertData($input) {
    	return static::create(array_only($input,$this->fillable));
    }

        /* Wallet */
    public function canBuy(Customer $customer, bool $force = false): bool
    {
        /**
         * If the service can be purchased once, then
         *  return !$customer->paid($this);
         */
        return true;
    }

    public function getAmountProduct(): int
    {
        return dd($this->subtotal());
    }

    public function getMetaProduct(): ?array
    {
        return [
            'title' => 'test',
            'description' => 'test',
        ];
    }

    public function getUniqueId(): string
    {
        return (string)$this->getKey();
    }
/* Fin Wallet */


    public function getGadgetWithTicketsSearch($cat='', $date='', $price='',$catdata='') {
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
        $data = DB::table("gadgets")->select("gadgets.*",
            DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = gadgets.item_unique_id
                GROUP BY event_tickets.event_id) as event_min_price"),
            DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = gadgets.item_unique_id
                GROUP BY event_tickets.event_id) as event_max_price"),
            DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = gadgets.item_category)
                as this_item_category"),
            DB::raw("(SELECT category_image FROM event_category
                WHERE event_category.id = gadgets.item_category)
                as this_item1_image"))
            ->where('item_start_datetime','>=',$start)
            ->orderby('item_start_datetime','asc');
        if(!empty($catdata)){
            $data->whereIn('gadgets.item_category',$catdata);
        }
        $data->where('item_status',1);
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
                    $data->whereBetween('item_start_datetime', [$start, $end] );
                    break;

                case 'tomorrow':
                    $start  = Carbon::today()->addHours(24);
                    $end    = Carbon::today()->addHours(47)->addMinutes(59);
                    $data->whereBetween('item_start_datetime', [$start, $end] );
                    break;

                case 'this_week':
                    $start  = Carbon::now()->startOfweek();
                    $end    = Carbon::now()->endOfweek();
                    $data->whereBetween('item_start_datetime', [$start, $end] );
                    break;

                case 'this_month':
                    $start  = Carbon::now()->startOfMonth();
                    $end    = Carbon::now()->endOfMonth();
                    $data->whereBetween('item_start_datetime', [$start, $end] );
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
                    $data->whereBetween('item_start_datetime', [$start, $end] );
                    break;

                default:
                    break;
            }
        }


        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $data->where('gadgets.item_name','LIKE','%'.$_GET['search'].'%');
        }
        $data->whereNull('item_code');

        if(isset($_GET['location']) && !empty($_GET['location'])){
            $reo = str_replace('%',',',$_GET['location']);
            $log = addressFormLagLong($reo);
            $data->where('gadgets.item_location','LIKE','%'.$log->location.'%');
        }
        return $data
            //->orderBy('item_start_datetime', 'asc')
            ->paginate(15);
    }

     public function geteventwithtickets() {
        $data = DB::table("gadgets")->select("gadgets.*","frontusers.firstname as fnm","frontusers.lastname as lnm","frontusers.email as email",
        DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = gadgets.item_unique_id
                GROUP BY event_tickets.event_id) as event_min_price"),
        DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = gadgets.item_unique_id
                GROUP BY event_tickets.event_id) as event_max_price"))
        ->join('frontusers','frontusers.id','=','gadgets.item_create_by')
        ->where('item_status','1')
        ->orWhere('item_status','0');

        if (isset($_GET['fuser']) && !empty($_GET['fuser'])) {
            $datas = explode(' ', $_GET['fuser']);
            $data = $data->where('frontusers.firstname','LIKE','%'.$datas[0].'%');
            $data = $data->where('frontusers.lastname','LIKE','%'.$datas[1].'%');
        }
        if (isset($_GET['duration']) && !empty($_GET['duration'])) {
            if ($_GET['duration'] == 'Current') {
                $datas      = Carbon::now();
                $data = $data->where('item_start_datetime','<=',$datas);
                $data = $data->where('item_end_datetime','>=',$datas);
            }
            if ($_GET['duration'] == 'Upcoming') {
                $datas = Carbon::now();
                $data = $data->where('item_start_datetime','>=',$datas);
            }
        }
        if (isset($_GET['status']) && !empty($_GET['status']) ) {
            if ($_GET['status'] == 'Publish') {
                $data = $data->where('item_status','LIKE','%'.'1'.'%');
            }
            if ($_GET['status'] == 'Draft') {
                $data = $data->where('item_status','LIKE','%'.'0'.'%');
            }
            if ($_GET['status'] == 'Ban') {
                $data = $data->where('gadgets.ban','LIKE','%'.'1'.'%');
            }
        }
        return $data
        ->orderby('created_at','desc')
        ->paginate(15);
    }

    public function hits_all_events() {
        $start  = Carbon::today();
        return $data = DB::table("gadgets")
            ->select("gadgets.*",
                DB::raw("(SELECT COUNT(hits.event_id) FROM hits
                    WHERE hits.event_id = gadgets.item_unique_id
                    GROUP BY hits.event_id)  as hitsRec" ),
                DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = gadgets.item_unique_id
                GROUP BY event_tickets.event_id) as event_min_price"),
                DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = gadgets.item_unique_id
                GROUP BY event_tickets.event_id) as event_max_price"),
                DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = gadgets.item_category)
                as this_event_category"))
            ->where('ban',0)
            ->where('item_start_datetime','<=', $start )
            //->take(6)
            ->orderby('item_start_datetime','desc')
            ->get();
    }

        public static  function getCategoryById($id){
        if($id == 1) {
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
        }
    }


    public function getsingleevent($slug){
        $data = DB::table("gadgets")
        ->select("gadgets.*","organizations.profile_pic","organizations.organizer_name as org_name","organizations.about_organizer as org_about","organizations.url_slug as org_slug","organizations.user_id",
        DB::raw("(SELECT MIN(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = gadgets.item_unique_id
                GROUP BY event_tickets.event_id) as event_min_price"),
        DB::raw("(SELECT MAX(event_tickets.ticket_price_buyer) FROM event_tickets
                WHERE event_tickets.event_id = gadgets.item_unique_id
                GROUP BY event_tickets.event_id) as event_max_price"),
         DB::raw("(SELECT category_name FROM event_category
                WHERE event_category.id = gadgets.item_category)
                as this_event_category"))

        ->leftjoin('organizations','organizations.id','=','gadgets.item_org_name')
        ->where('item_slug',$slug)->first();
        return $data;
    }

    public function findData($id) {
        return static::where('item_unique_id',$id)->first();
    }

    public function updateData($id,$input) {
        return static::where('item_unique_id',$id)->update(array_only($input,$this->fillable));
    }


    
}

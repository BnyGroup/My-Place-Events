<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;
use App\ModalAPI\Event;
use App\ModalAPI\Booking;
use App\ModalAPI\orderTickets;
use App\ModalAPI\EventTicket;
use Auth;
use App\ModalAPI\Bookmark;
use App\ModalAPI\EventCategory;

class EventlistController extends UserController
{
    public function __construct()
    {
        $this->event = new Event;
        $this->orderTicket = new orderTickets;
        $this->eventTicket = new EventTicket;
        $this->event_book = new Booking;
        $this->event_save = new Bookmark;
        $this->event_category = new EventCategory;
    }

    /* feature event list */
    public function featureeventlist()
    {
        if (auth()->check()) {

            $id = Auth::user()->id;
          	$data = $this->event->getfeatureevent();
            $savedeve = $this->event_save->getBookListeve($id);

             $result_array = array();
              foreach ($savedeve as $each_number) {
                  $result_array[] = (int) $each_number;
              }

            $datas = array();
            foreach ($data as $key => $value) {
                $datas[$key]['event_unique_id'] = $value->event_unique_id;
                $datas[$key]['event_image'] = getImage($value->event_image, 'resize');
                $datas[$key]['event_name'] = $value->event_name;
                $datas[$key]['event_start_datetime'] = $value->event_start_datetime;
                $datas[$key]['event_location'] = $value->event_location;
                $datas[$key]['event_slug'] = route('events.details',$value->event_slug);
                
                if(in_array($value->event_unique_id,$result_array)){
                    $datas[$key]['liked'] = 1;
                }else{
                    $datas[$key]['liked'] = 0;
                }
            }
            
            if (empty($datas)) {
                return response()->json($this->notFound(),204);    
            }
            return response()->json($this->getSuccessResult($datas),200);
        } else {

            return response()->json($this->getErrorMessage('462'));
        }
    }
    /* single event */
    public function single_event($id)
    {
        if (auth()->check()) {
            $user_id = Auth::user()->id;
            
          	$data = $this->event->getsingle_event($id);
            $datas =  $this->event_save->getData($id,$user_id);
            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            if(! is_null($datas)){
                $data['liked'] = 1;
            }else{
                $data['liked'] = 0;
            }
            $data['event_image'] = getImage($data['event_image'], 'resize');
            $data['url_slug'] = route('org.detail',$data['url_slug']);
            $data['event_slug'] = route('events.details',$data['event_slug']);


            $location = getLatLong($data['event_location']);
            // $address = $data['event_location'];
            // $address = 'Ashton Road, Bristol BS3 2EA, United Kingdom';
            // $latLong = getLatLong($address);
            // return response()->json($latLong);
            $data['latitude'] = isset($location->lat)?$location->lat:'';
            $data['longitude'] = isset($location->long)?$location->long:'';

            return response()->json($this->getSuccessResult($data),200);

        } else {

            return response()->json($this->getErrorMessage('462'));
        }
    }

    /* single_event_ticket */
    public function single_event_ticket($event_id)
    {
        if (auth()->check()) {
            $user_id = Auth::user()->id;
            
          	$ddata  =  $this->event->get_single_event_data($event_id);

            $ticketdata = $this->eventTicket->getsingle_event_ticket($event_id);

            $data = array();
            $data['event'] = $ddata;
            foreach ($ticketdata as $key => $value) {
                $data['tickets'][$key] = $value;
            }

            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            return response()->json($this->getSuccessResult($data),200);

        } else {

            return response()->json($this->getErrorMessage('462'));
        }
    }

    /* particular user upcoming events for api*/
 	public function upcomingEvents()
 	{
        if (auth()->check()) {

            $user_id = Auth::user()->id;

            $data = $this->event_book->upcoming_tikcets_events($user_id);
            foreach ($data as $key => $value) {
                $data[$key]['event_image'] = getImage($value->event_image);
            }
            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            return response()->json($this->getSuccessResult($data),200);

        } else {

            return response()->json($this->getErrorMessage('462'));
        }
 	}

    /* particular user past event */
    public function pastEvents()
 	{
        if (auth()->check()) {

            $id = Auth::user()->id;
          $data = $this->event_book->past_event($id);
        foreach ($data as $key => $value) {
         $data[$key]['event_image'] = getImage($value->event_image);
             }
            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);
            }
            return response()->json($this->getSuccessResult($data),200);

        } else {

            return response()->json($this->getErrorMessage('462'));
        }
 	}

    /*API For Today Events */
    public function todayEvents($cid='')
    {
        if (auth()->check()) {
            $id = Auth::user()->id;
            $data = $this->event->gettodayevent($cid);
            $book =  $this->event_save->getBookListeve($id);
            $data = array_flatten($data);
            foreach ($data as $key => $value) {
               $data[$key]['event_image'] = getImage($value->event_image);
               if(in_array($value->event_unique_id,$book)){
                    $data[$key]['liked'] = 1;
               }else{
                    $data[$key]['liked'] = 0;
               }
            }
            if (empty($data)) {
                // return response()->json(['msg'=>'No Content'],204);
                return response()->json($this->notFound());
            }
            return response()->json($this->getSuccessResult($data),200);
        } else {

            return response()->json($this->getErrorMessage('462'));
        }
    }

    /*API for Tomorrow Events*/
     public function tomorrowEvents($cid='')
    {
        if (auth()->check()) {
            $id = Auth::user()->id;
            $data = $this->event->gettomorrowevents($cid);
            $book =  $this->event_save->getBookListeve($id);
            $data = array_flatten($data);
            foreach ($data as $key => $value) {
               $data[$key]['event_image'] = getImage($value->event_image);
               if(in_array($value->event_unique_id,$book)){
                    $data[$key]['liked'] = 1;
               }else{
                    $data[$key]['liked'] = 0;
               }
            }
            if (empty($data)) {
                return response()->json($this->notFound());    
            }
            return response()->json($this->getSuccessResult($data),200);
        } else {

            return response()->json($this->getErrorMessage('462'));
        }
    }

/*API for Thisweek Events*/
    public function thisweekEvents($cid='')
    {
        if (auth()->check()) {
            $id = Auth::user()->id;
            $data = $this->event->getthisweekevents($cid);
            $book =  $this->event_save->getBookListeve($id);
            $data = array_flatten($data);
            foreach ($data as $key => $value) {
               $data[$key]['event_image'] = getImage($value->event_image);
               if(in_array($value->event_unique_id,$book)){
                    $data[$key]['liked'] = 1;
               }else{
                    $data[$key]['liked'] = 0;
               }
            }
            if (empty($data)) {
                return response()->json($this->notFound());
            }
            return response()->json($this->getSuccessResult($data),200);
        } else {

            return response()->json($this->getErrorMessage('462'));
        }
    }


public function categorywiseevent($id){
    if (auth()->check()) {
        $user_id = Auth::user()->id;
        //$ddata  =  $this->event_category->getcategory($id);
        $eventdata = $this->event->getcategorywiseeventapi($id);        
        // dd($eventdata);
        $book =  $this->event_save->getBookListeve($user_id);
        $data = array();        
            foreach ($eventdata as $key => $value) {
                $data['event'][$key] = $value;
                $data['event'][$key]['event_image'] = getImage($value->event_image);
                if(in_array($value->event_unique_id,$book)){
                    $data['event'][$key]['liked'] = 1;
               }else{
                    $data['event'][$key]['liked'] = 0;
               }
            }
        // dd($eventdata);
        if (empty($data)) {
            return response()->json($this->notFound());
        }
        return response()->json($this->getSuccessResult($eventdata),200);
    } else {
        return response()->json($this->getErrorMessage('462'));
    }
}


 	/* particular user saved events for api*/
 	public function savedEvents()
 	{
        if (auth()->check()) {

           $user_id = Auth::user()->id;

            $data = $this->event_save->saved_events($user_id);
             foreach ($data as $key => $value) {
                $data[$key]['event_image'] = getImage($value->event_image);
            }
            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            return response()->json($this->getSuccessResult($data),200);

        } else {

            return response()->json($this->getErrorMessage('462'));
        }
 	}


    /* select category  events for api*/
    public function category_event()
    {
        if (auth()->check()) {

           $user_id = Auth::user()->id;

          $data = $this->event_category->get_Category_eventAPI();
            // foreach ($data as $key => $value) {
            // $data[$key]['category_image'] = getImage($value->category_image);
            //     foreach ($value->children as $skey => $svalue) {
            //     if(!$value->children->isEmpty()){
            //        $data[$skey]['category_image'] = getImage($svalue->category_image);  
            //     }
            // }
            // }
            if (empty($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            return response()->json($this->getSuccessResult($data),200);

        } else {
            return response()->json($this->getErrorMessage('462'));
        }
    }
    
    public function savedBookmark(Request $request,$action)
    {
        $input = $request->all();
         
        if (auth()->check()) {
            if ($action != 0) {
                $this->event_save->createData($input);
                return response()->json(['status' => ['code' => 200 ,'msg' => 'Event saved successfully.']],200);
            }else{
                $eid = $input['event_id'];
                $uid = $input['user_id'];
                $this->event_save->removeData($eid,$uid);
                return response()->json(['status' => ['code' => 200 ,'msg' => 'Event removed successfully.']],200);
            }
        }
    }    
}

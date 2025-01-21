<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = 'event_bookmark';
    protected $fillable = ['event_id','user_id'];


    /*============================ API DATA ==========================*/
        public function saved_events($user_id) {
            return static::select('event_bookmark.user_id','event_category.category_name',
                'events.id','events.event_unique_id','events.event_name',
                'events.event_location',
                'events.event_start_datetime','events.event_image')
            ->join('events','events.event_unique_id','=','event_bookmark.event_id')
            ->join('event_category','event_category.id','=','events.event_category')
            ->where('event_bookmark.user_id',$user_id)
            ->paginate(15);
        }

        public function getBookListeve($user_id) {
            return static::where('user_id',$user_id)->pluck('event_id')->toArray();
        }

        public function getData($eid,$uid) {
        	return static::where('event_id',$eid)->where('user_id',$uid)->first();
        }

        public function createData($input) {
        	return static::create(array_only($input,$this->fillable));
        }

        public function removeData($eid,$uid) {
        	return static::where('event_id',$eid)->where('user_id',$uid)->delete();
        }
    /*============================ API DATA ==========================*/

}

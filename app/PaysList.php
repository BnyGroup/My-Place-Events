<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PaysList extends Model
{
    //
    public function getCountryList(){
        return DB::table("pays_lists")->select('pays_lists.nom_pays', 'pays_lists.id_pays')->orderBy('nom_pays', 'asc')->get();
    }

    /*public function getCategoryList()
    {
        return $categories = EventCategory::get_Category_event();
    }
    */

    public function get_pays_event() {
        return static::get();
    }

}

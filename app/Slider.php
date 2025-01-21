<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    //
    protected $fillable = [
        'slide_title', 'slide_desc', 'slide_img','slide_img_url','slide_text_btn', 'slide_btn_url', 'slide_status','date_demarre','date_derniere_pause','date_fin','admin_id','id_frontuser',
        'id_panier_malu','id_last_transaction'
    ];

//    public $timestamps = false;

    public function insertData($input)
    {
        return static::create(array_only($input,$this->fillable));
    }

    public function updatData($input, $id)
    {
        return static::find($id)->update(array_only($input,$this->fillable));
    }

    public function getList()
    {
        return static::where('slide_status',"1")
            ->get();
    }

}

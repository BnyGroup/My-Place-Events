<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class StoreRegularise extends Model
{
    //
    protected $fillable = [
        'order_id','order_tickets','event_booking'
    ];

    public $timestamps = false;

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
        return static::where('status',"1")->get();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $fillable = [
        'service_title','service_short_desc','service_description', 'service_icon', 'service_status'
    ];


    public function insertData($input)
    {
        return static::create(array_only($input,$this->fillable));
    }

    public function getserviceslist(){
        return static::select("services.*")
            ->get()
            ->paginate(15);
    }

    public function updatData($input, $id)
    {
        return static::find($id)->update(array_only($input,$this->fillable));
    }

    public function getList()
    {
        return static::where('service_status', "1")->get();
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebTv extends Model
{
    //
    protected $table='webtv';
    protected $fillable = ['status','titre','lien_video','lien_poster'];


    public function insertData($input)
    {
        return static::create(array_only($input, $this->fillable));
    }

    public function getserviceslist()
    {
        return static::select("services.*")
            ->orderBy('id', 'asc')
            ->get()
            ->paginate(15);
    }

    public function updatData($input, $id)
    {
        return static::find($id)->update(array_only($input, $this->fillable));
    }

    public function getList()
    {
        return static::where('status', "1")
            ->orderBy('id','asc')
            ->get();
    }

}

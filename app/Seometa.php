<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Seometa;

class Seometa extends Model
{
    protected $table = 'seometas';

    protected $fillable = [
        'name', 'slug', 'value','title','desc','keyword',
    ];

    public function getSettings()
    {
        $data = Seometa::get()->toArray();
        $result = [];
        foreach ($data as $key => $value) {
            $result[$value['slug']] = $value;
        }
        return $result;
    }

    public function updateSettings($input,$key)
    {
        Seometa::where('slug',$key)->update(['title'=>$input['title'],'desc'=>$input['desc'],'keyword'=>$input['keyword']]);  
        return;
    }    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Realisation extends Model
{
    //
    protected $fillable = ['id_prestataire','realisation','descriptions'];

    public function insertData($input)
    {
        return static::create(array_only($input,$this->fillable));
    }

    public function getById($id){
        return static::where('id_prestataire', $id)->get();
    }

    public function deleteData($id)
    {
        $data = static::where('id',$id)->first();
        if(!empty($data)){
            $data['realisation'] = str_replace('public','',$data['realisation']);
            if(!empty($data['realisation']))
            {
                if(\File::exists(public_path($data['realisation']))) {
                    \File::delete((public_path($data['realisation'])));
                }
            }
            return $data->delete();
        }else{
            return 2;
        }
    }

}

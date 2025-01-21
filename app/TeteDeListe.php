<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeteDeListe extends Model
{
    //
    protected $table = 'tete_de_listes';
    protected $fillable = [
        'id_frontuser', 'id_admin', 'id_panier_malu','url_entete','image_entete', 'status','id_last_transaction'
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

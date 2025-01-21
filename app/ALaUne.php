<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImageUpload;
use DB;

class ALaUne extends Model
{
    //
    protected $table = 'panier_malu';
    protected $fillable = ['id_frontuser','type_service','duree_service','date_demarre','date_fin','image_slide_entete','image_slide','titre_slide','description_slide',
        'url_entete_slide','slide_btn_text','montant','slug','status_service','status_admin','id_last_transaction'];

    public function getData(){
        return static::get();
    }

    public function getdatawithusername(){
        $data = DB::table("panier_malu")->select("panier_malu.*","frontusers.firstname as fnm","frontusers.lastname as lnm")
            ->join('frontusers','frontusers.id','=','panier_malu.id_frontuser');
        return $data->get();
    }

    public function getDataById($id){
        return static::where('id_frontuser', $id)
        ->get();
    }

    public function getDataByServiceId($id){
        return static::where('id', $id)
            ->first();
    }

    public function findDataSlug($slug)
    {
        return static::where('slug',$slug)
            ->first();
    }

    public function insertData($input)
    {
        return static::create(array_only($input,$this->fillable));
    }

    public function updateData($id,$input)
    {
        return static::where('id',$id)->update(array_only($input,$this->fillable));
    }

    public function deleteData($id)
    {
        $data = static::where('id',$id)->first();

        $data['image_slide_entete'] = str_replace('public','',$data['image_slide_entete']);
        if(!empty($data['image_slide_entete']))
        {
            if(\File::exists(public_path($data['image_slide_entete']))) {
                \File::delete((public_path($data['image_slide_entete'])));
            }
        }
        return $data->delete();
    }

    public function RecupDate($id){
        $data = DB::table('panier_malu')
            ->whereId($id)
            ->select('DAY(updated_at) as jours, MONTH(updated_at) as mois, YEAR(updated_at) as annee');
        return $data->get();
    }
}

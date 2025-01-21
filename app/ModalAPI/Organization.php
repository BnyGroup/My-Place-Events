<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;
use App\ImageUpload;
use File;
class Organization extends Model
{
    protected $fillable = ['profile_pic','organizer_name','about_organizer','display_dis','website','facebook_page','twitter','status','user_id','url_slug','org_link_slug'];

    /*============================ API DATA ==========================*/
    public function findDataId($id)
    {
        return static::select('organizations.*','frontusers.firstname as fnm','frontusers.lastname as lnm')
            ->join('frontusers','frontusers.id','=','organizations.user_id')
            ->where('organizations.id',$id)->first();
    }
    /*============================ API DATA ==========================*/
}

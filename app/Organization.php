<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImageUpload;
use File;
class Organization extends Model
{
    protected $fillable = ['profile_pic','cover','organizer_name','about_organizer','display_dis','website','facebook_page','twitter','status','user_id','url_slug','org_link_slug','instagram'];

	public function insertData($input)
	{
		return static::create(array_only($input,$this->fillable));
	}
	public function getAllist($id)
	{
		return static::where('user_id',$id)->get();
	}
	public function findDataSlug($slug)
	{
		return static::select('organizations.*','frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email','frontusers.cellphone')
			->leftjoin('frontusers','frontusers.id','=','organizations.user_id')
			->where('url_slug',$slug)->first();
	}

    public function findDataSlugURL($slug)
    {
        return static::select('organizations.*','frontusers.firstname as fnm','frontusers.lastname as lnm')
            ->leftjoin('frontusers','frontusers.id','=','organizations.user_id')
            ->where('org_link_slug',$slug)->first();
    }
    
    public function findDataId($id)
    {
        return static::select('organizations.*','frontusers.firstname as fnm','frontusers.lastname as lnm','frontusers.email as mail')
            ->join('frontusers','frontusers.id','=','organizations.user_id')
            ->where('organizations.id',$id)->first();
    }

	public function updateorgrData($id,$input)
	{
		return static::where('id',$id)->update(array_only($input,$this->fillable));
	}
	public function getData()
	{
		return static::get();
	}
	public function deleteData($id)
    {
        $data = static::where('id',$id)->first();

        if(!empty($data['profile_pic']))
        {
          $datas = image_delete($data['profile_pic']);
            $path = $datas['path'];
            $image = $datas['image_name'];
            $image_thum = $datas['image_thumbnail'];
            ImageUpload::removeFile($path,$image,$image_thum);
        }
        return $data->delete();
    }  
    public function pulcklists($id)
    {
    	return static::where('user_id',$id)->pluck('organizer_name','id');
    }
    public function getDatawithUser()
    {
    	return static::select('organizations.*','frontusers.firstname as fnm','frontusers.lastname as lnm')
    	->join('frontusers','frontusers.id','=','organizations.user_id')
    	->get();
    }
    
     public function orgList($id)
    {
        return static::select('organizer_name','id')->where('user_id',$id)
        ->where('status',1)
        ->get();
    }

       public function orgName($id)
    {
        return static::select('organizer_name','id')->where('id',$id)
        ->first();
    }
    public function getDataUser($id)
    {
    	return static::select('organizations.*','frontusers.firstname as fnm','frontusers.lastname as lnm')
    		->join('frontusers','frontusers.id','=','organizations.user_id')
    		->where('organizations.id',$id)
    		->first();
    }
}

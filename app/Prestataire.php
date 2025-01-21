<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImageUpload;
use File;
use DB;

class Prestataire extends Model
{
    protected $fillable = ['id_frontusers','pseudo','firstname','lastname','status','profile_pic','cover','activites','descriptions','affiche_desc','indicatif_1','telephone_1','indicatif_2','telephone_2','adresse_mail','pays','ville','adresse_geo','latitude','longitude','map_display','website','facebook','twitter','messenger','google','instagram','youtube','url_slug','payment_id','payment_state','payment_gateway',
        'payment_amount','payment_date','top'];

    public function insertData($input)
    {
        return static::create(array_only($input,$this->fillable));
    }

    public function getDataByPrestId($id){
        return static::where('id',$id)
            ->first();
    }

    public function getAllist($id)
    {
        return static::where('id_frontusers',$id)->get();
    }
    public function findDataSlug($slug)
    {
        return static::select('prestataires.*','frontusers.firstname as fnm','frontusers.lastname as lnm')
            ->leftjoin('frontusers','frontusers.id','=','prestataires.id_frontusers')
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
        return static::select('organizations.*','frontusers.firstname as fnm','frontusers.lastname as lnm')
            ->join('frontusers','frontusers.id','=','organizations.user_id')
            ->where('organizations.id',$id)->first();
    }

    public function updatepreData($slug,$input)
    {
        return static::where('url_slug',$slug)->update(array_only($input,$this->fillable));
    }
    public function getData()
    {
        return static::get();
    }

    public function getPaidData(){
        return static::where('status','!=','3')
            ->get();
    }

    public function getDatas($id) {
        $data = DB::table("prestataires")
            ->select("prestataires.*","frontusers.firstname as fnm","frontusers.lastname as lnm")
            ->join('frontusers','frontusers.id','=','prestataires.id_frontusers')
            ->where('prestataires.id',$id)
            ->first();
        return $data;
    }
    public function deleteData($slug)
    {
        $data = static::where('url_slug',$slug)->first();

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
    public function getDataUser($id)
    {
        return static::select('organizations.*','frontusers.firstname as fnm','frontusers.lastname as lnm')
            ->join('frontusers','frontusers.id','=','organizations.user_id')
            ->where('organizations.id',$id)
            ->first();
    }

    public function getPrestataireBySearch($nom=null, $cat=null,$pays=null)
    {
        //dd($nom,$pays,$cat);
        if (!empty($cat) && empty($pays) && empty($nom)) {
            $data = static::where('activites',$cat)
                ->where('status',1)
                ->get();
        }
        if (!empty($pays) && empty($cat) && empty($nom)) {
            $data = static::where('adresse_geo','like','%' . $pays . '%')
                ->where('status',1)
                ->get();
        }
        if (!empty($nom) && empty($cat) && empty($pays)) {
            $data = static::where('firstname','like','%' . $nom . '%')
                ->orWhere('lastname','like','%' . $nom . '%')
                ->where('status',1)
                ->get();
        }
        if (!empty($nom) && !empty($pays) && !empty($cat)) {
            $data = static::whereFirstname('%' . $nom . '%')
                ->whereActivites($cat)
                ->where('adresse_geo', '%' . $pays . '%')
                ->where('status',1)
                ->get();
        }
        if (empty($nom) && !empty($pays) && !empty($cat)) {
            $data = static::where('activites',$cat)
                ->where('adresse_geo','like', '%' . $pays . '%')
                ->where('status',1)
                ->get();
        }
        if (!empty($nom) && empty($pays) && !empty($cat)) {
            $data = static::where('firstname','like','%' . $nom . '%')
                ->orWhere('lastname','like','%' . $nom . '%')
                ->where('activites',$cat)
                ->where('status',1)
                ->get();
        }
        if (!empty($nom) && !empty($pays) && empty($cat)) {
            $data = static::where('firstname','like','%' . $nom . '%')
                ->orWhere('lastname','like','%' . $nom . '%')
                ->where('adresse_geo','like','%' . $pays . '%')
                ->where('status',1)
                ->get();
        }

        return $data;

    }

    public function getHomePrest(){
        return static::where('status',1)
            ->orderBy('id','DESC')
            ->limit(4)
            ->get();
    }
	
	public function getPrestListByCat($cat)
    {

        $data = DB::table("prestataires")->select("prestataires.*",
            DB::raw("(SELECT prestataire_category.category_name FROM prestataire_category
                WHERE prestataire_category.id = prestataires.activites)
                as this_prestataire_category"))
            ->orderby('prestataires.id', 'DESC');

        $data->where('prestataires.status', 1);

         
        if ($cat != '') {
            $catdata = DB::table('prestataire_category')->where('prestataire_category.id', $cat)->get();
            $ids = array();
            foreach ($catdata as $key => $value) {
                $ids[] = $value->id;
            }
            //dd($ids);
            $cids = array_push($ids, $cat);
            $data->whereIn('activites', $ids);
        }
          
            
         return $data->paginate(6);
    }    
	
	public function getPrestListByCatTop($cat)
    {

        $data = DB::table("prestataires")->select("prestataires.*",
            DB::raw("(SELECT prestataire_category.category_name FROM prestataire_category
                WHERE prestataire_category.id = prestataires.activites)
                as this_prestataire_category"))
			->where('prestataires.top',1)
            ->orderby('prestataires.id', 'DESC');

        $data->where('prestataires.status', 1);

         
        if ($cat != '') {
            $catdata = DB::table('prestataire_category')->where('prestataire_category.id', $cat)->get();
            $ids = array();
            foreach ($catdata as $key => $value) {
                $ids[] = $value->id;
            }
            //dd($ids);
            $cids = array_push($ids, $cat);
            $data->whereIn('activites', $ids);
        }
          
            
         return $data->paginate(6);
    }    
}

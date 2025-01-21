<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Mail;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\RouteCollection;
use Illuminate\Http\Request;
use Hash;
use File;
use Carbon\Carbon;
use App\ImageUpload;
use App\Role;
use App\Permission;

/*use Corcel\Model\Post;*/
use Zebra_Pagination;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use App\BannerImmanquables;

use App\Helpers\FlashMsg;
use App\Http\Controllers\Controller;

class BannerImmanquablesStoreController{
 
     public function __construct() {
        //parent::__construct();
        view()->share('AdminTheme','AdminTheme.master');
     }
     
     public function index(){
         
        $data=BannerImmanquables::orderby("idb","desc")->get();
        return view('Admin.bannerimmanquables.index',compact('data'));
         
     }
 
 
     public function add(Request $request){

 

        $path = 'upload/bannerimmanquables/'.date('Y').'/'.date('m');
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }

        if(!empty($request->file('image'))){
			$input = $request->all();
			$fileImg = array();
            $iinput['image'] = ImageUpload::upload($path,$request->file('image'),'banner-immanquables');
            //ImageUpload::uploadThumbnail($path,$iinput['event_image'],250,130,'thumb');
            //ImageUpload::uploadThumbnail($path,$iinput['event_image'],800,400,'resize');
            list($width, $height, $type, $attr) = getimagesize($request->file('image'));
            ImageUpload::uploadThumbnail($path,$iinput['image'],360,360,'thumb');
 
        	$imgName = save_image($path,$iinput['image']); 
        	$data=[
        	    "title"=> $request->titre,
        	    "description" => $request->description,
        	    "image"=> $imgName,
        	    "statut"=>$request->statut,
        	    "url"=>$request->url
        	    ];
			$data = BannerImmanquables::insert($data); 
			return redirect()->back()->with('success','La bannière a été enregistrée avec succès.');
        }else{
			echo'Error';
		}
		
		return redirect()->back()->with('error','La bannière n\'a pu être enregistrée.');
         
     }
     

     public function edit(Request $request){
         $path = 'upload/bannerimmanquables/'.gmdate('Y').'/'.gmdate('m');
        if(!is_dir(public_path($path))){
            File::makeDirectory(public_path($path),0777,true);
        }
		$input = $request->all();
        if(!empty($request->idb)){
            
             if(!empty($request->file('image'))){
			 $fileImg = array();
             $iinput['image'] = ImageUpload::upload($path,$request->file('image'),'banner-immanquables');
             //ImageUpload::uploadThumbnail($path,$iinput['event_image'],250,130,'thumb');
             //ImageUpload::uploadThumbnail($path,$iinput['event_image'],800,400,'resize');
             list($width, $height, $type, $attr) = getimagesize($request->file('image'));
             ImageUpload::uploadThumbnail($path,$iinput['image'],360,360,'thumb');
 
        	 $imgName = save_image($path,$iinput['image']); 
        	 $data=[
        	    "title"=> $request->titre,
        	    "description" => $request->description,
        	    "image"=> $imgName,
        	    "statut"=>$request->statut,
        	    "url"=>$request->url
        	    ];
            }else{
            
        	$data=[
        	    "title"=> $request->titre,
        	    "description" => $request->description,
        	    "statut"=>$request->statut,
        	    "url"=>$request->url
        	    ];
            }
            
			$data = BannerImmanquables::where("idb",$request->idb)->update($data); 
			return redirect()->back()->with('success','La bannière a été mises à jour avec succès.');
        }else{
			echo'Error';
		}
		
		return redirect()->back()->with('error','La bannière n\'a pu être enregistrée.');
         
     }     
     
     public function getdatas(Request $request){
         $id=$request->idb;
         $data=BannerImmanquables::where("idb",$id)->first();
         $im= getImage($data->image);
         $data["imgs"]=$im;
         return response()->json($data);
     }
     
     

     public function delete(Request $request){
    $id = $request->idb;

    if (!empty($id)) {
        $data = BannerImmanquables::where("idb", $id)->first();

        if ($data) {
            // Optionally delete the associated image file
            if (!empty($data->image) && file_exists(public_path($data->image))) {
                File::delete(public_path($data->image));
            }

            // Delete the banner from the database
            BannerImmanquables::where("idb", $id)->delete();

            return redirect()->back()->with('success', 'La bannière a été supprimée avec succès.');
        } else {
            return redirect()->back()->with('error', 'La bannière sélectionnée est introuvable.');
        }
    } else {
        return redirect()->back()->with('error', 'Merci de choisir une bannière à supprimer.');
    }
}

    /* public function delete($id)
{
    $data = BannerImmanquables::find($id);

    if ($data) {
        $data->delete();
        return redirect()->back()->with('success', 'La bannière a été supprimée avec succès.');
    } else {
        return redirect()->back()->with('error', 'La bannière n\'existe pas.');
    }
} */


/*
     public function delete(Request $request)
{
    $id = $request->idb;

    if (!empty($id)) {
        $data = BannerImmanquables::where("idb", $id)->first();

        if ($data) {
            // Suppression du fichier image si présent
            if (!empty($data->image) && file_exists(public_path($data->image))) {
                File::delete(public_path($data->image));
            }

            // Suppression de la bannière dans la base de données
            BannerImmanquables::where("idb", $id)->delete();

            return redirect()->back()->with('success', 'La bannière a été supprimée avec succès.');
        } else {
            return redirect()->back()->with('error', 'La bannière sélectionnée est introuvable.');
        }
    } else {
        return redirect()->back()->with('error', 'Merci de choisir une bannière à supprimer.');
    }
} */


    

     
}

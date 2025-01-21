<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;

use App\Event;
use App\EventCategory;
use App\ImageUpload;
use Hash;
use File;

class EventCategoriesController extends AdminController
{
    public function __construct() {
    	parent::__construct();
    	$this->event = new Event;
    	$this->event_category = new EventCategory;
    }

    public function index() {
    	$data = $this->event_category->get_Category_event();
    	return view('Admin.Event.categorydisplay',compact('data')); 	
    }

    public function create()
    {
    	$data = $this->event_category->getCategorylist();
    	return view('Admin.Event.categorycreate',compact('data'));
    }

    public function store(Request $request)
    {
    	$input = $request->all();

    	$this->validate($request, [
    		'category_name'	=> 'required',    		
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    		'category_description' => 'required'
    	]);

    	$input['category_slug'] = str_slug($input['category_name']);

    	$path = 'upload/admin/'.date('Y').'/'.date('m'); 

        
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }

        if (!empty($request->file('image'))) {

            $iinput['image'] = ImageUpload::upload($path,$request->file('image'),'event-category');
            ImageUpload::uploadThumbnail($path,$iinput['image'],330,220);  
            ImageUpload::uploadThumbnail($path,$iinput['image'],690,220,'resize');  
                                
        	$input['category_image'] = save_image($path,$iinput['image']);
        }
        
        $data = $this->event_category->insertData($input);
        return redirect()->route('categories.index')->with('success', 'Event Categorie is Created.');

    }
    public function edit($id)
    {
    	$category 		= $this->event_category->getSingleCategory($id);
    	$partent_cat	= $this->event_category->getCategorylist();
    	return view('Admin.Event.categoryedit',compact('category', 'partent_cat'));
    }
    public function update(Request $request, $id)
    {

    	$input = $request->all();
     
    	$this->validate($request, [
    		'category_name'	=> 'required',    		
    		'image'     	=> 'image|mimes:jpeg,png,jpg,gif|max:2048',
    	]);

    	$input['category_slug'] = str_slug($input['category_name']);

    	$path = 'upload/admin/'.date('Y').'/'.date('m'); 
        
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }

        if (!empty($request->file('image'))) {
           
           $iinput['image'] = ImageUpload::upload($path,$request->file('image'),'event-category');
          
            ImageUpload::uploadThumbnail($path,$iinput['image'],330,220);  
            ImageUpload::uploadThumbnail($path,$iinput['image'],690,220,'resize');
         
            $input['category_image'] = save_image($path,$iinput['image']);
            $data = image_delete($input['old_image']);


            $path = $data['path'];

            $image = $data['image_name'];
            $image_thum = $data['image_thumbnail'];
            $image_resize = 'resize-'.$data['image_name'];
            ImageUpload::removeFile($path,$image,$image_thum,$image_resize);

        } else {
            if (!empty($input['old_image'])) {
                $input['category_image'] = $input['old_image'];
            }
        }
        
    	$data = $this->event_category->updatData($input, $id);
        
       	return redirect()->route('categories.index')->with('success', 'Event Categorie has been Updated.');

    }

    public function remove($id)
    {
        $data = $this->event->checkEvent($id);
        $datas = $this->event_category->checkSubcat($id);

        if (!empty($data)) {
          return redirect()->back()->with('error','This category has events and therefore cannot be deleted.');
        }
        if (!is_null($datas)) {
            return redirect()->back()->with('error','Frist Child Categories then you have to delete Parent Categories.');
        }
        if (empty($data) && empty($datas)) {
            EventCategory::where('id',$id)->delete();
            return redirect()->back()->with('success','Categories Delete Successfully.');
        }
        
    }
}

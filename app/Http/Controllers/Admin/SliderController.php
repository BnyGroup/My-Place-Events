<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;

use App\Role;
use File;
use App\Permission;
use App\ImageUpload;
use App\Slider;
use DB;
use Hash;


class SliderController extends AdminController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->sliders = new Slider;
    }

    public function index(Request $request)
    {
        $sliders = Slider::orderBy('id','ASC')->paginate(10);
        return view('sliders.index',compact('sliders'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permission = Permission::get();
        return view('sliders.create',compact('permission'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'slide_status'	=> 'required',
            'slide_img'         => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'slide_desc' => 'required'
        ]);

        $path = 'upload/sliders/'.date('Y').'/'.date('m');
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }


        $input['slide_img_url'] = (isset($input['slide_img_url']))?($input['slide_img_url']):NULL;






        if (!empty($request->file('slide_img'))) {

            $image = $request->file('slide_img');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path($path), $new_name);
            //$iinput['slide_img'] = ImageUpload::upload($path,$request->file('slide_img'),'slider-image');
            //ImageUpload::uploadThumbnail($path,$iinput['slide_img'],330,220);
            //ImageUpload::uploadThumbnail($path,$iinput['slide_img'],1920,600,'resize');

            $input['slide_img'] ='public/'.$path.'/'.$new_name;
        }

        $data = $this->sliders->insertData($input);
        return redirect()->route('sliders.index')->with('success', 'Slider Image is Created.');

    }


    public function show($id)
    {
        $slider = Slider::find($id);
        $sliderPermissions = Permission::join("permission_role","permission_role.permission_id","=","permissions.id")
            ->where("permission_role.role_id",$id)
            ->get();

        return view('sliders.show',compact('slider','sliderPermissions'));
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        $permission = Permission::get();
        $sliderPermissions = DB::table("permission_role")
            ->where("role_id",$id)
            ->pluck('permission_id','permission_id')
            ->all();

        return view('sliders.edit',compact('slider','permission','sliderPermissions'));
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();

        $this->validate($request, [
            'slide_desc'	=> 'required',
            'slide_img'     	=> 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'slide_status' => 'required'
        ]);


        $path = 'upload/sliders/'.date('Y').'/'.date('m');

        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }


        if (!empty($request->file('slide_img'))) {

            $image = $request->file('slide_img');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path($path), $new_name);
            //$iinput['slide_img'] = ImageUpload::upload($path,$request->file('slide_img'),'slider-image');
            //ImageUpload::uploadThumbnail($path,$iinput['slide_img'],330,220);
            //ImageUpload::uploadThumbnail($path,$iinput['slide_img'],1920,600,'resize');

            $input['slide_img'] ='public/'.$path.'/'.$new_name;
            File::delete($input['old_image']);
        } else {
            if (!empty($input['old_image'])) {
                /*$input['slide_img'] = 'public/'.$path.'/'.$input['old_image'];*/
                $input['slide_img'] = $input['old_image'];
                //$data = image_delete($input['slide_img']);
                //$path = $data['path'];
                //$image = $data['image_name'];
                //$image_thum = $data['image_thumbnail'];
                //$image_resize = 'resize-'.$data['image_name'];
                //ImageUpload::removeFile($path,$image,$image_thum,$image_resize);
            }
        }

        $data = $this->sliders->updatData($input, $id);

        return redirect()->route('sliders.index')->with('success', 'The Slider has been Updated.');

    }


    public function remove($id)
    {
        DB::table("sliders")->where('id',$id)->delete();
        return redirect()->route('sliders.index')
            ->with('success','Slider deleted successfully');
    }



}

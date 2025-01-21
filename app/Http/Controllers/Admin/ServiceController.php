<?php

namespace App\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Admin\AdminController;

    use App\Role;
    use File;
    use App\Permission;
    use App\ImageUpload;
    use App\Service;
    use DB;
    use Hash;


class ServiceController extends AdminController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->services = new Service;
    }

    public function index(Request $request)
    {
        $service= Service::orderBy('id', 'ASC')->paginate();
        return view('service.service-display', compact('service'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permission = Permission::get();
        return view('service.service-create', compact('permission'));
    }

    public function show($id)
    {
        $service = Service::find($id);
        $servicePermissions = Permission::join("permission_role", "permission_role.permission_id", "=", "permissions.id")
            ->where("permission_role.role_id", $id)
            ->get();

        return view('Admin.service-display', compact('service', 'servicePermissions'));
    }


    public function store(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'service_title' => 'required',
            'service_status' => 'required',
            'service_description' => 'required',
            'service_short_desc' => 'required'
        ]);

        $path = 'upload/service/' . date('Y') . '/' . date('m');
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }

        if (!empty($request->file('service_icon'))) {


            $iinput['service_icon'] = ImageUpload::upload($path,$request->file('service_icon'),'service-image');
            ImageUpload::uploadThumbnail($path,$iinput['service_icon'],330,220);
            ImageUpload::uploadThumbnail($path,$iinput['service_icon'],690,220,'resize');

            $input['service_icon'] = save_image($path,$iinput['service_icon']);
        }

        $data = $this->services->insertData($input);
        return redirect()->route('service.index')->with('success', 'Service is Created.');

    }

    public function edit($id)
    {
        $service = Service::find($id);
        $permission = Permission::get();
        $servicePermissions = DB::table("permission_role")
            ->where("role_id",$id)
            ->pluck('permission_id','permission_id')
            ->all();

        return view('service.service-edit',compact('service','permission','servicePermissions'));
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();

        $this->validate($request, [
            'service_title' => 'required',
            'service_description' => 'required',
            'service_status' => 'required',
            'service_short_desc' => 'required'
        ]);


        $path = 'upload/service/'.date('Y').'/'.date('m');

        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }

        if (!empty($request->file('service_icon'))) {

            $iinput['service_icon'] = ImageUpload::upload($path,$request->file('service_icon'),'service-image');

            ImageUpload::uploadThumbnail($path,$iinput['service_icon'],330,220);
            ImageUpload::uploadThumbnail($path,$iinput['service_icon'],690,220,'resize');




            $input['service_icon'] = save_image($path,$iinput['service_icon']);
            $data = image_delete($input['old_image']);
            $path = $data['path'];
            $image = $data['image_name'];
            $image_thum = $data['image_thumbnail'];
            $image_resize = 'resize-'.$data['image_name'];
            ImageUpload::removeFile($path,$image,$image_thum,$image_resize);

        } else {

            if (!empty($input['old_image'])) {
                $input['service_icon'] = $input['old_image'];
            }
        }
        $data = $this->services->updatData($input, $id);

        return redirect()->route('service.index')->with('success', 'Le service a été mis à jour.');

    }

    public function remove($id)
    {
        DB::table("services")->where('id', $id)->delete();
        return redirect()->route('service.index')
            ->with('success', 'Service supprimé');
    }
}

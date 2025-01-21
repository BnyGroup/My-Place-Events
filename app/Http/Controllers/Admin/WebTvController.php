<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\WebTV;
use App\Role;
use File;
use App\Permission;
use App\ImageUpload;
use DB;
use Hash;


class WebTvController extends AdminController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->webtv = new WebTV;
    }

    public function index(Request $request)
    {
        $webtv= WebTV::orderBy('id', 'ASC')->paginate(1000);
        return view('Admin.webtv.webtv-index', compact('webtv'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $permission = Permission::get();
        return view('Admin.webtv.webtv-create', compact('permission'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'status'	=> 'required',
            'lien_poster'         => 'url',
            'lien_video' => 'url'
        ]);

        $data = $this->webtv->insertData($input);
        return redirect()->route('webtv.index')->with('success', 'Vidéo ajoutée avec succès.');

    }

    public function show($id)
    {
        $service = Service::find($id);
        $servicePermissions = Permission::join("permission_role", "permission_role.permission_id", "=", "permissions.id")
            ->where("permission_role.role_id", $id)
            ->get();

        return view('Admin.service-display', compact('service', 'servicePermissions'));
    }


    public function edit($id)
    {
        $webtv = WebTV::find($id);
        $permission = Permission::get();
        $servicePermissions = DB::table("permission_role")
            ->where("role_id",$id)
            ->pluck('permission_id','permission_id')
            ->all();

        return view('Admin.webtv.webtv-edit',compact('webtv','permission','servicePermissions'));
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();

        $this->validate($request, [
            'status'	=> 'required',
            'lien_poster'         => 'url',
            'lien_video' => 'url'
        ]);

        $data = $this->webtv->updatData($input, $id);

        return redirect()->route('webtv.index')->with('success', 'La vidéo a été mise à jour.');

    }

    public function remove($id)
    {
        DB::table("webtv")->where('id', $id)->delete();
        return redirect()->route('webtv.index')
            ->with('success', 'Vidéo Supprimé');
    }
}

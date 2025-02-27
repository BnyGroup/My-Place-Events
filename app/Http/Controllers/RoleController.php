<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Role;
use App\Permission;
use DB;

class RoleController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $roles = Role::orderBy('id','ASC')->paginate(5);
        return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    public function create()
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required',
            // 'permission' => 'required',
        ]);

        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        $permisionArray = array();
        $permisionArray = $request->input('permission');

        if(!is_null($permisionArray)){
            foreach ($permisionArray as $key => $value) {
                $role->attachPermission($value);
            }
        }
        return redirect()->route('roles.index')->with('success','Role created successfully');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("permission_role","permission_role.permission_id","=","permissions.id")
            ->where("permission_role.role_id",$id)
            ->get();

        return view('roles.show',compact('role','rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("permission_role")
            ->where("role_id",$id)
            ->pluck('permission_id','permission_id')
            ->all();

        return view('roles.edit',compact('role','permission','rolePermissions'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'display_name' => 'required',
            'description' => 'required',
            // 'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

       DB::table("permission_role")->where("permission_role.role_id",$id)->delete();

       $permisionArray = array();
       $permisionArray = $request->input('permission');

        if($id == 1):
           $data = [
                '0' => '1',
                '1' => '2',
                '2' => '3',
                '3' => '4',
                '4' => '5',
                '5' => '6',
            ];
            if(!is_null($permisionArray)){
                $inputData = array_merge($data, $permisionArray);
            }else{
                $inputData = $data;
            }
        else:
            $inputData = $permisionArray;
        endif;
      
        if(!is_null($inputData)){
            foreach ($inputData as $key => $value) {
                $role->attachPermission($value);
            }
        }

        return redirect()->route('roles.index')->with('success','Role updated successfully');
    }

    public function remove($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}

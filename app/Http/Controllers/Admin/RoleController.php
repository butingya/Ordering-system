<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    //显示所有角色
    public function index(){
        $roles = Role::all();
//        foreach ($roles as $k=>$role){
//            $data['name'] =
//        }
        return view('admin.role.index',compact('roles'));
    }

    //添加角色
    public function add(Request $request){

        if ($request->isMethod("post")) {
            //接收参数处理数据
            $pers = $request->post('per');
            //添加角色
            $role = Role::create([
                "name"=>$request->post("name"),
                "guard_name"=>"admin"
            ]);
            //给角色同步权限
            if ($pers) {
                $role->syncPermissions($pers);
            }
        }

        //得到所有权限
        $pers = Permission::all();
        return view("admin.role.add",compact("pers"));
    }

    //修改
    public function edit(Request $request,$id){

        $role = Role::find($id);

        if ($request->isMethod("post")) {
            //接收参数
            $data = $request->post('per');
//            $role->update($data);
            $role->update([
                "name"=>$request->post("name"),
                "guard_name"=>"admin"
            ]);

            $role->syncPermissions($data);
            return redirect()->route("admin.role.index")->with("success","修改成功");
        }
        //得到所有权限
        $pers = Permission::all();

        $px = $role->permissions()->pluck('id')->toArray();
//        dd($per);
        return view("admin.role.edit",compact("role","pers","px"));
    }
}

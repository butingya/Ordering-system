<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    //地址列表
    public function list(Request $request){
        //得到当前的用户id
        $memberId = $request->get("user_id");
        //所有的用户地址
        $address = Address::all();
        return $address;
    }
    //添加地址
    public function add(Request $request){
        //接收全部数据
        $data = $request->all();
        //默认不选中
        $data['is_selected'] = 0;
        //数据入库
        if (Address::create($data)) {
            $data = [
                'status' => 'true',
                'message' => '地址添加成功'
            ];
        }else{
            $data = [
                'status' => 'false',
                'message' => '地址添加失败'
            ];
        }
        return $data;
    }
    //修改地址
    public function edit(Request $request){
        $data = $request->post();
        //通过id查询一条数据
        $id = request()->get('id');
        $address = Address::find($id);
        if ($address->update($data)) {
            $data = [
                'status' => 'true',
                'message' => '地址修改成功'
            ];
        }else{
            $data = [
                'status' => 'false',
                'message' => '地址修改失败'
            ];
        }
        return $data;
        }
    //指定地址
    public function index(){
        $id = request()->get('id');
        $address = Address::find($id);
        return $address;
    }
}

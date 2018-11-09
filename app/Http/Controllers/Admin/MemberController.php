<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    //会员列表
    public function index(){
        $members = Member::all();
        return view("admin.member.index",compact('members'));
    }

    //会员信息查看
    public function look($id){
        $member = Member::find($id);
        DB::table('members')->where('id',$id);
        return view("admin.member.look",compact('member'));
    }
}

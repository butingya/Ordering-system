@extends("admin.layouts.main")
@section("title","会员信息")
@section("content")

    <a href="javascript:history.go(-1)" class="btn btn-success">返回</a>
    <div class="container">
        <table class="table container">
            <tr>
                <th>Id</th>
                <th>会员姓名</th>
                <th>联系电话</th>
                <th>余额</th>
                <th>积分</th>
            </tr>
                <tr>
                    <td>{{$member->id}}</td>
                    <td>{{$member->username}}</td>
                    <td>{{$member->tel}}</td>
                    <td>{{$member->money}}</td>
                    <td>{{$member->jifen}}</td>
                </tr>
        </table>
    </div>
@endsection
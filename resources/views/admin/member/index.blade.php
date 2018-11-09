@extends("admin.layouts.main")
@section("title","会员列表")
@section("content")


    <div class="container">
        <table class="table container">
            <tr>
                <th>Id</th>
                <th>会员姓名</th>
                <th>联系电话</th>
                <th>操作</th>
            </tr>
            @foreach($members as $member)
                <tr>
                    <td>{{$member->id}}</td>
                    <td>{{$member->username}}</td>
                    <td>{{$member->tel}}</td>
                    <td>
                        <a href="{{route('admin.member.look',$member->id)}}" class="btn btn-success">查看</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
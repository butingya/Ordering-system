@extends("admin.layouts.main")
@section("title","商户列表")
@section("content")

    <a href="{{route("admin.user.add")}}" class="btn btn-info">添加</a>
    <br>
    <br>

        <table class="table container">
            <tr>
                <th>Id</th>
                <th>商户姓名</th>
                <th>商户邮箱</th>
                <th>操作</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <a href="{{route("admin.user.edit",$user->id)}}" class="btn btn-success">编辑</a>
                        <a href="{{route("admin.user.del",$user->id)}}" class="btn btn-danger">删除</a>
                        <a href="" class="btn btn-warning">重置商家密码</a>
                    </td>
                </tr>
            @endforeach
        </table>


@endsection
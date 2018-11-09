@extends("admin.layouts.main")
@section("title","角色列表")
@section("content")

    <a href="{{route('admin.role.add')}}" class="btn btn-info">添加</a>
    <br>
    <br>

        <div class="container-fluid">
            <table class="table container">
                <tr>
                    <th>Id</th>
                    <th>角色名</th>
                    <th>拥有的权限</th>
                    <th>操作</th>
                </tr>
                @foreach($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>{{str_replace(['[',']','"'],'', json_encode($role->permissions()->pluck('intro'),JSON_UNESCAPED_UNICODE))}}</td>
                        <td>
                            <a href="{{route("admin.role.edit",$role->id)}}" class="btn btn-success">编辑</a>
                            <a href="" class="btn btn-danger">删除</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
@endsection
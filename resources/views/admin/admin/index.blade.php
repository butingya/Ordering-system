@extends("admin.layouts.main")
@section("title","管理员列表")
@section("content")

    <a href="{{route("admin.admin.add")}}" class="btn btn-info">添加</a>
    <br>
    <br>

      <div class="container">
          <table class="table container">
              <tr>
                  <th>Id</th>
                  <th>管理员名</th>
                  <th>管理员邮箱</th>
                  <th>拥有角色</th>
                  <th>操作</th>
              </tr>
              @foreach($admins as $admin)
                  <tr>
                      <td>{{$admin->id}}</td>
                      <td>{{$admin->name}}</td>
                      <td>{{$admin->email}}</td>
                      <td>{{str_replace(['[',']','"'],'', json_encode($admin->getRoleNames(),JSON_UNESCAPED_UNICODE))}}</td>
                      <td>
                          <a href="{{route("admin.admin.edit",$admin->id)}}" class="btn btn-success">编辑</a>
                          @if($admin->id!=1)
                          <a href="{{route("admin.admin.del",$admin->id)}}" class="btn btn-danger">删除</a>
                          @endif
                      </td>
                  </tr>
              @endforeach
          </table>
      </div>


@endsection
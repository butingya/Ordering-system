@extends("admin.layouts.main")
@section("title","菜单导航栏")
@section("content")

    <a href="{{route('admin.nav.add')}}" class="btn btn-info">添加</a>
    <br>
    <br>

      <div class="container">
          <table class="table container">
              <tr>
                  <th>Id</th>
                  <th>名称</th>
                  <th>地址</th>
                  <th>上级id</th>
                  <th>操作</th>
              </tr>
              @foreach($navs as $nav)
                  <tr>
                      <td>{{$nav->id}}</td>
                      <td>{{$nav->name}}</td>
                      <td>{{$nav->url}}</td>
                      <td>{{$nav->pid}}</td>
                      <td>
                          <a href="{{route('admin.nav.edit',$nav->id)}}" class="btn btn-success">编辑</a>
                          <a href="{{route('admin.nav.del',$nav->id)}}" class="btn btn-danger">删除</a>
                      </td>
                  </tr>
              @endforeach
          </table>
      </div>


@endsection
@extends("admin.layouts.main")
@section("title","权限列表")
@section("content")

    <a href="{{route('admin.per.add')}}" class="btn btn-info">添加</a>
    <br>
    <br>

      <div class="container">
          <table class="table container">
              <tr>
                  <th>Id</th>
                  <th>权限</th>
                  <th>说明</th>
                  <th>操作</th>
              </tr>
              @foreach($pers as $per)
                  <tr>
                      <td>{{$per->id}}</td>
                      <td>{{$per->name}}</td>
                      <td>{{$per->intro}}</td>
                      <td>
                          <a href="{{route('admin.per.edit',$per->id)}}" class="btn btn-success">编辑</a>
                          <a href="{{route('admin.per.del',$per->id)}}" class="btn btn-danger">删除</a>
                      </td>
                  </tr>
              @endforeach
          </table>
          {{$pers->links()}}
      </div>


@endsection
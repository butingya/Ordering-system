@extends("admin.layouts.main")

@section("title","添加角色")

@section("content")
    <a href="{{route('admin.role.index')}}" class="btn btn-success">返回</a>
    <div class="container">
        <form method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>角色名称</label>
                <input type="text" class="form-control" placeholder="角色名称" name="name" value="{{old("name")}}">
            </div>

            <div class="form-group">
                <label>权限名称</label>
                @foreach($pers as $per)
                    <input type="checkbox" name="per[]" value="{{$per->id}}">{{$per->intro}}
                @endforeach
            </div>

            <button type="submit" class="btn btn-default">确认添加</button>
        </form>
    </div>
@endsection
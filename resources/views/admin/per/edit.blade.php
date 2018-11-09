@extends("admin.layouts.main")

@section("title","添加权限")

@section("content")
    <a href="javascript:history.go(-1)" class="btn btn-success">返回</a>
    <div class="container">
        <form method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>权限</label>
                <input type="text" class="form-control" placeholder="权限" name="name" value="{{old("name",$per->name)}}">
            </div>

            <div class="form-group">
                <label>权限说明</label>
                <input type="text" class="form-control" placeholder="权限说明" name="intro" value="{{old("intro",$per->intro)}}">
            </div>

            <button type="submit" class="btn btn-default">确认修改</button>
        </form>
    </div>
@endsection
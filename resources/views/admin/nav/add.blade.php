@extends("admin.layouts.main")

@section("title","添加菜单导航栏")

@section("content")
    <a href="{{route('admin.nav.index')}}" class="btn btn-success">返回</a>
    <div class="container">
        <form method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>名称</label>
                <input type="text" class="form-control" placeholder="名称" name="name" value="{{old("name")}}">
            </div>

            <div class="form-group">
                <label>地址</label>
                <select name="url">
                    <option value="">请选择路由地址</option>
                    @foreach($urls as $url)
                    <option value="{{$url}}">{{$url}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>上级菜单</label>
                <select name="pid">
                    <option value="0">顶级菜单</option>
                    @foreach($navs as $nav)
                        <option value="{{$nav->id}}">{{$nav->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>排序</label>
                <input type="text" class="form-control" placeholder="排序" name="intro" value="{{old("sort")}}">
            </div>
            <button type="submit" class="btn btn-default">确认添加</button>
        </form>
    </div>
@endsection
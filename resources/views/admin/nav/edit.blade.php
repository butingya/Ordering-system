@extends("admin.layouts.main")

@section("title","修改菜单导航栏")

@section("content")
    <a href="{{route('admin.nav.index')}}" class="btn btn-success">返回</a>
    <div class="container">
        <form method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label >名称</label>
                <input type="text" class="form-control" placeholder="名称" name="name" value="{{$nav->name}}">
            </div>

            <div class="form-group">
                <label>地址</label>
                <select name="url" >
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
                    @foreach($nas as $na)
                        <option value="{{$na->id}}">{{$na->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>排序</label>
                <input type="text" class="form-control" placeholder="排序" name="intro" value="{{$nav->sort}}">
            </div>
            <button type="submit" class="btn btn-default">确认修改</button>
        </form>
    </div>
@endsection
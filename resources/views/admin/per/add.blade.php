@extends("admin.layouts.main")

@section("title","添加权限")

@section("content")
    <a href="{{route('admin.per.index')}}" class="btn btn-success">返回</a>
    <div class="container">
        <form method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>权限</label>
                <select name="name">
                    @foreach($urls as $url)
                    <option value="{{$url}}">{{$url}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>权限说明</label>
                <input type="text" class="form-control" placeholder="权限说明" name="intro" value="{{old("intro")}}">
            </div>

            <button type="submit" class="btn btn-default">确认添加</button>
        </form>
    </div>
@endsection
@extends("admin.layouts.main")


@section("title","商家资料修改")

@section("content")

    <form method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>商家名称</label>
            <input type="text" class="form-control" name="name" value="{{old("name",$user->name)}}">
        </div>

        <div class="form-group">
            <label>商家邮箱</label>
            <input type="email" class="form-control" name="email" value="{{old("email",$user->email)}}">
        </div>

        <button type="submit" class="btn btn-default">确认修改</button>
    </form>
@endsection
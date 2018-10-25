{{--@extends("shop.layouts.main")--}}
@extends("admin.layouts.main")

@section("title","管理员登录")

@section("content")

    <form method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>管理员</label>
            <input type="text" class="form-control" placeholder="管理员" name="name" value="{{old("name")}}">
        </div>

        <div class="form-group">
            <label>密码</label>
            <input type="password" class="form-control" placeholder="管理员密码" name="password">
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember"> 记住密码
            </label>
        </div>

        <button type="submit" class="btn btn-default">确认登录</button>
    </form>
@endsection
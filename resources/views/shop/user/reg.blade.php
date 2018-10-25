@extends("shop.layouts.main")

@section("title","商户注册")

@section("content")

    <form method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>商户名称</label>
            <input type="text" class="form-control" placeholder="商户名称" name="name" value="{{old("name")}}">
        </div>

        <div class="form-group">
            <label>商户邮箱</label>
            <input type="email" class="form-control" placeholder="商户邮箱" name="email" value="{{old("email")}}">
        </div>

        <div class="form-group">
            <label>密码</label>
            <input type="password" class="form-control" placeholder="商户密码" name="password">
        </div>


        <button type="submit" class="btn btn-default">确认注册</button>
    </form>
@endsection
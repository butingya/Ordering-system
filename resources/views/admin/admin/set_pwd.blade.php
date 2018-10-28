@extends("admin.layouts.main")

@section("title","管理员密码修改")

@section("content")

    <div class="container">
        <form method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>管理员名称</label>
                <input type="text" class="form-control" placeholder="管理员名称" name="name" value="{{$admin->name}}" readonly>
            </div>

            <div class="form-group">
                <label>旧密码</label>
                <input type="password" class="form-control" placeholder="旧密码" name="old_password" >
            </div>

            <div class="form-group">
                <label>新密码</label>
                <input type="password" class="form-control" placeholder="新密码" name="password">
            </div>

            <div class="form-group">
                <label>确认密码</label>
                <input type="password" class="form-control" placeholder="再次输入密码" name="password_confirmation">
            </div>


            <button type="submit" class="btn btn-default">确认修改</button>
        </form>
    </div>
@endsection
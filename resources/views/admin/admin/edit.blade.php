@extends("admin.layouts.main")


@section("title","管理员资料修改")

@section("content")

    <div class="container">
        <form method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>管理员名称</label>
                <input type="text" class="form-control" name="name" value="{{old("name",$admin->name)}}">
            </div>

            <div class="form-group">
                <label>管理员邮箱</label>
                <input type="email" class="form-control" name="email" value="{{old("email",$admin->email)}}">
            </div>

            <div class="form-group">
                <label>角色</label>
                @foreach($roles as $role)
                    <input type="checkbox" name="role[]" value="{{$role->id}}" {{in_array($role->name,$ro)?"checked":''}}>{{$role->name}}
                @endforeach
            </div>

            <button type="submit" class="btn btn-default">确认修改</button>
        </form>
    </div>
@endsection
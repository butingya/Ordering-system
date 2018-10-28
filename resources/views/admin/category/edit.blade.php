@extends("admin.layouts.main")
@section("title","店铺分类修改")
@section("content")



    <div class="container">
        <form method="post" enctype="multipart/form-data" class="table table-striped">
            {{ csrf_field() }}
            <div class="form-group">
                <label>商铺分类名</label>
                <input type="text" class="form-control" name="name" value="{{old("name",$shopcategory->name)}}">
            </div>

            <div class="form-group">
                <label>商铺分类图片</label>
                <input type="file" name="img">
                <p class="help-block">请选择你的商铺分类图片</p>
                <img src="/{{$shopcategory->img}}" width="100">
            </div>

            <div class="form-group">
                <label>状态</label>
                <div>
                    <input type="radio" name="status" value="1" <?php if($shopcategory->status==1) echo 'checked' ?> >启用
                    <input type="radio" name="status" value="0" <?php if($shopcategory->status==0) echo 'checked' ?>>禁用
                </div>
            </div>

            <button type="submit" class="btn btn-default">确认修改</button>
        </form>
    </div>
@endsection
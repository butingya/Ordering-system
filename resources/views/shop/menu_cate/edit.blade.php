@extends("shop.layouts.main")

@section("title","修改菜品分类")

@section("content")

    <form method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>分类名称</label>
            <input type="text" class="form-control" placeholder="分类名称" name="name" value="{{old("name",$menucategory->name)}}">
        </div>

        <div class="form-group">
            <label>菜品编号</label>
            <input type="text" class="form-control" placeholder="菜品编号" name="type_accumulation" value="{{old("type_accumulation",$menucategory->type_accumulation)}}">
        </div>

        <div class="form-group">
            <label>描述</label>
            <textarea name="description" cols="30" rows="5" class="form-control" placeholder="分类描述">{{old("description",$menucategory->description)}}</textarea>
        </div>

        <div class="form-group">
            <label>是否默认分类</label>&emsp;
            <label class="radio-inline">
                <input type="radio" name="is_selected" value="1" <?php if($menucategory->is_selected==1) echo 'checked' ?>> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_selected" value="0" <?php if($menucategory->is_selected==0) echo 'checked' ?>> 不是
            </label>
        </div>

        <button type="submit" class="btn btn-default">确认修改</button>
        </form>
@endsection
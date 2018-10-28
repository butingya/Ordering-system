@extends("shop.layouts.main")

@section("title","添加分类")

@section("content")

    <form method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>分类名称</label>
            <input type="text" class="form-control" placeholder="分类名称" name="name" value="{{old("name")}}">
        </div>

        {{--<div class="form-group">--}}
            {{--<label>商品所属商家</label>--}}
            {{--<input type="text" class="form-control" placeholder="所属商家" name="shop_id" value="{{old("shop_id")}}">--}}
        {{--</div>--}}

        <div class="form-group">
            <label>菜品编号</label>
            <input type="text" class="form-control" placeholder="菜品编号" name="type_accumulation" value="{{old("type_accumulation")}}">
        </div>

        <div class="form-group">
            <label>描述</label>
            <textarea name="description" cols="30" rows="5" class="form-control" placeholder="分类描述">{{old("description")}}</textarea>
        </div>

        <div class="form-group">
            <label>是否默认分类</label>&emsp;
            <label class="radio-inline">
                <input type="radio" name="is_selected" value="1"> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_selected" value="0"> 不是
            </label>
        </div>

        <button type="submit" class="btn btn-default">确认添加</button>
        </form>
@endsection
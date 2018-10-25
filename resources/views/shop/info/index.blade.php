@extends("shop.layouts.main")

@section("title","店铺申请")

@section("content")

    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label>店铺名称</label>
            <input type="text" class="form-control" placeholder="店铺名称" name="name" value="{{old("name")}}">
        </div>

        <div class="form-group">
            <label>店铺分类</label>
            {{--<input type="tetx" class="form-control" placeholder="店铺分类" name="shop_category_id" value="{{old("shop_category_id")}}">--}}
            <select name="shop_category_id">
                <option value="">请选择分类</option>
                @foreach($results as $result)
                    <option value="{{$result->id}}">{{$result->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>店铺图片</label>
            <input type="file" name="shop_img">
            <p class="help-block">请选择你的店铺图片</p>
        </div>

        <div class="form-group">
            <label>起送金额</label>
            <input type="text" class="form-control" placeholder="起送金额" name="start_send" value="{{old("start_send")}}">
        </div>

        <div class="form-group">
            <label>配送费</label>
            <input type="text" class="form-control" placeholder="配送费" name="send_cost" value="{{old("send_cost")}}">
        </div>

        <div class="form-group">
            <label>店铺公告</label>
            {{--<input type="text" class="form-control" placeholder="店铺公告" name="notice" value="{{old("notice")}}">--}}
            <textarea name="notice" cols="10" rows="5" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>优惠信息</label>
            {{--<input type="text" class="form-control" placeholder="优惠信息" name="discount" value="{{old("discount")}}">--}}
            <textarea name="discount" cols="10" rows="5" class="form-control"></textarea>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="brand"> 是否品牌联盟&emsp;
            </label>

            <label>
                <input type="checkbox" name="on_time"> 准时送达&emsp;
            </label>
            <label>
                <input type="checkbox" name="fengniao"> 蜂鸟配送&emsp;
            </label>
            <label>
                <input type="checkbox" name="bao"> 保&emsp;
            </label>
            <label>
                <input type="checkbox" name="piao"> 票&emsp;
            </label>
            <label>
                <input type="checkbox" name="zhun"> 准 &emsp;
            </label>
        </div>

        <button type="submit" class="btn btn-default">确认申请</button>
    </form>
@endsection
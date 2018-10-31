@extends("shop.layouts.main")
@section("title","菜品列表")
@section("content")

    <a href="{{route('shop.menu.add')}}" class="btn btn-warning">添加</a>
        <form class="form-inline pull-right" method="get">
            <button type="submit" class="btn btn-info">搜索</button>
            <div class="form-group">
                <select name="category_id" class="form-control">
                    <option value="">请选择</option>
                    @foreach($results as $result)
                        <option value="{{$result->id}}">{{$result->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <input type="text" class="form-control"  placeholder="搜索关键字"
                       name="keyword" value="{{request()->get("keyword")}}">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="最小金额"
                       name="minPrice" size="5" value="{{request()->get("minPrice")}}">
            </div>
            -
            <div class="form-group">
                <input type="text" class="form-control" placeholder="最大金额"
                       name="maxPrice" size="5" value="{{request()->get("maxPrice")}}">
            </div>
        </form>

    <br>
    <br>


        <table class="table container">
            <tr>
                <th>商品名称</th>
                <th>所属商家</th>
                <th>所属分类</th>
                <th>商品图片</th>
                <th>价格</th>
                <th>月销量</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            @foreach($menus as $menu)
                <tr>
                    <td>{{$menu->goods_name}}</td>
                    <td>{{$menu->info->shop_name}}</td>
                    <td>{{$menu->menu_category->name}}</td>
                    <td>
                        {{--<img src="/{{$menu->goods_img}}" height="100" width="150">--}}
                        <img src="{{env("ALIYUN_OSS_URL").$menu->goods_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">
                        {{--<img src="{{$menu->goods_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">--}}

                    </td>
                    <td>{{$menu->goods_price}}</td>
                    <td>{{$menu->month_sales}}</td>
                    <td>
                        @if($menu->status)
                            <span>上架</span>
                        @else
                            <span>下架</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('shop.menu.edit',$menu->id)}}" class="btn btn-success">编辑</a>
                        <a href="{{route('shop.menu.del',$menu->id)}}" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>
    {{$menus->appends($url)->links()}}
@endsection
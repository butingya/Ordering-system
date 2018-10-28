@extends("shop.layouts.main")
@section("title","分类列表")
@section("content")

    <a href="{{route("shop.category.index")}}" class="btn btn-warning">返回</a>
    <br>
    <br>

        <table class="table container">
            <tr>
                <th>商品名称</th>
                <th>商品图片</th>
                <th>价格</th>
                <th>月销量</th>
                <th>状态</th>
            </tr>
            @foreach($lists as $list)
                <tr>
                    <td>{{$list->goods_name}}</td>
                    <td>
                        <img src="/{{$list->goods_img}}" height="100" width="150">
                    </td>
                    <td>{{$list->goods_price}}</td>
                    <td>{{$list->month_sales}}</td>
                    <td>
                        @if($list->status)
                            <span>上架</span>
                        @else
                            <span>下架</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
@endsection
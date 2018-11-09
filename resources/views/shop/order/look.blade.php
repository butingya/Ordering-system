@extends("shop.layouts.main")
@section("title","订单详情")
@section("content")

    <a href="javascript:history.go(-1)" class="btn btn-success">返回</a>
    <br>
    <br>
    <table class="table container">
        <tr>
            <th>店铺名称</th>
            <th>订单编号</th>
            <th>收货地址</th>
            <th>收货人</th>
            <th>联系电话</th>
            <th>价格</th>
            <th>状态</th>
        </tr>
            <tr>
                <td>{{$orders->shop->shop_name}}</td>
                <td>{{$orders->order_code}}</td>
                <td>{{$orders->provence . $orders->city . $orders->area . $orders->address}}</td>
                <td>{{$orders->name}}</td>
                <td>{{$orders->tel}}</td>
                <td>{{$orders->total}}</td>
                <td>
                    @if($orders->status === -1)
                        <span>取消</span>
                    @elseif($orders->status === 0)
                        <span>待支付</span>
                    @elseif($orders->status === 1)
                        <span>已支付</span>
                    @elseif($orders->status === 2)
                        <span>待收货</span>
                    @else
                        <span>已完成</span>
                    @endif
                </td>
            </tr>
    </table>
@endsection
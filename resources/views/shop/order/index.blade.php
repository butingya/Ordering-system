@extends("shop.layouts.main")
@section("title","订单列表")
@section("content")

    <form class="form-inline pull-right" method="get">
        <button type="submit" class="btn btn-info">搜索</button>
        <div class="form-group">
            <select name="status" class="form-control">
                <option value="">订单状态</option>
                <option value="0">待支付</option>
                <option value="1">待发货</option>
                <option value="2">待确认</option>
                <option value="3">已完成</option>
            </select>
        </div>
    </form>

    <table class="table container">
        <tr>
            <th>订单编号</th>
            <th>收货地址</th>
            <th>收货人</th>
            <th>联系电话</th>
            <th>价格</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->order_code}}</td>
                <td>{{$order->provence . $order->city . $order->area . $order->address}}</td>
                <td>{{$order->name}}</td>
                <td>{{$order->tel}}</td>
                <td>{{$order->total}}</td>
                <td>
                    @if($order->status === -1)
                        <span>取消</span>
                    @elseif($order->status === 0)
                        <span>待支付</span>
                    @elseif($order->status === 1)
                        <span>已支付</span>
                    @elseif($order->status === 2)
                        <span>待收货</span>
                    @else
                        <span>已完成</span>
                    @endif
                </td>
                <td>
                    <a href="{{route("shop.order.look",$order->id)}}" class="btn btn-success">查看</a>
                    @if($order->status === -1)
                        <a href="{{route('shop.order.setStatus',[$order->id,0])}}" class="btn btn-danger">取消</a>
                    @endif
                    @if($order->status === 0)
                        <a href="{{route('shop.order.setStatus',[$order->id,1])}}" class="btn btn-primary">待支付</a>
                    @endif
                    @if($order->status === 1)
                        <a href="{{route('shop.order.setStatus',[$order->id,2])}}" class="btn btn-primary">待发货</a>
                    @endif
                    @if($order->status === 2)
                        <a href="{{route('shop.order.setStatus',[$order->id,3])}}" class="btn btn-warning" >待收货</a>
                    @endif
                    @if($order->status === 3)
                        <a href="{{route('shop.order.setStatus',[$order->id,4])}}" class="btn" style="color: red" disabled="disable">已完成</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection
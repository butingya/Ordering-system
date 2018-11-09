@extends("shop.layouts.main")
@section("title","菜品日销量")
@section("content")
    <form class="form-inline pull-right" method="get">
        <button type="submit" class="btn btn-info">搜索</button>

        <div class="form-group">
            <input type="text" class="form-control" placeholder="菜品名字"
                   name="keyword" size="5" value="">
        </div>

        <div class="form-group">
            <input type="date" class="form-control" placeholder="开始时间"
                   name="start" size="5" value="">
        </div>
        -
        <div class="form-group">
            <input type="date" class="form-control" placeholder="结束时间"
                   name="end" size="5" value="">
        </div>
    </form>
    <br><br><br>

    <table class="table table-hover">
        <tbody>
        <tr>
            <th>日期</th>
            <th>名字</th>
            <th>订单数</th>
            <th>价格</th>
        </tr>
        @foreach($data as $datas)
            <tr>
                <td>{{$datas->created_at}}</td>
                <td>{{$datas->goods_name}}</td>
                <td>{{$datas->amount}}</td>
                <td>{{$datas->goods_price}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$data->links()}}
@endsection
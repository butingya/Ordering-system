@extends("admin.layouts.main")
@section("title","商家日订单量")
@section("content")

    <a href="{{route('admin.order.month')}}" class="btn btn-success">月销量</a>
    <a href="{{route('admin.order.total')}}" class="btn btn-warning">总销量</a>
    <div class="container">
        <table class="table table-hover">
            <tr>
                <th>日期</th>
                <th>订单数</th>
                <th>收入</th>
            </tr>
            @foreach($data as $datas)
                <tr>
                    <td>{{$datas->date}}</td>
                    <td>{{$datas->nums}}</td>
                    <td>{{$datas->money}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
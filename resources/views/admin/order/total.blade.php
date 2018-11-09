@extends("admin.layouts.main")
@section("title","商家总订单量")
@section("content")

    <a href="{{route('admin.order.day')}}" class="btn btn-success">日销量</a>
    <a href="{{route('admin.order.month')}}" class="btn btn-warning">月销量</a>
    <div class="container">
        <table class="table table-hover">
            <tbody>
            <tr>
                <th>订单数</th>
                <th>收入</th>
            </tr>
            @foreach($data as $datas)
                <tr>
                    <td>{{$datas->nums}}</td>
                    <td>{{$datas->money}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>




@endsection
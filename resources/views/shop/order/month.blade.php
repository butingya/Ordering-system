@extends("shop.layouts.main")
@section("title","月订单量")
@section("content")

    <table class="table table-hover">
        <tbody>
        <tr>
            <th>月份</th>
            <th>订单数</th>
            <th>收入</th>
        </tr>
        @foreach($data as $datas)
            <tr>
                <td>{{$datas->month}}</td>
                <td>{{$datas->nums}}</td>
                <td>{{$datas->money}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>




@endsection
@extends("admin.layouts.main")
@section("title","全部商家菜品日销量")
@section("content")

    <table class="table table-hover">
        <tbody>
        <tr>
            <th>商家</th>
            <th>日期</th>
            <th>订单数</th>
            <th>盈利</th>
        </tr>
        @foreach($data as $datas)
            <tr>
                <td>{{$datas->shop->shop_name}}</td>
                <td>{{$datas->date}}</td>
                <td>{{$datas->nums}}</td>
                <td>{{$datas->money}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
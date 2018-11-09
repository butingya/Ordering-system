@extends("shop.layouts.main")
@section("title","菜品月销量")
@section("content")
    
    <table class="table table-hover">
        <tbody>
        <tr>
            <th>日期</th>
            <th>订单数</th>
            <th>盈利</th>
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
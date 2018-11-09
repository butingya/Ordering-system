@extends("shop.layouts.main")
@section("title","菜品总销量")
@section("content")

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
@endsection
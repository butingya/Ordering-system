@extends("admin.layouts.main")
@section("title","各商家日订单量")
@section("content")

    <div class="container">
        <table class="table table-hover">
            <tr>
                <th>商家</th>
                <th>订单数</th>
                <th>收入</th>
            </tr>
            @foreach($data as $datas)
                <tr>
                    <td>{{$datas->shop->shop_name}}</td>
                    <td>{{$datas->nums}}</td>
                    <td>{{$datas->money}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
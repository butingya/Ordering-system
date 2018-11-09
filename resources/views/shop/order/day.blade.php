@extends("shop.layouts.main")
@section("title","日订单量")
@section("content")

    <form class="form-inline pull-right" method="get">
        <button type="submit" class="btn btn-info">搜索</button>

        <div class="form-group">
            <input type="date" class="form-control" placeholder="开始时间"
                   name="start" size="5" value="{{request()->get("start")}}">
        </div>
        -
        <div class="form-group">
            <input type="date" class="form-control" placeholder="结束时间"
                   name="end" size="5" value="{{request()->get("end")}}">
        </div>
    </form>


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
@endsection
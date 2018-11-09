@extends("shop.layouts.main")
@section("title","抽奖结果")
@section("content")
    <a href="javascript:history.go(-1)" class="btn btn-success">返回</a>
    <br><br>

    <div class="container-fluid">
        <table class="table container">
            <tr>
                <th>活动名称</th>
                <th>中奖者</th>
                <th>奖品</th>
            </tr>
            @foreach($prizes as $prize)
                <tr>
                    <td>{{$prize->event->title}}</td>
                    <td>{{$prize->user->name}}</td>
                    <td>{{$prize->name}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
@extends("shop.layouts.main")
@section("title","活动详情")
@section("content")
    <a href="javascript:history.go(-1)" class="btn btn-success">返回</a>
    <br><br>

    <div class="container-fluid">
        <table class="table container">
            <tr>
                <th>活动名称</th>
                <th>奖品</th>
                <th>奖品详情</th>
                <th>人数限制</th>
            </tr>
            @foreach($events as $event)
                <tr>
                    <td>{{$event->title}}</td>
                    <td>{{$event->prize->name}}</td>
                    <td>{{$event->prize->description}}</td>
                    <td>{{$event->num}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
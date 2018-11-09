@extends("admin.layouts.main")
@section("title","活动奖品")
@section("content")

    <a href="{{route("admin.prize.add")}}" class="btn btn-warning">添加</a>
    <br><br>

    <div class="container-fluid">
        <table class="table container">
            <tr>
                <th>活动id</th>
                <th>奖品名称</th>
                <th>奖品详情</th>
                <th>中奖商家id</th>
                <th>操作</th>
            </tr>
            @foreach($prizes as $prize)
                <tr>
                    <td>{{$prize->event->title}}</td>
                    <td>{{$prize->name}}</td>
                    <td>{{$prize->description}}</td>
                    <td>{{$prize->user_id}}</td>

                    <td>
                        <a href="{{route("admin.prize.edit",$prize->id)}}" class="btn btn-success">编辑</a>
                        <a href="{{route("admin.prize.del",$prize->id)}}" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
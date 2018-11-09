@extends("shop.layouts.main")
@section("title","抽奖活动")
@section("content")
    <div class="container-fluid">
        <table class="table container">
            <tr>
                <th>活动名称</th>
                <th>活动详情</th>
                <th>活动报名开始时间</th>
                <th>活动报名结束时间</th>
                <th>活动开奖时间</th>
                <th>是否开奖</th>
                <th>操作</th>
            </tr>
            @foreach($events as $event)
                <tr>
                    <td>{{$event->title}}</td>
                    <td>{{$event->content}}</td>
                    <td>{{date('Y-m-d',$event->start_time)}}</td>
                    <td>{{date('Y-m-d',$event->end_time)}}</td>
                    <td>{{date('Y-m-d',$event->prize_time)}}</td>
                    <td>
                        @if($event->is_prize)
                            <span>已开奖</span>
                        @else
                            <span>未开奖</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route("shop.event.look",$event->id)}}" class="btn btn-warning">活动详情</a>
                        @if($event->is_prize === 0)
                        <a href="{{route("shop.event.sign",[$event->id])}}" class="btn btn-danger">报名</a>
                        @endif
                        <a href="{{route("shop.event.info",$event->id)}}" class="btn btn-success">查看抽奖结果</a>

                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
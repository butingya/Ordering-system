@extends("shop.layouts.main")
@section("title","活动列表")
@section("content")



        <div class="container">
            <table class="table container">
                <tr>
                    <th>活动标题</th>
                    <th>活动内容</th>
                    <th>活动开始时间</th>
                    <th>活动结束时间</th>
                </tr>
                @foreach($activitys as $activity)
                    <tr>
                        <td>{{$activity->title}}</td>
                        <td>{!!$activity->content!!}</td>
                        <td>{{$activity->start_time}}</td>
                        <td>{{$activity->end_time}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
@endsection
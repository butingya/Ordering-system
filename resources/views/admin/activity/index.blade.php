@extends("admin.layouts.main")
@section("title","活动列表")
@section("content")

    <a href="{{route('admin.activity.add')}}" class="btn btn-info">添加活动</a>
    <form class="form-inline pull-right" method="get">
        <button type="submit" class="btn btn-info">搜索</button>
        <div class="form-group">
            <select name="time" class="form-control">
                    <option value="1">请选择活动选择状态</option>
                    <option value="2">未开始</option>
                    <option value="3">进行中</option>
                    <option value="4">已结束</option>

            </select>
        </div>

        <div class="form-group">
            <input type="text" class="form-control"  placeholder="搜索关键字"
                   name="keyword" value="{{request()->get("keyword")}}">
        </div>
    </form>

    <br>
    <br>

        <div class="container">
            <table class="table container">
                <tr>
                    <th>活动标题</th>
                    <th>活动内容</th>
                    <th>活动开始时间</th>
                    <th>活动结束时间</th>
                    <th>操作</th>
                </tr>
                @foreach($activitys as $activity)
                    <tr>
                        <td>{{$activity->title}}</td>
                        <td>{!!$activity->content!!}</td>
                        <td>{{$activity->start_time}}</td>
                        <td>{{$activity->end_time}}</td>
                        <td>
                            <a href="{{route("admin.activity.edit",$activity->id)}}" class="btn btn-success">编辑</a>
                            <a href="{{route("admin.activity.del",$activity->id)}}" class="btn btn-danger">删除</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    {{$activitys->appends($url)->links()}}
@endsection
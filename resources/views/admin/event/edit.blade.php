@extends("admin.layouts.main")

@section("title","编辑抽奖活动")

@section("content")

    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label>活动名称</label>
            <input type="text" class="form-control" placeholder="活动名称" name="title" value="{{old("title",$event->title)}}">
        </div>

        <div class="form-group">
            <label>活动详情</label>
            <textarea name="content" cols="10" rows="5" class="form-control">{{$event->content}}</textarea>
        </div>

        <div class="form-group">
            <label>活动报名开始时间</label>
            <input type="date" class="form-control"  name="start_time" value="{{old("start_time")}}">
        </div>

        <div class="form-group">
            <label>活动报名截止时间</label>
            <input type="date" class="form-control"  name="end_time" value="{{old("end_time")}}">
        </div>

        <div class="form-group">
            <label>活动开奖时间</label>
            <input type="date" class="form-control"  name="prize_time" value="{{old("prize_time")}}">
        </div>

        <div class="form-group">
            <label>活动报名人数限制</label>
            <input type="text" class="form-control" placeholder="活动报名人数限制" name="num" value="{{old("num",$event->num)}}">
        </div>

        <div class="form-group">
            <label>是否开奖</label>&emsp;
            <label class="radio-inline">
                {{--<input type="radio" name="is_prize" value="1"> 是--}}
                <input type="radio" name="is_prize" value="1" <?php if($event->is_prize==1) echo 'checked' ?>> 已开奖
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_prize" value="0" <?php if($event->is_prize==0) echo 'checked' ?>> 未开奖
            </label>
        </div>


        <button type="submit" class="btn btn-default">确认添加</button>
    </form>
@endsection

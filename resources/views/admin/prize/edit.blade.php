@extends("admin.layouts.main")

@section("title","奖品编辑")

@section("content")

    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label>活动</label>
            <select name="event_id" class="form-control">
                <option value="">请选择活动</option>
                @foreach($events as $event)
                    {{--<option value="{{$event->id}}">{{$event->title}}</option>--}}
                    <option value="{{$event->id}}"
                    <?php if($event['id']===$prize['event_id']) echo "selected='selected'";?>>
                        {{$event->title}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>活动奖品</label>
            <input type="text" class="form-control" placeholder="活动奖品" name="name" value="{{old("name",$prize->name)}}">
        </div>

        <div class="form-group">
            <label>奖品详情</label>
            <textarea name="description" cols="10" rows="5" class="form-control">{{$prize->description}}</textarea>
        </div>

        <button type="submit" class="btn btn-default">确认修改</button>
    </form>
@endsection

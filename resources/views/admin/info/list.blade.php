@extends("admin.layouts.main")
@section("title","店铺申请列表")
@section("content")

    <style type="text/css">
        table{
            width: 100%;
        }
        table th{
            text-align: center;
            /*width: 300px;*/
            /*height: 70px;*/
        }
        /*table td{*/
            /*height: 70px;*/
            /*text-align: center;*/
        /*}*/
    </style>

    <a href="" class="btn btn-info">添加</a>
    <br>
    <br>
    <table class="table table-hover">
        <tr>
            <th>id</th>
            <th>店铺名称</th>
            <th>商家</th>
            <th>店铺分类</th>
            <th>店铺图片</th>
            <th>起送金额</th>
            <th>配送费</th>
            <th>是否品牌联盟</th>
            <th>准时送达</th>
            <th>蜂鸟配送</th>
            {{--<th>保</th>--}}
            {{--<th>票</th>--}}
            {{--<th>准</th>--}}
            <th>操作</th>
        </tr>
        @foreach($info as $information)
            <tr>
                <td>{{$information->id}}</td>
                <td>{{$information->shop_name}}</td>
                <td>{{$information->users->name}}</td>
                <td>{{$information->shop_categories->name}}</td>
                <td>
                    <img src="/{{$information->shop_img}}" style="width: 100px">
                </td>
                <td>{{$information->start_send}}</td>
                <td>{{$information->send_cost}}</td>
                <td>{{$information->brand}}</td>
                <td>{{$information->on_time}}</td>
                <td>{{$information->fengniao}}</td>
                {{--<td>{{$information->bao}}</td>--}}
                {{--<td>{{$information->piao}}</td>--}}
                {{--<td>{{$information->zhun}}</td>--}}
                <td>
                    <a href="{{route("admin.info.check",$information->id)}}" <?php if($information->status==1 || $information->status==-1) echo 'disabled' ?> class="btn btn-info">审核</a>
                    <a href="{{route("admin.info.ban",$information->id)}}" <?php if($information->status==-1) echo 'disabled' ?> class="btn btn-danger">禁用</a>
                    <a href="{{route("admin.info.del",$information->id)}}" class="btn btn-warning">删除</a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection
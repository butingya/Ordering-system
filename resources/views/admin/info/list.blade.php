@extends("admin.layouts.main")
@section("title","店铺申请列表")
@section("content")

    <style type="text/css">
        table{
            width: 100%;
        }
        table th{
            /*text-align: center;*/
            width: 300px;
            /*height: 70px;*/
        }
        /*table td{*/
            /*height: 70px;*/
            /*text-align: center;*/
        /*}*/
    </style>

    <a href="" class="btn btn-info ">添加</a>
    <br>
    <br>
    <div class="container-fluid">
        <table class="table table-hover">
            <tr>
                <th>id</th>
                <th>店铺名称</th>
                <th>商家</th>
                <th>店铺分类</th>
                <th>店铺图片</th>
                {{--<th>起送金额</th>--}}
                {{--<th>配送费</th>--}}
                {{--<th>是否品牌联盟</th>--}}
                {{--<th>准时送达</th>--}}
                {{--<th>蜂鸟配送</th>--}}
                {{--<th>保</th>--}}
                {{--<th>票</th>--}}
                {{--<th>准</th>--}}
                <th>操作</th>
            </tr>
            @foreach($info as $information)
                <tr>
                    <td>{{$information->id}}</td>
                    <td>{{$information->shop_name}}</td>
                    <td>
                        @if($information->user){{$information->user->name}}@endif
                    </td>
                    <td>
                        @if($information->shop_categories){{$information->shop_categories->name}}@endif
                    </td>
                    <td>
                        {{--<img src="/{{$information->shop_img}}" style="width: 100px">--}}
                        {{--<img src="{{env("ALIYUN_OSS_URL").$information->shop_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">--}}
                        {{--<img src="{{env("ALIYUN_OSS_URL").$information->shop_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">--}}
                        <img src="{{$information->shop_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">
                    </td>
                    {{--<td>{{$information->start_send}}</td>--}}
                    {{--<td>{{$information->send_cost}}</td>--}}
                    <td>
                        @if($information->status===0 )
                            <a href="{{route("admin.info.check",$information->id)}}" class="btn btn-info">审核</a>
                        @endif
                        @if($information->status===1 )
                            <a href="{{route("admin.info.ban",$information->id)}}" class="btn btn-danger">禁用</a>
                        @endif
                        <a href="{{route("admin.info.edit",$information->id)}}" class="btn btn-primary">编辑</a>
                        <a href="{{route("admin.info.del",$information->id)}}" class="btn btn-warning">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
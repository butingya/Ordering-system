@extends("admin.layouts.main")
@section("title","店铺分类列表")
@section("content")


    <a href="{{route("admin.category.add")}}" class="btn btn-info">添加</a>
    <br>
    <br>
    <div class="container-fluid">
        <table class="table table-striped">
            <tr>
                <th>Id</th>
                <th>商铺分类</th>
                <th>商铺分类图片</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            @foreach($shopcategory as $categorys)
                <tr>
                    <td>{{$categorys->id}}</td>
                    <td>{{$categorys->name}}</td>
                    <td>
                        {{--<img src="/{{$categorys->img}}" width="100">--}}
                        <img src="{{env("ALIYUN_OSS_URL").$categorys->img}}?x-oss-process=image/resize,m_fill,w_150,h_100">
                    </td>
                    <td>
                        @if($categorys->status)
                            <span>上线</span>
                        @else
                            <span>未启用</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{route("admin.category.edit",$categorys->id)}}" class="btn btn-success">编辑</a>
                        <a href="{{route("admin.category.del",$categorys->id)}}" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
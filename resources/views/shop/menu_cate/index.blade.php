@extends("shop.layouts.main")
@section("title","分类列表")
@section("content")

    <a href="{{route("shop.category.add")}}" class="btn btn-warning">添加</a>
    <br>
    <br>

        <table class="table container">
            <tr>
                <th>分类名称</th>
                <th>所属商家</th>
                <th>菜品编号</th>
                <th>分类描述</th>
                <th>是否默认分类</th>
                <th>操作</th>
            </tr>
            @foreach($menucategory as $menucategorys)
                <tr>
                    <td>{{$menucategorys->name}}</td>
                    <td>{{$menucategorys->info->shop_name}}</td>
                    <td>{{$menucategorys->type_accumulation}}</td>
                    <td>{{$menucategorys->description}}</td>
                    <td>
                        {{--{{$menucategorys->is_selected}}--}}
                        @if($menucategorys->is_selected)
                            <span>默认选中</span>
                        @else
                            <span>不选中</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route("shop.category.edit",$menucategorys->id)}}" class="btn btn-success">编辑</a>
                        <a href="{{route("shop.category.del",$menucategorys->id)}}" class="btn btn-danger">删除</a>
                        <a href="{{route("shop.category.look",$menucategorys->id)}}" class="btn btn-warning">查看</a>
                    </td>
                </tr>
            @endforeach
        </table>
@endsection
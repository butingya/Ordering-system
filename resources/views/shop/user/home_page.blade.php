@extends("shop.layouts.main")

@section("title","首页")

@section("content")

    <style type="text/css">
        span{
            font-size: 20px;
            font-family: 华文楷体;
        }
        a span{
            font-size: 27px;
            border-radius: 10%;
            font-family: 楷体;
        }
    </style>


    <form method="post">
        {{ csrf_field() }}
          <span>欢迎登录,有兴趣加入我们吗</span>
        <a href="{{route("shop.info.index")}}" class="btn btn-warning"><span>点击加入</span></a>
    </form>
@endsection
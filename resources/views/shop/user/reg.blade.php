<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>商家注册</title>

    <!-- Bootstrap -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">欢迎登陆</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">注册<span class="sr-only">(current)</span></a></li>
                <li><a href="{{route("shop.user.login")}}">如果有账号请点击登陆哟~</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">关于我们</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

@include("shop.layouts._error")
@include("shop.layouts._msg")

<div class="container">
    <form method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>商户名称</label>
            <input type="text" class="form-control" placeholder="商户名称" name="name" value="{{old("name")}}">
        </div>

        <div class="form-group">
            <label>商户邮箱</label>
            <input type="email" class="form-control" placeholder="商户邮箱" name="email" value="{{old("email")}}">
        </div>

        <div class="form-group">
            <label>密码</label>
            <input type="password" class="form-control" placeholder="商户密码" name="password">
        </div>


        <button type="submit" class="btn btn-default">确认注册</button>
    </form>


<div class="container">

</div>


<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="/bootstrap/js/jquery.min.js"></script>
<!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
<script src="/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
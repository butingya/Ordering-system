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
            <a class="navbar-brand" href="">舌尖上的平台</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @foreach(\App\Models\Nav::where("pid",0)->get() as $k1=>$v1)

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">{{$v1->name}} <spa class="caret"></spa></a>
                        <ul class="dropdown-menu">

                            @foreach(\App\Models\Nav::where("pid",$v1->id)->get() as $k2=>$v2)
                                <li><a href="{{route($v2->url)}}">{{$v2->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">店铺管理<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route("admin.info.list")}}">店铺列表</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route("admin.category.index")}}">店铺分类</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">人员管理<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route("admin.admin.index")}}">管理员管理</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route("admin.user.index")}}">商家管理</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route("admin.member.index")}}">会员管理</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">活动<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route("admin.activity.index")}}">活动管理</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">xxx</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">销量<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route("admin.order.day")}}">商家日订单量</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route("admin.order.month")}}">商家月订单量</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route("admin.order.total")}}">商家订单量</a></li>
                    </ul>
                </li>

            </ul>


            <ul class="nav navbar-nav navbar-right">
                <li><a href="">关于我们 <span class="sr-only">(current)</span></a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                @auth("admin")
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">恭喜 {{\Illuminate\Support\Facades\Auth::guard("admin")->user()->name}} 找到秘密宝藏<span class="caret"></span></a>

                        <ul class="dropdown-menu">
                            <li><a href="{{route('admin.admin.pwd',\Illuminate\Support\Facades\Auth::guard('admin')->user()->id)}}">修改密码</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route("admin.admin.logout")}}">注销</a></li>

                        </ul>
                    </li>
                @endauth

                @guest("admin")
                    <li><a href="{{route('admin.admin.login')}}">登录</a></li>
                @endguest
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
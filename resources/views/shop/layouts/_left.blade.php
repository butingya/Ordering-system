<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/shop/dist/img/09.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>biubiubiu~</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">为人民服务的长胖事业呀~真好</li>
            <li><a href=""><i class="fa fa-book"></i> <span>xxxxx</span></a></li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>菜品</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route("shop.menu.index")}}"><i class="fa fa-circle-o"></i> 菜品</a></li>
                    <li><a href="{{route("shop.category.index")}}"><i class="fa fa-circle-o"></i> 菜品分类</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>菜品分类</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href=""><i class="fa fa-circle-o"></i> 佛系养生之早餐</a></li>
                    <li><a href=""><i class="fa fa-circle-o"></i> 佛系养生之早餐</a></li>
                </ul>
            </li>




            <li class="header">LABELS</li>
            <li><a href="{{route("shop.activity.index")}}"><i class="fa fa-circle-o text-red"></i> <span>当前活动</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
# 项目介绍--点餐系统

整个系统分为三个不同的网站，分别是

- 平台：网站管理者
- 商户：入住平台的餐馆
- 用户：订餐的用户

# Day_01

## 开发任务

### 平台端

- 商家分类管理
- 商家管理
- 商家审核

### 商户端

- 商家注册

### 要求

- 商家注册时，同步填写商家信息，商家账号和密码
- 商家注册后，需要平台审核通过，账号才能使用
- 平台可以直接添加商家信息和账户，默认已审核通过

## 实现

1.composer create-project --prefer-dist laravel/laravel order"5.5.*" -vvv

#### 设置虚拟主机，host文件

```sh
<VirtualHost *:80>
    DocumentRoot "D:\web\order\public"
    ServerName www.order.com
    ServerAlias user.order.com shop.order.com
  <Directory "D:\web\order\public">
      Options Indexes  FollowSymLinks ExecCGI
      AllowOverride All
      Order allow,deny
      Allow from all
      Require all granted
  </Directory>
</VirtualHost>
```

3.创建数据库

4.修改框架配置文件

5.数据迁移

6.注册，设置路由，显示视图

```sh
//路由设置
  Route :: domain（“ admin.ele.com ”）- >命名空间（“ Admin ”）- > group（function（{
  
}）;

Route::domain("shop.order.com")->namespace("Shop")->group(function (){
    //首页
      Route::get("index/index","IndexController@inex")->name("shop.user.index");
      Route::any("user/reg","UserController@inex")->name("shop.user.reg");
});
```

#### 登录，进入后台首页，判断有没有商铺，无则申请，同时判断店铺状态，店铺状态如果不为1，不能做任何操作

```sh
public function login(Request $request){
          //判断post提交
            if ($request->isMethod("post")) {

                $data = $this->validate($request, [
                    "name" => "required",
                    "password" => "required",
                ]);
              //登录验证
                if (Auth::attempt($data,$request->has("remember"))){
//                    当前用户id
//                      $user = Auth::user();
                      $info = Auth::user()->info;
//                      dd($info);
//                    通过id找店铺
                      if ($info){
                          switch ($info->status){
                              case -1;  //禁用状态
                                 Auth::logout();
                                 return back()->withInput()->with("danger","因你的店铺被禁用,此账号失效");
                                 break;
                              case 0;  //待审核
                                  Auth::logout();
                                  return back()->withInput()->with("danger","因你的店铺还在审核,此账号登录失败,请耐心等待");
                                  break;
                          }
                      }else{
                          //跳转店铺申请
                          return redirect()->intended(route("shop.info.index"))->with("danger","你还没有申请店铺，快来为美食事业助一份力把");
                      }
                    //登录成功
                    return redirect()->intended(route("shop.user.home_page"))->with("success","登录成功");
                }else{
                    //登录失败
                    //session()->flash("danger","账号或密码错误");
                    return redirect()->back()->withInput()->with("danger","账号或密码错误");
                }
            }
            return view("shop.user.login");
        }
```

8.申请商铺

#### 后台审核

```sh
public function check($id){
          $info = Info::find($id);
          $info->status= 1;
          $info->save();
          return back()->with("success","审核通过");
      }
```

#### 后台登录

```sh
//登录
      public function login(Request $request){
          //是否post提交
          if ($request->isMethod("post")) {
              //验证
                $data = $this->validate($request,[
                    "name" => "required",
                    "password" => "required"
                ]);
              //判定账号密码是否有误
              if (Auth::guard("admin")->attempt($data,$request->has("remember"))) {
                  //成功
                    return redirect()->intended(route("admin.index"))->with("success","登录成功");
              }else{
                    return redirect()->back()->withInput()->with("danger","账号密码错误");
              }
          }
          //显示视图
            return view("admin.login");
      }
```

文件配置 config/auth.php

```sh
# 保安
'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' =>[
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],
 #数据提供者
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => \App\Models\Admin::class
        ],
```

#### 登录提示

```sh
# 视图
@auth("web")
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">恭喜 {{\Illuminate\Support\Facades\Auth::guard("web")->user()->name}} 找到秘密宝藏<span class="caret"></span></a>

                        <ul class="dropdown-menu">
                            <li><a href="">修改密码</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route("shop.user.logout")}}">注销</a></li>

                        </ul>
                    </li>
                @endauth

                @guest("web")
                    <li><a href="">登录</a></li>
                    <li><a href="">注册</a></li>
                @endguest
```

#### 注销

```sh
public function logout(){
          Auth::guard("admin")->logout();
          return redirect()->route("admin.admin.login")->with("success","退出成功");
      }
```

#### 密码修改 密码验证 哈希验证

```sh
//修改密码
      public function editPassword(Request $request,$id){
          //当前登录用户
            $admin = Admin::find($id);
          //判断post提交
          if ($request->isMethod("post")) {
              //验证
              $this->validate($request,[
                  "password"=>"required|confirmed",
                  "old_password"=>"required",
              ]);
              $oldPwd = $request->post('old_password');
              //判断密码
              if (Hash::check($oldPwd,$admin->password)) {
                  //设置新密码
                  $admin->password = Hash::make($request->post("password"));
                  //保存
                  $admin->save();
                  //跳转
                  return redirect()->route("admin.user.index")->with("success","密码修改成功");
              }
              return back()->with("danger", "你输入的旧密码不对");
          }
          return view("admin.admin.set_pwd",compact("admin"));
      }
      
 // header 视图  
<ul class="dropdown-menu">
                            <li><a href="{{route('admin.admin.pwd',\Illuminate\Support\Facades\Auth::guard('admin')->user()->id)}}">修改密码</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route("admin.admin.logout")}}">注销</a></li>
  </ul>
```

#### 给商家重置密码

```sh
public function rest($id){
          //找到id
             $user = User::find($id);
             $password = Hash::make(111);
             $user['password'] = $password;
             $user->save();
             return redirect()->route("admin.user.index")->with("success","密码重置成功");
       }
```

管理员，商家账号，店铺增删改查   √

#### 删除商家同时删除店铺

```sh
public function del($id){
        DB::transaction(function () use ($id) {
            //删除用户
            $user = User::find($id)->delete();
            //删除店铺
            $info = Info::where("user_id", $id)->delete();
        });
        return redirect()->route("admin.user.index")->with("success","删除成功");
    }
```

# Day_03

## 开发任务

### 商户端 

- 菜品分类管理 
- 菜品管理 

### 要求

- 一个商户只能有且仅有一个默认菜品分类 
- 只能删除空菜品分类 
- 必须登录才能管理商户后台（使用中间件实现） 
- 可以按菜品分类显示该分类下的菜品列表 
- 可以根据条件（按菜品名称和价格区间）搜索菜品

# 实现

#### 登录权限验证

```sh
# app/Exceptions/Handler.php
protected function unauthenticated($request, AuthenticationException $exception)
    {
        //return $request->expectsJson()
        //            ? response()->json(['message' => $exception->getMessage()], 401)
        //            : redirect()->guest(route('login'));
        if ($request->expectsJson()) {
            return response()->json(['message' => $exception->getMessage()], 401);
        } else {
            session()->flash("danger","没有权限");
            return in_array('admin', $exception->guards()) ? redirect()->guest(route('admin.login')) : redirect()->guest(route('user.login'));
        }
    }
    
# app/Http/Controllers/Controller.php 
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware("auth",[
            "except"=>["login","reg"]
        ]);

    }
}
```

#### 不能删除有菜品的分类

```sh
 public function del($id){
        //通过id找到他
        $menucategory = MenuCategory::find($id);
        //得到当前分类对应的菜
        $shopCount = Menu::where('category_id', $menucategory->id)->count();
        //判断
        if ($shopCount) {
            return back()->with("danger", "当前分类下有菜品，不能删除");
        }
        $menucategory->delete();
        return redirect()->route("shop.category.index")->with('success',"删除成功");
    }
```

#### 搜索分页

```sh
# 控制器
public function index(Request $request){
            $url = $request->query();
          //接收数据
            $categoryId = $request->get("category_id");
            $keyword = $request->get("keyword");
            $maxPrice = $request->get("maxPrice");
            $minPrice = $request->get("minPrice");
          //得到所有并分页
            $query = Menu::orderBy("id");
          if ($categoryId!==null) {
              $query->where("category_id",$categoryId);
          }

          if ($keyword!==null) {
              $query->where("goods_name","like","%{$keyword}%");
          }
          if ($maxPrice!=0 && $minPrice!=0){
              $query->where("goods_price",">=","$minPrice");
              $query->where("goods_price","<=","$maxPrice");
          }
          $menus = $query->paginate(3);
          //取得所有数据，显示视图
//            $menus = Menu::all();
            $results = MenuCategory::all();
            return view("shop.menu.index",compact('menus','results','url'));
      }
```

```sh
# 视图
<form class="form-inline pull-right" method="get">
            <button type="submit" class="btn btn-info">搜索</button>
            <div class="form-group">
                <select name="category_id" class="form-control">
                    <option value="">请选择</option>
                    @foreach($results as $result)
                        <option value="{{$result->id}}">{{$result->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <input type="text" class="form-control"  placeholder="搜索关键字"
                       name="keyword" value="{{request()->get("keyword")}}">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="最小金额"
                       name="minPrice" size="5" value="{{request()->get("minPrice")}}">
            </div>
            -
            <div class="form-group">
                <input type="text" class="form-control" placeholder="最大金额"
                       name="maxPrice" size="5" value="{{request()->get("maxPrice")}}">
            </div>
        </form>    
        
 <table>
    xxxxx
    xxxxx
    xxxxx
</table>
{{$goods->appends($url)->links()}}       
        
```

# Day_04

## 开发任务

优化 - 将网站图片上传到阿里云OSS对象存储服务，以减轻服务器压力(<https://github.com/jacobcyl/Aliyun-oss-storage>) - 使用webuploder图片上传插件，提升用户上传图片体验

平台 - 平台活动管理（活动列表可按条件筛选 未开始/进行中/已结束 的活动） - 活动内容使用ueditor内容编辑器(<https://github.com/overtrue/laravel-ueditor>)

商户端 - 查看平台活动（活动列表和活动详情） - 活动列表不显示已结束的活动

# 实现

### 将网站图片上传到阿里云OSS对象存储服务

注册阿里云，登录，oss操作面板，新建bucket ，标准存储，公共读

用户图像--->accesskeys--->继续使用accsskeys--->添加accesskeys--->拿到access_id和access_key

安装ali-oss插件

```sh
composer require jacobcyl/ali-oss-storage -vvv
```

修改app/filesystems.php

```sh
'oss' => [
            'driver'        => 'oss',
            'access_id'     => 'LTAIAcVIBW0IDIMN',//账号
            'access_key'    => '43kiBQcTQFP7BdJuhr3Xjj0nUX4zBy',//密钥
            'bucket'        => 'ordershop2018',//空间名称
            'endpoint'      => 'oss-cn-hangzhou.aliyuncs.com', // OSS 外网节点或自定义外部域名
        ],
```

修改.env配置文件，设置为文件上传驱动为oss

```sh
FILESYSTEM_DRIVER=oss
ALIYUN_OSS_URL=http://ordershop2018.oss-cn-hangzhou.aliyuncs.com/
ALIYUNU_ACCESS_ID=LTAIAcVIBW0IDIMN
ALIYUNU_ACCESS_KEY=43kiBQcTQFP7BdJuhr3Xjj0nUX4zBy
ALIYUNU_OSS_BUCKET=ordershop2018
ALIYUNU_OSS_ENDPOINT=oss-cn-hangzhou.aliyuncs.com
```

获取图片及缩略图

```sh
# 视图
<img src="{{env("ALIYUN_OSS_URL").$menu->goods_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">
```

### 使用webuploder图片上传插件

下载 <https://github.com/fex-team/webuploader/releases/download/0.1.5/webuploader-0.1.5.zip> 解压

引入到public目录

引用css和js到layouts的main模板里

```sh
<!--引入CSS-->
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
 <body>
        
    ....省略
    <!--引入JS-->
<script type="text/javascript" src="/webuploader/webuploader.js"></script>
@yield("js")
</body>
</html>
```

视图中添加

```sh
  <div class="form-group">
                    <label>图像</label>

                    <input type="hidden" name="logo" value="" id="logo">
                    <!--dom结构部分-->
                    <div id="uploader-demo">
                        <!--用来存放item-->
                        <div id="fileList" class="uploader-list"></div>
                        <div id="filePicker">选择图片</div>
                    </div>
                </div>
```

js部分

```sh
@section("js")
    <script>
        // 图片上传demo
        jQuery(function () {
            var $ = jQuery,
                $list = $('#fileList'),
                // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,

                // 缩略图大小
                thumbnailWidth = 100 * ratio,
                thumbnailHeight = 100 * ratio,

                // Web Uploader实例
                uploader;

            // 初始化Web Uploader
            uploader = WebUploader.create({

                // 自动上传。
                auto: true,

                formData: {
                    // 这里的token是外部生成的长期有效的，如果把token写死，是可以上传的。
                    _token:'{{csrf_token()}}'
                },


                // swf文件路径
                swf: '/webuploader/Uploader.swf',

                // 文件接收服务端。
                server: '{{route("shop.category.upload")}}',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 只允许选择文件，可选。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });

            // 当有文件添加进来的时候
            uploader.on('fileQueued', function (file) {
                var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img>' +
                    '<div class="info">' + file.name + '</div>' +
                    '</div>'
                    ),
                    $img = $li.find('img');

                $list.html($li);

                // 创建缩略图
                uploader.makeThumb(file, function (error, src) {
                    if (error) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $img.attr('src', src);
                }, thumbnailWidth, thumbnailHeight);
            });

            // 文件上传过程中创建进度条实时显示。
            uploader.on('uploadProgress', function (file, percentage) {
                var $li = $('#' + file.id),
                    $percent = $li.find('.progress span');

                // 避免重复创建
                if (!$percent.length) {
                    $percent = $('<p class="progress"><span></span></p>')
                        .appendTo($li)
                        .find('span');
                }

                $percent.css('width', percentage * 100 + '%');
            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function (file,data) {
                $('#' + file.id).addClass('upload-state-done');

                $("#logo").val(data.url);  #（#logo必须和上面视图的id一致）
            });

            // 文件上传失败，现实上传出错。
            uploader.on('uploadError', function (file) {
                var $li = $('#' + file.id),
                    $error = $li.find('div.error');

                // 避免重复创建
                if (!$error.length) {
                    $error = $('<div class="error"></div>').appendTo($li);
                }

                $error.text('上传失败');
            });

            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on('uploadComplete', function (file) {
                $('#' + file.id).find('.progress').remove();
            });
        });
    </script>
@stop
```

在控制器创建方法来上传图片,并创建路由

```sh
 public function upload(Request $request)
    {
        //处理上传

        //dd($request->file("file"));

        $file=$request->file("file");


        if ($file){
            //上传

            $url=$file->store("menu_cate");

           /// var_dump($url);
            //得到真实地址  加 http的址
            // $url=Storage::url($url);  # 这个真是路径可以不写，写了真实路径删除的时候不能删除图片

            $data['url']=$url;

            return $data;
            ///var_dump($url);
        }

    }
```

css样式

```sh
    background: #d14 url(../images/progress.png) repeat-x;
    -webit-transition: width 200ms linear;
    -moz-transition: width 200ms linear;
    -o-transition: width 200ms linear;
    -ms-transition: width 200ms linear;
    transition: width 200ms linear;
    -webkit-animation: progressmove 2s linear infinite;
    -moz-animation: progressmove 2s linear infinite;
    -o-animation: progressmove 2s linear infinite;
    -ms-animation: progressmove 2s linear infinite;
    animation: progressmove 2s linear infinite;
    -webkit-transform: translateZ(0);
}
@-webkit-keyframes progressmove {
    0% {
        background-position: 0 0;
    }
    100% {
        background-position: 17px 0;
    }
}
@-moz-keyframes progressmove {
    0% {
        background-position: 0 0;
    }
    100% {
        background-position: 17px 0;
    }
}
@keyframes progressmove {
    0% {
        background-position: 0 0;
    }
    100% {
        background-position: 17px 0;
    }
}

a.travis {
  position: relative;
  top: -4px;
  right: 15px;
}
```

视图显示图片

```sh
加了真实路径之后的写法
<img src="{{$menu->goods_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">
不加真实路径
<img src="{{env("ALIYUN_OSS_URL").$menu->goods_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">
```

### 平台 - 平台活动管理  商户端 - 查看平台活动

#### Ueditor

```sh
# 安装
composer require "overtrue/laravel-ueditor:~1.0"
# 配置
# 添加下面一行到 config/app.php 中 providers 部分：
Overtrue\LaravelUEditor\UEditorServiceProvider::class,
# 发布配置文件与资源
php artisan vendor:publish
# 引入模板
@include('vendor.ueditor.assets')
# 编辑初始化
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
    });
</script>

<!-- 编辑器容器 -->
<script id="container" name="content" type="text/plain"></script>
```

#### 搜索活动 未开始 进行中 已结束

```sh
# 视图
<form class="form-inline pull-right" method="get">
        <button type="submit" class="btn btn-info">搜索</button>
        <div class="form-group">
            <select name="time" class="form-control">
                    <option value="1">请选择活动选择状态</option>
                    <option value="2">未开始</option>
                    <option value="3">进行中</option>
                    <option value="4">已结束</option>

            </select>
        </div>

        <div class="form-group">
            <input type="text" class="form-control"  placeholder="搜索关键字"
                   name="keyword" value="{{request()->get("keyword")}}">
        </div>
    </form>
    
#控制器 
 public function index(Request $request){
        $url = $request->query();
       //接收数据
        $keyword = $request->get("keyword");
        $time = $request->get("time");
       //得到数据
        $query = Activity::orderBy("id");
       //得到当前时间
        $date = date('Y-m-d H:i:s',time());
        //未开始
        if ($time == 1){
            $query->where("start_time",">",$date);
        }
        //进行中
        if ($time == 2){
            $query->where("end_time",">=",$date)->where("start_time","<=",$date);
        }
        //已结束
        if ($time == 3){
            $query->where("end_time","<",$date);
        }
        //搜索标题和内容
        if ($keyword!==null) {
            $query->where("title","like","%{$keyword}%")->where("content","like","%{$keyword}%");
        }
        $activitys = $query->paginate(3);
        return view("admin.activity.index",compact("activitys","url"));
      }
```

#### 显示活动有效期

```sh
# 控制器
public function index(){
        $activitys=Activity::where("end_time",">=",date('Y-m-d H:i:s', time()))->get();
        return view("shop.activity.index",compact("activitys"));
     }
```

# Day_05

## 开发任务

### 接口开发

- 商家列表接口(支持商家搜索)
- 获取指定商家接口

#### 商家列表接口

```sh
//商家列表接口
    public function index(){
        //得到所有店铺，状态为1的
          $shops = Info::where("status",1)->get();
//          dump($shops->toArray());
        //追加距离 预计到餐时间
          foreach ($shops as $k => $v){
              //拼接图片地址
                $shops[$k]->shop_img = env("ALIYUN_OSS_URL").$v->shop_img;
              //追加时间和距离
                $shops[$k]->distance = rand(1000,5000);
                $shops[$k]->estimate_time = ceil($shops[$k]['distance']/rand(100,150));
          }
//          dump($shops->taArray());
        return $shops;
    }
```

> 设置路由，替换原来接口文件的接口地址

#### 指定商家接口

```sh
public function detail(){
        $id = request()->get('id');
        $shop = Info::find($id);

        //拼接图片路径
          $shop->shop_img = env("ALIYUN_OSS_URL").$shop->shop_img;
          $shop->service_code = 4.6;

        //添加评论
          $shop->evaluate = [
              [
                 "user_id" => 12344,
                 "username" => "w******k",
                 "user_img" => "http=>//www.homework.com/images/slider-pic4.jpeg",
                 "time" => "2017-2-22",
                 "evaluate_code" => 1,
                 "send_time" => 30,
                 "evaluate_details" => "不怎么好吃"],
              ["user_id" => 12344,
                 "username" => "w******k",
                 "user_img" => "http=>//www.homework.com/images/slider-pic4.jpeg",
                 "time" => "2017-2-22",
                 "evaluate_code" => 4.5,
                 "send_time" => 30,
                 "evaluate_details" => "很好吃"]
          ];
        //找出店铺下的分类
          $categorys = MenuCategory::where("shop_id",$id)->get();
        //循环取出分类下的菜品
           foreach ($categorys as $k=>$category){
               $goods = $categorys[$k]->goods_list=$category->menus;
               # 循环遍历拼接菜品的图片
               foreach ($goods as $v=>$good){
                   $goods[$v]->goods_img = env("ALIYUN_OSS_URL").$good->goods_img;
               }
           }
        $shop->commodity=$categorys->toArray();
           return $shop;
    }
```

# Day_06

## 任务

- 用户注册
- 用户登录
- 忘记密码
- 发送短信 要求
- 创建会员表
- 短信验证码发送成功后,保存到redis,并设置有效期5分钟
- 用户注册时,从redis取出验证码进行验证

## 实现

用户注册阿里云短信服务php调试代码

```php
composer require mrgoon/aliyun-sms
```

#### 用户注册

```sh
public function reg(Request $request){
        //接收全部数据
          $data = $request->all();
        //通过手机吧验证码取出来进行对比
          $code = Redis::get("tel_".$data['tel']);
          if ($code != $data['sms']) {
              $data = [
                  "status" => "false",
                  "message" => "验证码不对"
              ];
        }else{
              //密码加密
              $data['password'] = Hash::make($data['password']);
              //数据存入数据库
              if (Member::create($data)) {
                  $data = [
                      "status" => "true",
                      "message" => "注册成功"
                  ];
              }else{
                  $data = [
                      "status" => "false",
                      "message" => "注册失败"
                  ];
          }
        }
        return $data;
    }
```

#### 发送短信

```sh
public function sms(Request $request){
        //接收参数
        $tel = $request->get('tel');
        //随机生成验证码
        $code = mt_rand(1000,9999);
        //把验证码存起来
//          Redis::set("tel_".$tel,$code);
//          Redis::expire("tel_".$tel,60*5);

        Redis::setex("tel_" . $tel, 5*60, $code);
        //发送给手机
        $config = [
            'access_key' =>env("ALIYUNU_ACCESS_ID"),
            'access_secret' =>env("ALIYUNU_ACCESS_KEY"),
            'sign_name' => '个人分享ya',
        ];
        
//        //返回
        $data = [
            "status" => true,
            "message" => "获取短信验证成功".$code
        ];
        return $data;
    }
```

# Day_07

## 接口开发

- 用户地址管理相关接口
- 购物车相关接口

## 实现

### 用户地址管理相关接口

#### 地址列表

```sh
public function list(Request $request){
        //得到当前的用户id
        $memberId = $request->get("user_id");
        //所有的用户地址
        $address = Address::all();
        return $address;
    }
```

#### 添加地址

```sh
public function add(Request $request){
        //接收全部数据
        $data = $request->all();
        //默认不选中
        $data['is_selected'] = 0;
        //数据入库
        if (Address::create($data)) {
            $data = [
                'status' => 'true',
                'message' => '地址添加成功'
            ];
        }else{
            $data = [
                'status' => 'false',
                'message' => '地址添加失败'
            ];
        }
        return $data;
    }
```

#### 修改地址

```sh
public function edit(Request $request){
        $data = $request->post();
        //通过id查询一条数据
        $id = request()->get('id');
        $address = Address::find($id);
        if ($address->update($data)) {
            $data = [
                'status' => 'true',
                'message' => '地址修改成功'
            ];
        }else{
            $data = [
                'status' => 'false',
                'message' => '地址修改失败'
            ];
        }
        return $data;
        }
```

#### 指定地址,地址回显

```sh
public function index(){
        $id = request()->get('id');
        $address = Address::find($id);
        return $address;
    }
```

### 购物车相关接口

#### 购物车列表

````h
public function index(Request $request){
        //当前用户id
        $userId = $request->post('user_id');
//        dd($userId);
        //购物车列表
        $carts = Cart::where('user_id',$userId)->get();
        //声明一个数组
        $goodsList = [];
        //总价
        $totalCost = 0;
        //循环购物车
        foreach ($carts as $k => $v){
            $goods = Menu::where('id',$v->goods_id)->first(['id as goods_id','goods_name', 'goods_img', 'goods_price']);

            $goods->goods_img = env("ALIYUN_OSS_URL").$goods->goods_img;
//            dd($good->img);
            $goods->amount = $v->goods_list;
            //算总价
            $totalCost += $goods->amount * $goods->goods_price;
            $goodsList[] = $goods;
        }
//        dd($goodsList);
        $data =  [
            'goods_list' => $goodsList,
            'totalCost' => $totalCost
        ];

        return $data;

    }
````

#### 添加到购物车

```sh
public function add(Request $request){
        //bug 会出现多个值，不是当前的选中的
        Cart::where("user_id", $request->post('user_id'))->delete();
        //接收参数
        $goods = $request->post('goodsList');
        $counts = $request->post('goodsCount');

        foreach ($goods as $k => $good) {
            $data = [
                'user_id' => $request->post('user_id'),
                'goods_id' => $good,
                'goods_list' => $counts[$k]
            ];
            Cart::create($data);
        }
        return [
            'status' => "true",
            'message' => "添加成功"
        ];
    }
```


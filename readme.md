# 项目介绍--点餐系统

整个系统分为三个不同的网站，分别是

- 平台：网站管理者
- 商户：入住平台的餐馆
- 用户：订餐的用户

# 第一天

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

2.设置虚拟主机，host文件

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

7.登录，进入后台首页，判断有没有商铺，无则申请，同时判断店铺状态，店铺状态如果不为1，不能做任何操作

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

9.后台审核

```sh
public function check($id){
          $info = Info::find($id);
          $info->status= 1;
          $info->save();
          return back()->with("success","审核通过");
      }
```

10.后台登录

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

登录提示

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

注销

```sh
public function logout(){
          Auth::guard("admin")->logout();
          return redirect()->route("admin.admin.login")->with("success","退出成功");
      }
```

11.密码修改

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

给商家重置密码

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

删除商家同时删除店铺

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

# DAY03

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

登录权限验证

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

不能删除有菜品的分类

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

搜索分页

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


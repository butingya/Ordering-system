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

7.登录，进入后台首页，判断有没有商铺，无则申请

8.申请商铺

9.后台审核




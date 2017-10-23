# myAdmin
基于laravel，使用adminLTE作为UI框架的后台管理系统

[TOC]

### 1.安装

####  **安装composer依赖**
```
  composer install  
```

####  **生成应用程序密钥**

将.env.example复制一份更名为.env，修改相关配置，并生成密钥

```
  php artisan key:generate
```

#### **执行数据库迁移，并填充必要数据**

```
  php artisan migrate --seed
```

####  **创建符号链接（无文件上传可略过）**
  确保文件存储功能成功运行

```
  php artisan storage:link
```

### 2.后台访问地址

```
/admin
```
*用户名：admin*
*密码：abc123*

### 3.开发规范

####  **数据库**
   *数据库表名为全小写，单词复数格式，两个单词之间使用`_`连接*

eg
```
  admins
  action_types  
```

####  **Model**
   *Model名为首字母大写的驼峰命名法，单词单数格式*

eg
```
  Admin
  actionType
```

#### **路由（扫描添加action适用）**

   *1、路由格式为Controller/Action*  
   *2、Controller部分与表名相同（全小写，单词复数格式，两个单词之间使用`_`连接）*  
   *3、Action部分与方法名相同*  
   *4、相同功能的请求使用同一个alias别名（如create方法和store方法）*  

eg
```
    $router->get('banners/create', ['as' => 'admin.banners.create', 'uses' => 'BannerController@create']);
    $router->post('banners/store', ['as' => 'admin.banners.create', 'uses' => 'BannerController@store']);
```

####  **注释（扫描添加action适用）**
   *1.第一行为此方法功能描述，与`*`间空一格*

 eg
```
/**
 * 保存banner
 *
 * @param BannerRequest $request
 * @return \Illuminate\Http\JsonResponse
 */
```

### 2.批量扫描功能
  此功能会自动扫描所有Controller的所有非构造函数的public方法，将有正确路由格式的方法添加至permission表，功能名称为注释的第一行，如使用此功能，请按规则书写注释及路由

####  **修改Controller文件夹的路径**
打开`app/Services/PermissionService.php`,  

```
 # 控制器路径
 protected $dir = '/app/Http/Controllers/Admin';
```
`$dir`改为你`Admin`控制器文件夹所在路径（最好使用从系统根目录开始的绝对路径）

####  **请求**
```
GET permissions/set
```

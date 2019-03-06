## 权限管理
基于角色的权限管理。只需新建好角色，给对应的角色分配好相应的权限，最后给用户指定角色即可。`lightCMS`中权限的概念其实就是菜单，一条菜单对应一个`laravel`的路由，也就是一个具体的操作。

### 菜单自动获取
只需要按约定方式写好指定路由的控制器注释，则可在[菜单管理](/admin/menus)页面自动添加/更新对应的菜单信息。例如：
```php
/**
 * 角色管理-角色列表
 * 
 * 取方法的第一行注释作为菜单的名称、分组名。注释格式：分组名称-菜单名称。
 * 未写分组名称，则直接作为菜单名称，分组名为空。
 * 未写注释则选用uri作为菜单名，分组名为空。
 */
public function index()
{
    $this->breadcrumb[] = ['title' => '角色列表', 'url' => ''];
    return view('admin.role.index', ['breadcrumb' => $this->breadcrumb]);
}
```

## 自定义配置获取
首先需要将`config/light.php`配置文件中的`light_config`设置为`true`：

然后只需在[配置管理](/admin/configs)页面新增配置项或编辑已存在配置项，则在应用中可以直接使用`laravel`的配置获取函数`config`获取指定配置，例如：
```php
// 获取 key 为 SITE_NAME 的配置项值
$siteName = config('light_config.SITE_NAME');
```

## 代码一键生成
对于一个普通的模型，管理后台通常有增删改查相关的业务需求。`lightCMS`拥有一键生成相关代码的能力，在建好模型的数据库表结构后，可以使用如下`artisan`命令生成相关代码：
```bash
# config 为模型名称 配置 为模型中文名称
php artisan light:basic config 配置
```
成功执行完成后，会创建如下文件：
* app/Model/Admin/Config.php
模型：`$searchField`属性用来配置搜索字段，`$listField`用来配置列表视图中需要展示哪些字段数据。
* app/Repository/Admin/ConfigRepository.php
模型服务层：默认有一个`list`方法，该方法用来返回列表数据。需要注意的是如果列表中的数据不能和数据库字段数据直接对应，则可对数据库字段数据做相应转换，可参考`list`方法中的`transform`部分。
* app/Http/Controllers/Admin/ConfigController.php
控制器：默认有一个`$formNames`属性，用来配置新增/编辑表单请求字段的白名单。此属性必需配置，否则获取不到表单数据。参考 [request 对象的 only 方法](https://laravel.com/docs/5.5/requests#retrieving-input)
* app/Http/Requests/Admin/ConfigRequest.php 
表单请求类：可在此类中编写表单验证规则，参考 [Form Request Validation](https://laravel.com/docs/5.5/validation#form-request-validation)
* resources/views/admin/config/index.blade.php
列表视图：列表数据、搜索表单。
* resources/views/admin/config/index.blade.php
新增/编辑视图：只列出了基本架构，需要自定义相关字段的表单展示。参考 [layui form](https://www.layui.com/doc/element/form.html)

## 系统日志

## 完善中。。。
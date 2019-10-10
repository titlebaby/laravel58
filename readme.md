# laravel58
### 创建验证器
```$xslt
php artisan make:request Api/FormRequest
```
###  数据填充
1. 定义一个数据模型工厂，在 database/factories/ApiUserFactory.php 中添加如下代码

```$xslt

$factory->define(App\Models\ApiUser::class, function (Faker $faker) {
    static $password ;
    return [
        'name' => $faker->name,
        'password' => $password ?: $password = bcrypt('secret'), // password
        //'last_token' => Str::random(10),
    ];
});

```
2. 使用 Faker 随机填充用户名
在 database/seeds 目录下生成 ApiUsersTableSeeder.php 文件。
```$xslt
php artisan make:seeder ApiUsersTableSeeder
```
编辑 database/seeds/ApiUsersTableSeeder.php 文件的 run 方法，添加10个用户，密码为 123456

```$xslt
   public function run()
     {
         factory('App\Models\ApiUser', 10)->create([
             'password' => bcrypt('123456')
         ]);
     }
```
3. 在 database/seeds/DatabaseSeeder.php 的 run 方法里调用 
```$xslt
public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call(ApiUsersTableSeeder::class);
    }
```

4. 执行数据库迁移命令
```$xslt
 php artisan migrate --seed
```


### 跨域的处理
1. 安装 medz/cors
```$xslt
composer require medz/cors
```
2. 发布配置文件.... 应用文档具体查看
  ```$xslt
  #应用文档具体查看
https://learnku.com/articles/25947#bef49e
```
### ViewModel 资源转换未数组
1. 新建资源文件
```$xslt
# 在http目录下张近东生成 resouces文件夹
php artisan make:resource Api/UserResource
```
2. 控制层，输出调用资源层
```$xslt
#返回单一的资源
return $this->success(new UserResource($user));
#返回资源列表

return UserResource::collection($users);
```

### 统一response格式
1. 构建统一response的基类
2. 继承基类
2.1 统一管理资源中类似枚举型的字段，使用viewModel
3. 构建异常错误处理，根据"统一response的基类"的格式返回，即调用继承基类
4. 拦截exception的异常，到构建的异常处理类中。拦截，即为：修改 app/Exceptions 目录下的 Handler.php 文件的render方法。
postman设置为ajax请求，可在header中进行设置
```$xslt
X-Requested-With:XMLHttpRequest
```






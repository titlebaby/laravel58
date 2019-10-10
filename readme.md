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




<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class ApiUser extends  Authenticatable
{
    use Notifiable;
    protected $table = 'api_users';

    //去掉我创建的数据表没有的字段
    protected $fillable = [
        'name', 'password'
    ];

    //去掉我获取的数据表没有的字段
    protected $hidden = [
        'password'
    ];

    //将密码进行加密
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

}

<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends  Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'admins';

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

    /**
     * 必须实现接口
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}

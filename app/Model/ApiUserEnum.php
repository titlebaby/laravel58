<?php
/**
 * Created by PhpStorm.
 * User: linger
 * Date: 2019-10-10
 * Time: 21:43
 */

namespace App\Model;

/**
 * PHP 和 Laravel框架本身是不支持 Enum枚举的，
 * 不过我们可以模拟枚举的功能
 * Class ApiUserEnum
 * @package App\Model
 */
class ApiUserEnum
{
    // 状态类别
    const INVALID = -1; //已删除
    const NORMAL = 0; //正常
    const FREEZE = 1; //冻结

    public static function getStatusName($status){
        switch ($status){
            case self::INVALID:
                return '已删除';
            case self::NORMAL:
                return '正常';
            case self::FREEZE:
                return '冻结';
            default:
                return '正常';
        }
    }

}

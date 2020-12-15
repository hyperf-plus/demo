<?php

declare (strict_types=1);

namespace App\Model;

use Qbhy\HyperfAuth\Authenticatable;

/**
 * @property int $id
 * @property string $username 账号
 * @property string $password 密码
 * @property string $id_card 身份证
 * @property string $mobile 手机
 * @property int $is_mobile 是否验证 0=否 1=是
 * @property string $email 邮箱
 * @property string $openid openid
 * @property string $unionid openid
 * @property int $total 快乐个数
 * @property string $nickname 昵称
 * @property string $head_pic 头像
 * @property int $sex 0=保密 1=男 2=女
 * @property string $birthday 生日
 * @property string $level_icon 等级图标
 * @property int $user_level_id 对应user_level表
 * @property int $user_address_id 对应user_address表
 * @property int $money 金额
 * @property int $last_login 最后登录日期
 * @property string $last_ip 最后登录ip
 * @property int $status 0=禁用 1=启用
 * @property int $is_delete 0=未删 1=已删
 * @property int $create_time 创建日期
 * @property int $update_time 更新日期
 * @property int $user_type step
 * @property string $introduce 个人介绍
 * @property int $pid 上级id
 */
class Member extends Model implements Authenticatable
{
    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    protected $dateFormat = 'U';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'username', 'password', 'id_card', 'mobile', 'is_mobile', 'email', 'openid', 'unionid', 'total', 'nickname', 'head_pic', 'sex', 'birthday', 'level_icon', 'user_level_id', 'user_address_id', 'money', 'last_login', 'last_ip', 'status', 'is_delete', 'create_time', 'update_time', 'user_type', 'introduce', 'pid', 'family_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'is_mobile' => 'integer', 'total' => 'integer', 'sex' => 'integer', 'user_level_id' => 'integer', 'user_address_id' => 'integer', 'money' => 'integer', 'last_login' => 'integer', 'status' => 'integer', 'is_delete' => 'integer', 'create_time' => 'integer', 'update_time' => 'integer', 'user_type' => 'integer', 'pid' => 'integer', 'family_id' => 'integer'];

    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    public static function retrieveById($key): ?Authenticatable
    {
        // TODO: Implement retrieveById() method.
        return static::findFromCache($key);
    }

    public function setMoneyAttribute($value)
    {
        $this->attributes['money'] = $value * 100;
    }

    public function getMoneyAttribute()
    {
        return toPrice($this->attributes['money']);
    }

    public function getUpdateTimeAttribute()
    {
        return date("Y-m-d H:i:s", (int)$this->attributes['update_time']);
    }

    public function getCreateTimeAttribute()
    {
        return date("Y-m-d H:i:s",(int) $this->attributes['create_time']);
    }

}
<?php

declare (strict_types=1);

namespace App\Model;

/**
 * @property int $verification_id
 * @property string $mobile 号码
 * @property string $send_ip ip
 * @property int $user_id user
 * @property string $code 验证码
 * @property int $status 0=无效 1=有效
 * @property int $type 1:绑定手机  2:安全验证 3:登录
 * @property string $create_time 创建日期
 * @property string $update_time 创建日期
 */
class VerifyCode extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'verification_id';
    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'verification';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['verification_id', 'mobile', 'time', 'send_ip', 'user_id', 'code', 'status', 'type', 'create_time', 'update_time'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['verification_id' => 'integer', 'user_id' => 'integer','time' => 'integer', 'status' => 'integer', 'type' => 'integer'];
}
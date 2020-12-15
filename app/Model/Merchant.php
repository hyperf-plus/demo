<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.plus
 * @link     https://www.hyperf.plus
 * @document https://doc.hyperf.plus
 * @contact  4213509@qq.com
 * @license  https://github.com/hyperf-plus/admin/blob/master/LICENSE
 */
namespace App\Model;

use Hyperf\Database\Model\Relations\BelongsToMany;

/**
 * @property int $merchant_id 商户id
 * @property int $cate_id 商户分类 id
 * @property string $name 商户名称
 * @property string $real_name 商户姓名
 * @property string $address 商户地址
 * @property string $keyword 商户关键字
 * @property string $avatar 商户头像
 * @property string $banner 商户banner图片
 * @property int $sales 销量
 * @property string $mark 商户备注
 * @property int $user_id 总后台管理员ID
 * @property int $sort
 * @property int $status 商户是否禁用0锁定,1正常
 * @property int $is_del 0未删除1删除
 * @property int $is_audit 添加的产品是否审核0不审核1审核
 * @property int $is_best 是否推荐
 * @property int $state 商户是否1开启0关闭
 * @property string $info 店铺简介
 * @property string $phone 店铺电话
 * @property int $wd_money 已提现金额
 * @property int $lock_money 冻结资金(即提现中，审核中的金额)
 * @property string $bank_name 提现的开户行名称
 * @property string $bank_user 提现的开户行户名
 * @property int $total_money 累计资金
 * @property string $create_time
 * @property string $update_time
 */
class Merchant extends Model
{
    const UPDATED_AT = 'update_at';
    const CREATED_AT = 'create_at';


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'merchant';

    protected $primaryKey = 'merchant_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['merchant_id', 'cate_id', 'name', 'real_name', 'wd_money', 'lock_money', 'bank_name', 'bank_user', 'total_money', 'address', 'avatar', 'banner', 'sales', 'mark', 'user_id', 'sort', 'status', 'is_del', 'is_audit', 'is_best', 'state', 'info', 'phone', 'create_time', 'update_time'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['merchant_id' => 'integer', 'cate_id' => 'integer', 'wd_money' => 'integer', 'lock_money' => 'integer', 'total_money' => 'integer', 'sales' => 'integer', 'user_id' => 'integer', 'sort' => 'integer', 'status' => 'integer', 'is_del' => 'integer', 'is_audit' => 'integer', 'is_best' => 'integer', 'state' => 'integer'];

    /**
     * A role belongs to many users.
     */
    public function manages(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'merchant_users', 'merchant_id', 'user_id');
    }

    public function getWdMoneyAttribute()
    {
        return toPrice($this->attributes['wd_money']);
    }

    public function getLockMoneyAttribute()
    {
        return toPrice($this->attributes['lock_money']);
    }

    public function getTotalMoneyAttribute()
    {
        return toPrice($this->attributes['total_money']);
    }

//    public function merchant()
//    {
//        return $this->hasOne(Merchant::class, 'merchant_id', 'merchant_id')->select(['merchant_id', Db::raw('count(1) as count')]);
//    }
}

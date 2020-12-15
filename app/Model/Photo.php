<?php

declare (strict_types=1);

namespace App\Model;

/**
 * @property int $id
 * @property string $title 可读配置名
 * @property string $remark 备注
 * @property string $content json
 * @property int $status 状态
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $image 照片
 * @property int $user_id
 */
class Photo extends Model
{
    const STATUS = ['草稿', '待支付', '已种'];
    const STATUS_TAGS = [
        '草稿' => 'danger',
        '待支付' => 'info',
        '已种' => 'success'
    ];

    protected $appends = ['sku'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'photo';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'title', 'remark', 'content', 'status', 'created_at', 'updated_at', 'image', 'user_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer', 'content' => 'json', 'created_at' => 'datetime|Y-m-d H:i:s', 'updated_at' => 'datetime|Y-m-d H:i:s', 'user_id' => 'integer'];


    public function user()
    {
        return $this->hasOne(Member::class, 'id', 'user_id');
    }

    public function getSkuAttribute()
    {
        return json_decode('{"sku":[{"name":"10寸","money":30},{"name":"12寸","money":35}],"express":[{"name":"邮寄","money":10},{"name":"网络邮箱","money":0}],"type":[{"name":"有边框","money":10},{"name":"无边框","money":0}]}',true);
    }
}
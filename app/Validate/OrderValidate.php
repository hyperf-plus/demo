<?php
declare(strict_types=1);

namespace App\Validate;


use HPlus\Validate\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'photo_id' => 'require',
        'address_id' => 'require',
        'size' => 'require',
        'delivery_type' => 'require|in:1,2',
        'delivery_at' => 'require|date',
        'type' => 'require|in:1,2'
    ];

    protected $field = [
        'photo_id' => '种子ID',
        'address_id' => '地址ID',
        'size' => '照片尺寸',
        'delivery_type' => '邮寄方式',
        'delivery_at' => '邮寄日期',
        'type' => '类型'
    ];

    protected $scene = [
        'make' => [
            'photo_id',
            'address_id',
            'size',
            'delivery_type',
            'delivery_at',
            'type'
        ],
        'list' => ['limit', 'page', 'status'],
    ];
}

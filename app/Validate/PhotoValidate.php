<?php
declare(strict_types=1);

namespace App\Validate;


use HPlus\Validate\Validate;

class PhotoValidate extends Validate
{
    protected $rule = [
        'title' => 'require',
        'name' => 'max:255',
        'image' => 'max:1000',
        'remark' => 'max:255',
        'content' => 'max:255',
        'status' => 'max:255',
        'page' => 'integer',
        'limit' => 'integer|gt:0',
    ];

    protected $field = [
        'title' => '标题',
        'image' => '图片',
        'remark' => '备注',
        'content' => '内容',
        'status' => '状态',
        'create_time' => '创建时间',
        'get_time' => '收取时间',
        'page' => '页码',
        'limit' => '每页条数',
    ];

    protected $scene = [
        'update' => ['title', 'remark', 'image', 'content', 'status'],

        'upload' => ['title' => 'require', 'image' => 'require', 'content' => 'require|array'],

        'list' => ['limit', 'page', 'status', 'create_time'],

        'order' => ['limit', 'page', 'get_time'],

        'sort' => ['sort'],
        'status' => ['status' => 'require|in:0,1,2'],
        'create' => ['title', 'remark', 'image', 'content', 'status'],
    ];
}

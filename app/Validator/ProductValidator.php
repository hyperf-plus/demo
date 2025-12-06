<?php

declare(strict_types=1);

namespace App\Validator;

use Hyperf\Validation\Request\FormRequest;

/**
 * 产品验证器（Hyperf 风格）
 */
class ProductValidator extends FormRequest
{
    /**
     * 场景定义
     */
    protected array $scenes = [
        'create' => ['name', 'description', 'price', 'stock', 'category_id', 'sku', 'images', 'status'],
        'update' => ['name', 'description', 'price', 'stock', 'category_id', 'images', 'status'],
        'import' => ['products'],
    ];

    /**
     * 验证规则
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:2,100',
            'description' => 'string|max:500',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|integer|min:1',
            'sku' => 'required|string|max:50',
            'images' => 'array|max:10',
            'images.*' => 'url',
            'status' => 'integer|in:0,1',
            'products' => 'required|array|min:1|max:1000',
            'products.*.name' => 'required|string|between:2,100',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.stock' => 'required|integer|min:0',
            'products.*.sku' => 'required|string|max:50',
        ];
    }

    /**
     * 错误消息
     */
    public function messages(): array
    {
        return [
            'name.required' => '产品名称不能为空',
            'name.between' => '产品名称长度必须在2-100个字符之间',
            'price.required' => '产品价格不能为空',
            'price.numeric' => '产品价格必须是数字',
            'price.min' => '产品价格不能小于0',
            'stock.required' => '库存数量不能为空',
            'stock.integer' => '库存数量必须是整数',
            'stock.min' => '库存数量不能小于0',
            'images.max' => '产品图片最多10张',
        ];
    }

    /**
     * 字段别名
     */
    public function attributes(): array
    {
        return [
            'name' => '产品名称',
            'price' => '价格',
            'stock' => '库存',
            'category_id' => '分类',
            'sku' => 'SKU',
        ];
    }
}

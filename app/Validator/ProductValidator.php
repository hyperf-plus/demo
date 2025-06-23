<?php

declare(strict_types=1);

namespace App\Validator;

use HPlus\Validate\Validate;

/**
 * 产品验证器
 */
class ProductValidator extends Validate
{
    protected $rule = [
        'name' => 'required|string|between:2,100',
        'description' => 'string|max:500',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|integer|min:1',
        'sku' => 'required|string|max:50|unique:products',
        'images' => 'array|max:10',
        'images.*' => 'url',
        'status' => 'integer|in:0,1'
    ];
    
    protected $message = [
        'name.required' => '产品名称不能为空',
        'name.between' => '产品名称长度必须在2-100个字符之间',
        'price.required' => '产品价格不能为空',
        'price.numeric' => '产品价格必须是数字',
        'price.min' => '产品价格不能小于0',
        'stock.required' => '库存数量不能为空',
        'stock.integer' => '库存数量必须是整数',
        'stock.min' => '库存数量不能小于0',
        'sku.unique' => 'SKU已存在',
        'images.max' => '产品图片最多10张'
    ];
    
    /**
     * 创建场景
     */
    protected function sceneCreate()
    {
        return $this->only(['name', 'description', 'price', 'stock', 'category_id', 'sku', 'images', 'status']);
    }
    
    /**
     * 更新场景
     */
    protected function sceneUpdate()
    {
        return $this->remove('sku', 'unique')
            ->only(['name', 'description', 'price', 'stock', 'category_id', 'sku', 'images', 'status']);
    }
    
    /**
     * 导入场景
     */
    protected function sceneImport()
    {
        return $this->only(['products'])
            ->rule('products', 'required|array|min:1|max:1000')
            ->rule('products.*.name', 'required|string|between:2,100')
            ->rule('products.*.price', 'required|numeric|min:0')
            ->rule('products.*.stock', 'required|integer|min:0')
            ->rule('products.*.sku', 'required|string|max:50');
    }
} 
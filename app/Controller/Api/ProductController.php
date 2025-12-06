<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Validator\ProductValidator;
use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\PostApi;
use HPlus\Route\Annotation\PutApi;
use HPlus\Validate\Annotations\RequestValidation;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use App\Controller\AbstractController;

/**
 * 产品管理
 */
#[ApiController(tag: "产品管理")]
class ProductController extends AbstractController
{
    /**
     * 创建产品
     */
    #[PostApi(path: "", summary: "创建产品")]
    #[RequestValidation(validate: ProductValidator::class, scene: "create")]
    public function store(RequestInterface $request)
    {
        $data = $request->all();

        return [
            'id' => rand(1, 999),
            'name' => $data['name'],
            'price' => $data['price']
        ];
    }

    /**
     * 更新产品
     */
    #[PutApi(path: "{id}", summary: "更新产品")]
    #[RequestValidation(validate: ProductValidator::class, scene: "update")]
    public function update(int $id, RequestInterface $request)
    {
        return [
            'code' => 0,
            'message' => '更新成功'
        ];
    }

    /**
     * 导入产品
     */
    #[PostApi(path: "import", summary: "批量导入产品")]
    #[RequestValidation(validate: ProductValidator::class, scene: "import")]
    public function import(RequestInterface $request)
    {
        $products = $request->input('products', []);

        return [
            'total' => count($products),
            'success' => count($products)
        ];
    }
}
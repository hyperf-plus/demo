<?php

declare(strict_types=1);

namespace App\Controller;

use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\GetApi;
use HPlus\Route\Annotation\PostApi;
use HPlus\Route\Annotation\PutApi;
use HPlus\Route\Annotation\DeleteApi;
use HPlus\Validate\Annotations\RequestValidation;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * 用户管理
 */
#[ApiController(prefix: "/api/users", tag: "用户管理", description: "用户相关接口")]
class UserController extends AbstractController
{
    /**
     * 用户列表
     */
    #[GetApi(path: "", summary: "获取用户列表")]
    #[RequestValidation(rules: [
        'page' => 'integer|min:1',
        'keyword' => 'string|max:50'
    ])]
    public function index(RequestInterface $request)
    {
        $page = (int) $request->input('page', 1);
        $keyword = $request->input('keyword', '');
        
        // 模拟数据
        $users = [
            ['id' => 1, 'name' => '张三', 'email' => 'zhang@example.com'],
            ['id' => 2, 'name' => '李四', 'email' => 'li@example.com'],
        ];
        
        return $this->response->json([
            'code' => 0,
            'data' => $users,
            'page' => $page
        ]);
    }

    /**
     * 创建用户
     */
    #[PostApi(path: "", summary: "创建用户")]
    #[RequestValidation(rules: [
        'name' => 'required|string|max:50',
        'email' => 'required|email',
        'password' => 'required|min:6',
        'phone' => 'required|mobile'
    ])]
    public function store(RequestInterface $request)
    {
        $data = $request->all();
        
        // 模拟创建
        $user = [
            'id' => rand(1, 999),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone']
        ];
        
        return $this->response->json([
            'code' => 0,
            'message' => '创建成功',
            'data' => $user
        ]);
    }

    /**
     * 更新用户
     */
    #[PutApi(path: "{id}", summary: "更新用户")]
    #[RequestValidation(rules: [
        'name' => 'string|max:50',
        'email' => 'email',
        'phone|手机号' => 'mobile'
    ])]
    public function update(int $id, RequestInterface $request)
    {
        $data = $request->all();
        
        return $this->response->json([
            'code' => 0,
            'message' => '更新成功',
            'data' => array_merge(['id' => $id], $data)
        ]);
    }

    /**
     * 删除用户
     */
    #[DeleteApi(path: "{id}", summary: "删除用户")]
    public function destroy(int $id)
    {
        return $this->response->json([
            'code' => 0,
            'message' => '删除成功'
        ]);
    }
} 
<?php

declare(strict_types=1);

namespace App\Controller;

use HPlus\Route\Annotation\GetApi;
use HPlus\Route\Annotation\ApiController;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use HPlus\Route\Annotation\PostApi;
use HPlus\Validate\Annotations\RequestValidation;

/**
 * 测试页面
 */
#[ApiController(tag: "测试", description: "API 测试页面")]
class TestController extends AbstractController
{

    #[GetApi(path: "", summary: "首页")]
    public function index()
    {
        $html = '<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HPlus 插件演示</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; }
        h1 { color: #333; text-align: center; }
        .section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #666; margin-top: 0; }
        .api-list { list-style: none; padding: 0; }
        .api-item { padding: 10px; margin: 5px 0; background: #f8f8f8; border-radius: 4px; display: flex; align-items: center; }
        .method { padding: 4px 8px; border-radius: 3px; font-size: 12px; font-weight: bold; margin-right: 10px; }
        .get { background: #e3f2fd; color: #1976d2; }
        .post { background: #e8f5e8; color: #388e3c; }
        .put { background: #fff3e0; color: #f57c00; }
        .delete { background: #ffebee; color: #d32f2f; }
        .endpoint { font-family: monospace; color: #333; flex: 1; }
        .description { color: #666; font-size: 14px; }
        .highlight { background: #fffde7; padding: 15px; border-left: 4px solid #fbc02d; margin: 10px 0; }
        .code { background: #f5f5f5; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 14px; margin: 10px 0; overflow-x: auto; }
        .link { color: #1976d2; text-decoration: none; font-weight: bold; }
        .link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 HPlus 插件演示</h1>
        
        <div class="section">
            <h2>✨ 核心优势</h2>
            <div class="highlight">
                <strong>一个注解，搞定三件事：</strong>
                <ol>
                    <li>📍 <strong>路由注册</strong> - 使用 @GetApi、@PostApi 等注解自动注册路由</li>
                    <li>📄 <strong>文档生成</strong> - 根据验证规则自动生成 Swagger 文档</li>
                    <li>✅ <strong>参数验证</strong> - 使用 @RequestValidation 或 @Validation 进行数据验证</li>
                </ol>
            </div>
        </div>

        <div class="section">
            <h2>👥 用户管理示例</h2>
            <p class="description">展示最简化的使用方式</p>
            <ul class="api-list">
                <li class="api-item">
                    <span class="method get">GET</span>
                    <span class="endpoint">/api/users</span>
                    <span class="description">用户列表</span>
                </li>
                <li class="api-item">
                    <span class="method post">POST</span>
                    <span class="endpoint">/api/users</span>
                    <span class="description">创建用户（自动验证参数）</span>
                </li>
                <li class="api-item">
                    <span class="method put">PUT</span>
                    <span class="endpoint">/api/users/{id}</span>
                    <span class="description">更新用户</span>
                </li>
                <li class="api-item">
                    <span class="method delete">DELETE</span>
                    <span class="endpoint">/api/users/{id}</span>
                    <span class="description">删除用户</span>
                </li>
            </ul>
            <div class="code">// 示例代码
#[GetApi(path: "", summary: "获取用户列表")]
#[RequestValidation(rules: [
    \'page\' => \'integer|min:1\',
    \'keyword\' => \'string|max:50\'
])]
public function index(RequestInterface $request): ResponseInterface
{
    // 路由自动注册，参数自动验证，文档自动生成
}</div>
        </div>

        <div class="section">
            <h2>📝 文章管理示例</h2>
            <p class="description">展示更多验证规则的使用</p>
            <ul class="api-list">
                <li class="api-item">
                    <span class="method get">GET</span>
                    <span class="endpoint">/api/articles</span>
                    <span class="description">文章列表</span>
                </li>
                <li class="api-item">
                    <span class="method post">POST</span>
                    <span class="endpoint">/api/articles</span>
                    <span class="description">创建文章</span>
                </li>
                <li class="api-item">
                    <span class="method post">POST</span>
                    <span class="endpoint">/api/articles/batch/review</span>
                    <span class="description">批量审核</span>
                </li>
            </ul>
        </div>

        <div class="section">
            <h2>🛍️ 产品管理示例</h2>
            <p class="description">展示验证器类的使用</p>
            <ul class="api-list">
                <li class="api-item">
                    <span class="method post">POST</span>
                    <span class="endpoint">/api/products</span>
                    <span class="description">创建产品（使用 ProductValidator）</span>
                </li>
                <li class="api-item">
                    <span class="method put">PUT</span>
                    <span class="endpoint">/api/products/{id}</span>
                    <span class="description">更新产品</span>
                </li>
                <li class="api-item">
                    <span class="method post">POST</span>
                    <span class="endpoint">/api/products/import</span>
                    <span class="description">批量导入</span>
                </li>
            </ul>
            <div class="code">// 使用验证器类
#[Validation(validate: ProductValidator::class, scene: "create")]
public function store(RequestInterface $request): ResponseInterface
{
    // 使用验证器的 create 场景
}</div>
        </div>

        <div class="section">
            <h2>🔗 快速访问</h2>
            <p>
                <a href="/swagger" class="link" target="_blank">📖 查看 Swagger 文档</a>
            </p>
        </div>
    </div>
</body>
</html>';

        return $this->response->html($html);
    }

    /**
     * GET 请求 - 应该显示为查询参数
     */
    #[GetApi(path: '/get-test', summary: 'GET请求测试')]
    #[RequestValidation(rules: [
        'page|页码' => 'integer|min:1|default:1',
        'size|每页数量' => 'integer|min:1|max:100|default:20',
        'keyword|搜索关键词' => 'string|max:100',
        'status|状态' => 'in:active,inactive'
    ])]
    public function getTest(): array
    {
        return [
            'method' => 'GET',
            'params' => $this->request->getQueryParams()
        ];
    }

    /**
     * POST 请求 - 应该显示为请求体
     */
    #[PostApi(path: '/post-test', summary: 'POST请求测试')]
    #[RequestValidation(
        rules: [
            'name|姓名' => 'required|string|max:50',
            'email|邮箱' => 'required|email',
            'age|年龄' => 'integer|min:1|max:120'
        ],
        dateType: 'json'
    )]
    public function postTest(): array
    {
        return [
            'method' => 'POST',
            'data' => $this->request->getParsedBody()
        ];
    }

    /**
     * POST 请求但使用表单数据 - 应该显示为查询参数
     */
    #[PostApi(path: '/form-test', summary: 'POST表单测试')]
    #[RequestValidation(
        rules: [
            'username|用户名' => 'required|string|max:20',
            'password|密码' => 'required|string|min:6'
        ],
        dateType: 'form'
    )]
    public function formTest(): array
    {
        return [
            'method' => 'POST',
            'form_data' => $this->request->getParsedBody()
        ];
    }
} 
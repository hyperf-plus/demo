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

/**
 * 文章管理
 */
#[ApiController(tag: "文章管理")]
class ArticleController extends AbstractController
{
    /**
     * 文章列表
     */
    #[GetApi(summary: "获取文章列表")]
    #[RequestValidation(rules: [
        'page' => 'integer|min:1',
        'per_page' => 'integer|between:1,50',
        'status' => 'integer|in:0,1,2',  // 0-草稿 1-已发布 2-已下架
        'category_id' => 'integer|min:1'
    ])]
    public function index(RequestInterface $request)
    {
        return [
            'list' => [
                ['id' => 1, 'title' => 'Hyperf 入门教程', 'status' => 1],
                ['id' => 2, 'title' => 'Swoole 协程原理', 'status' => 1],
            ],
            'total' => 2
        ];
    }

    /**
     * 创建文章
     */
    #[PostApi(summary: "创建文章")]
    #[RequestValidation(rules: [
        'title' => 'required|string|between:5,200',
        'content' => 'required|string|min:10',
        'category_id' => 'required|integer|min:1',
        'tags' => 'array|max:10',
        'tags.*' => 'string|max:20',
        'status' => 'integer|in:0,1'  // 0-草稿 1-立即发布
    ])]
    public function store(RequestInterface $request)
    {
        $data = $request->all();

        return [
            'id' => rand(1, 999),
            'title' => $data['title'],
            'status' => $data['status'] ?? 0
        ];
    }

    /**
     * 更新文章
     */
    #[PutApi(summary: "更新文章")]
    #[RequestValidation(rules: [
        'title' => 'string|between:5,200',
        'content' => 'string|min:10',
        'category_id' => 'integer|min:1',
        'tags' => 'array|max:10',
        'tags.*' => 'string|max:20',
        'status' => 'integer|in:0,1,2'
    ])]
    public function update(int $id,RequestInterface $request)
    {


        return [
            'code' => 0,
            'id' => $id,
            'data' => $request->all(),
            'message' => '更新成功'
        ];
    }

    /**
     * 删除文章
     */
    #[DeleteApi(path: "{id}", summary: "删除文章")]
    public function destroy(int $id)
    {
        return $this->response->json([
            'code' => 0,
            'message' => '删除成功'
        ]);
    }

    /**
     * 批量审核
     */
    #[PostApi(path: "batch/review", summary: "批量审核文章")]
    #[RequestValidation(rules: [
        'ids' => 'required|array|min:1|max:100',
        'ids.*' => 'integer|min:1',
        'action' => 'required|in:approve,reject',
        'reason' => 'required_if:action,reject|string|max:200'
    ])]
    public function batchReview(RequestInterface $request)
    {
        $ids = $request->input('ids');
        $action = $request->input('action');

        return $this->response->json([
            'code' => 0,
            'message' => $action === 'approve' ? '批量通过成功' : '批量拒绝成功',
            'data' => [
                'affected' => count($ids)
            ]
        ]);
    }
} 
<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller\Api\V1;

use App\Controller\AbstractController;
use HPlus\Admin\Exception\BusinessException;
use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\Body;
use HPlus\Route\Annotation\GetApi;
use HPlus\Route\Annotation\PostApi;
use HPlus\Route\Annotation\Query;
use HPlus\Validate\Annotations\RequestValidation;
use App\Validate\PhotoValidate;

/**
 * @ApiController(tag="种子管理")
 * Class Photo
 * @package App\Controller\Api\V1
 */
class Photo extends AbstractController
{
    /**
     * @GetApi()
     * @return array
     */
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    /**
     * @PostApi(summary="创建种子数据",security=true)
     * @RequestValidation(validate=PhotoValidate::class,scene="upload")
     */
    public function upload()
    {
        $data = $this->request->getParsedBody();
        $data['user_id'] = $this->auth->user()->getId();
        $data['status'] = 0;
        $result = \App\Model\Photo::query()->create($data);
        return $this->response->json($result);
    }

    /**
     * @PostApi (path="pay",summary="种子付款",security=true)
     * @Query(key="id")
     */
    public function postPay()
    {
        $data = $this->request->all();

        p($data);

    }

    /**
     * @GetApi (summary="种子付款",security=true)
     * @Query(key="id")
     */
    public function pay()
    {
        $id = $this->request->query('id');
        $user_id = $this->auth->user()->getId();
        $result = \App\Model\Photo::query()->where('user_id', $user_id)->find($id);
        if (empty($result)) {
            throw new BusinessException(403, "种子不存在");
        }
        if ($result->status == 1) {
            throw new BusinessException(403, "该种子已种下");
        }
        $data = [];
        $data['pay_type'] = [
            [
                'type' => "wxpay",
                'name' => '微信支付'
            ],
            [
                'type' => "account",
                'name' => '余额支付'
            ]
        ];
        $data['total_money'] = toPrice(8000);
        $data['info'] = $result;
        $data['account_money'] = toPrice($this->auth->user()->money);
        return $this->response->json($data);
    }

}

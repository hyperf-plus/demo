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
use HPlus\Route\Annotation\GetApi;
use HPlus\Route\Annotation\PostApi;
use HPlus\Route\Annotation\Query;
use HPlus\Validate\Annotations\RequestValidation;
use App\Validate\OrderValidate;
use HPlus\Helper\DbHelper\GetQueryHelper;

/**
 * @ApiController(tag="订单管理")
 * Class Photo
 * @package App\Controller\Api\V1
 */
class Order extends AbstractController
{
    use GetQueryHelper;

    /**
     * @PostApi(summary="创建订单",security=true)
     * @RequestValidation(validate=OrderValidate::class,scene="make")
     */
    public function make()
    {
        $data = $this->request->getParsedBody();
        $data['user_id'] = $this->auth->user()->getId();
        $data['order_no'] = date("YmdHis") . rand(10000000, 99999999);
        $result = \App\Model\Order::query()->create($data);
        return $this->response->json($result);
    }

    /**
     * @GetApi (summary="查询订单",security=true)
     * @Query(key="limit")
     * @Query(key="page")
     * @Query(key="status")
     */
    public function list()
    {
        switch ($this->request->query('status')) {
            case 0:
            case 1:
                $model = \App\Model\Photo::query();
                $model->where('status', $this->request->query('status'));
                break;
            default:
                $model = \App\Model\Order::query();
                $model->with('photo');
                break;
        }
        $model->where('user_id', $this->auth->user()->getId());
        $query = $this->QueryHelper($model, $this->request->all());
        $query = $query->dateBetween('created_at');
        $res = $query->paginate();
        return $this->response->json($res);
    }

    /**
     * @GetApi (summary="订单付款",security=true)
     * @Query(key="id")
     */
    public function pay()
    {
        $id = $this->request->query('id');
        $user_id = $this->auth->user()->getId();
        $result = \App\Model\Order::query()->find($id);
        if (empty($result)) {
            throw new BusinessException(403, "订单不存在");
        }
        if ($result->status == 1) {
            throw new BusinessException(403, "该订单已支付");
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
        $data['total_money'] = toPrice($result->price_total);
        $data['info'] = $result;
        $data['account_money'] = toPrice($this->auth->user()->money);
        return $this->response->json($data);
    }
}

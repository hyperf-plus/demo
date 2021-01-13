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
use App\Service\UserService;
use HPlus\Admin\Traits\HasApiDelete;
use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\GetApi;
use HPlus\Route\Annotation\PostApi;
use HPlus\UI\Form;
use HPlus\Validate\Annotations\RequestValidation;
use Hyperf\Di\Annotation\Inject;
use App\Validate\OrderValidate;
use HPlus\Helper\DbHelper\GetQueryHelper;
use Qbhy\HyperfAuth\AuthManager;

/**
 * @ApiController(tag="用户收货地址管理")
 * Class Photo
 * @package App\Controller\Api\V1
 */
class UserAddress extends AbstractController
{
    use GetQueryHelper;
    use HasApiDelete;

    public function __construct(AuthManager $authManager)
    {
        parent::__construct($authManager);
    }


    /**
     * @Inject()
     * @var UserService
     */
    private $userService;

    /**
     * @GetApi (summary="收货地址管理",security=true)
     * @RequestValidation(validate=OrderValidate::class,scene="list",dateType="form")
     */
    public function list()
    {
        $result = \App\Model\UserAddress::query();
        $result = $result->where('user_id', $this->auth->user()->getId());
        $res = $this->QueryHelper($result, $this->request->all())->paginate();
        return $this->response->json($res);
    }

    /**
     * @PostApi  (summary="收货地址创建",security=true)
     * @RequestValidation(rules={
    "real_name|真实姓名":"require",
    "phone|手机号":"require",
    "province|省份":"require",
    "city|城市":"require",
    "district|地区":"require",
    "detail|详细地址":"require",
    "post_code|邮编":"require"
    })
     */
    public function create()
    {
        $data = $this->request->getParsedBody();
        $data['user_id'] = $this->auth->user()->getId();
        //'address_id', '', '', '', 'province', 'city', 'city_id', 'district', 'detail', 'post_code'
        $result = \App\Model\UserAddress::query()->create($data);
        return $this->response->json($result);
    }

    protected function form()
    {
        $model = \App\Model\UserAddress::query()->where('user_id', $this->auth->user()->getId());
        return new Form($model);
    }
}

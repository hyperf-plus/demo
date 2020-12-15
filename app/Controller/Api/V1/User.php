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
use App\Model\Member;
use App\Service\UserService;
use HPlus\Admin\Exception\BusinessException;
use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\Body;
use HPlus\Route\Annotation\GetApi;
use HPlus\Route\Annotation\PostApi;
use HPlus\Route\Annotation\Query;
use HPlus\Validate\Annotations\RequestValidation;
use http\Exception;
use Hyperf\Di\Annotation\Inject;
use App\Validate\UserValidate;
use Mzh\Helper\DbHelper\GetQueryHelper;

/**
 * @ApiController(tag="用户接口")
 * Class Photo
 * @package App\Controller\Api\V1
 */
class User extends AbstractController
{

    /**
     * @PostApi (summary="test",security=false,description="进入小程序先执行 wx.login 获取code, 然后调用此接口，如果是注册用户，则返回 token 和注册信息，如果不是注册用户则返回临时会员的 token")
     * @RequestValidation(validate=UserValidate::class,scene="code",security=false)
     * @throws \Exception
     */
    public function code_login()
    {
        $data = $this->request->getParsedBody();
        return $this->response->json($data);
    }

}

<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.plus
 * @link     https://www.hyperf.plus
 * @document https://doc.hyperf.plus
 * @contact  4213509@qq.com
 * @license  https://github.com/hyperf-plus/admin/blob/master/LICENSE
 */

use App\Controller\Admin\AuthController;
use App\Controller\Admin\Merchant;
use App\Controller\Admin\Order;
use App\Controller\Admin\Photo;

return [
    // enable false 将不会生成 swagger 文件
    'enable' => env('APP_ENV') !== 'prod',
    // swagger 配置的输出文件
    // 当你有多个 http server 时, 可以在输出文件的名称中增加 {server} 字面变量
    // 比如 /public/swagger/swagger_{server}.json
    'output_file' => BASE_PATH . '/runtime/swagger.json',
    // 忽略的hook, 非必须 用于忽略符合条件的接口, 将不会输出到上定义的文件中
    'ignore' => function ($controller, $action) {
        if (
            $controller == 'HPlus\Admin\Controller\Menu' ||
            $controller == 'HPlus\Admin\Controller\Logs' ||
            $controller == 'HPlus\Admin\Controller\Users' ||
            $controller == 'HPlus\Admin\Controller\Permissions' ||
            $controller == 'HPlus\Admin\Controller\Menu' ||
            $controller == 'App\Controller\Admin\User' ||
            $controller == AuthController::class ||
            $controller == Order::class ||
            $controller == Merchant::class ||
            $controller == Photo::class ||
            $controller == 'HPlus\Admin\Controller\Roles'
        ) {
            return true;
        }
        return false;
    },
    // 自定义验证器错误码、错误描述字段
    'error_code' => 400,
    'http_status_code' => 400,
    'field_error_code' => 'code',
    'field_error_message' => 'message',
    // swagger 的基础配置
    'swagger' => [
        'swagger' => '2.0.0',
        'info' => [
            'description' => 'hyperf swagger api desc',
            'version' => '2.0.0',
            'title' => 'HYPERF API DOC',
        ],
        'host' => '', //默认空为当前目录
        'schemes' => ['http'],
        'securityDefinitions' => [
            'token' => [
                'type' => 'apiKey',
                'name' => 'Authorization',
                'in' => 'header',
            ],
        ],
    ],
];

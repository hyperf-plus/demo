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
return [
    // 替换默认的路由分发器工厂
    Hyperf\HttpServer\Router\DispatcherFactory::class => HPlus\Route\DispatcherFactory::class,
];

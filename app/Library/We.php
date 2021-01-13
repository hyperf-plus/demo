<?php
declare(strict_types=1);

namespace App\Library;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Traits\HasHttpRequests;
use EasyWeChat\MiniProgram\Application;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Guzzle\HandlerStackFactory;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\SimpleCache\CacheInterface;

class We
{
    protected $app;

    public function __construct()
    {
        $config = [
            'app_id' => 'wx9dc0d05cde454dfa',
            'secret' => '8f21e25a4c20f00ff472a36d07a91ebd',
            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            'log' => [
                'level' => 'debug',
                'file' => __DIR__ . '/wechat.log',
            ],
        ];
        $app = Factory::miniProgram($config);
        $config = $app['config']->get('http', []);
        $config['use_pool'] = true;
        $container = ApplicationContext::getContainer();
        $config['handler'] = $container->get(HandlerStackFactory::class)->create();
        HasHttpRequests::setDefaultOptions([]);
        $app->rebind('http_client', new Client($config));
        $app->rebind('cache', $container->get(CacheInterface::class));
        $app->rebind('request', $container->get(RequestInterface::class));
        $app['guzzle_handler'] = CoroutineHandler::class;
//        // 设置 OAuth 授权的 Guzzle 配置
//        AbstractProvider::setGuzzleOptions([
//            'http_errors' => false,
//            'handler' => HandlerStack::create(new CoroutineHandler()),
//        ]);
        $this->app = $app;
    }

    public function getMini(): Application
    {
        return $this->app;
    }
}
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
namespace App\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use HPlus\Validate\Exception\ValidateException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));


        // 处理验证异常
        if ($throwable instanceof ValidateException) {
            $data = json_encode([
                'code' => 422,
                'message' => '参数验证失败',
                'error' => $throwable->getMessage()
            ], JSON_UNESCAPED_UNICODE);
            
            return $response
                ->withHeader('Server', 'Hyperf')
                ->withHeader('Content-Type', 'application/json; charset=utf-8')
                ->withStatus(422)
                ->withBody(new SwooleStream($data));
        }

        // 记录其他异常
        $this->logger->error($throwable->getTraceAsString());
        
        $data = json_encode([
            'code' => 500,
            'message' => '服务器内部错误'
        ], JSON_UNESCAPED_UNICODE);
        
        return $response
            ->withHeader('Server', 'Hyperf')
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus(500)
            ->withBody(new SwooleStream($data));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}

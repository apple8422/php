<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace Hyperf\WebSocketServer;

use Hyperf\HttpServer\CoreMiddleware as HttpCoreMiddleware;
use Hyperf\Utils\Context;
use Hyperf\Utils\Contracts\Arrayable;
use Hyperf\WebSocketServer\Exception\WebSocketHandeShakeException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CoreMiddleware extends HttpCoreMiddleware
{
    /**
     * Handle the response when found.
     *
     * @return array|Arrayable|mixed|ResponseInterface|string
     */
    protected function handleFound(array $routes, ServerRequestInterface $request): ResponseInterface
    {
        [$controller,] = $this->prepareHandler($routes[1]);
        if (! $this->container->has($controller)) {
            throw new WebSocketHandeShakeException('Router not exist.');
        }

        /** @var ResponseInterface $response */
        $response = Context::get(ResponseInterface::class);

        $security = $this->container->get(Security::class);

        $key = $request->getHeaderLine(Security::SEC_WEBSOCKET_KEY);
        $response = $response->withStatus(101)->withHeaders($security->handshakeHeaders($key));
        if ($wsProtocol = $request->getHeaderLine(Security::SEC_WEBSOCKET_PROTOCOL)) {
            $response = $response->withHeader(Security::SEC_WEBSOCKET_PROTOCOL, $wsProtocol);
        }

        return $response->withAttribute('class', $controller);
    }
}

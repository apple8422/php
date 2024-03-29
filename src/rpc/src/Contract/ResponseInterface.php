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

namespace Hyperf\Rpc\Contract;

interface ResponseInterface extends \Psr\Http\Message\ResponseInterface
{
    public function getError(): array;

    public function setError(int $code, string $message, $data = null);

    public function getRequestId(): string;

    public function setRequestId(string $requestId);
}

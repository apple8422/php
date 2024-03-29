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

namespace Hyperf\Utils\Coroutine;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Coroutine;
use Swoole\Coroutine\Channel;

/**
 * @method bool isFull()
 * @method bool isEmpty()
 * @method array stats()
 * @method int length()
 */
class Concurrent
{
    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var float
     */
    protected $timeout;

    /**
     * @var int
     */
    protected $limit;

    public function __construct(int $limit, float $timeout = 10.0)
    {
        $this->limit = $limit;
        $this->channel = new Channel($limit);
        $this->timeout = $timeout;
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, ['isFull', 'isEmpty', 'length', 'stats'])) {
            return $this->channel->{$name}(...$arguments);
        }
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getLength(): int
    {
        return $this->channel->length();
    }

    public function getRunningCoroutineCount(): int
    {
        return $this->getLength();
    }

    public function getTimeout(): float
    {
        return $this->timeout;
    }

    public function create(callable $callable): void
    {
        while (true) {
            if ($this->channel->push(true, $this->getTimeout())) {
                break;
            }
        }

        Coroutine::create(function () use ($callable) {
            try {
                $callable();
            } catch (\Throwable $exception) {
                if (ApplicationContext::hasContainer()) {
                    $container = ApplicationContext::getContainer();
                    if ($container->has(StdoutLoggerInterface::class) && $container->has(FormatterInterface::class)) {
                        $logger = $container->get(StdoutLoggerInterface::class);
                        $formatter = $container->get(FormatterInterface::class);
                        $logger->error($formatter->format($exception));
                    }
                }
            } finally {
                $this->channel->pop($this->getTimeout());
            }
        });
    }
}

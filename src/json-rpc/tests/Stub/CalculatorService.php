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

namespace HyperfTest\JsonRpc\Stub;

class CalculatorService implements CalculatorServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function add(int $a, int $b)
    {
        return $a + $b;
    }

    /**
     * {@inheritdoc}
     */
    public function sum(IntegerValue $a, IntegerValue $b): IntegerValue
    {
        return IntegerValue::newInstance($a->getValue() + $b->getValue());
    }

    public function divide($value, $divider)
    {
        if ($divider == 0) {
            throw new \InvalidArgumentException('Expected non-zero value of divider');
        }
        return $value / $divider;
    }
}

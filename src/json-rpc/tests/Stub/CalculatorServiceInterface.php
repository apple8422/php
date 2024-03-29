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

interface CalculatorServiceInterface
{
    public function add(int $a, int $b);

    public function sum(IntegerValue $a, IntegerValue $b): IntegerValue;

    public function divide($value, $divider);
}

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

namespace HyperfTest\Di\Stub;

class AnnotationCollector extends \Hyperf\Di\Annotation\AnnotationCollector
{
    public static function clear()
    {
        self::$container = [];
    }
}

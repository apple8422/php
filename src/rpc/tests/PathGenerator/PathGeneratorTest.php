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

namespace HyperfTest\Rpc\PathGenerator;

use Hyperf\JsonRpc\PathGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class PathGeneratorTest extends TestCase
{
    public function testGenerateFromClassName()
    {
        $pathGenerator = new PathGenerator();
        $this->assertEquals('/user/query', $pathGenerator->generate('Foo\\UserService', 'query'));
    }

    public function testGenerateFromName()
    {
        $pathGenerator = new PathGenerator();
        $this->assertEquals('/user/query', $pathGenerator->generate('user', 'query'));
    }
}

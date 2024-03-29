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

namespace Hyperf\View\Engine;

use Smarty;

class SmartyEngine implements EngineInterface
{
    public function render($template, $data, $config): string
    {
        $engine = new Smarty();
        $engine->setTemplateDir($config['view_path']);
        $engine->setCacheDir($config['cache_path']);
        $engine->setCompileDir($config['cache_path']);

        foreach ($data as $key => $item) {
            $engine->assign($key, $item);
        }

        return $engine->fetch($template);
    }
}

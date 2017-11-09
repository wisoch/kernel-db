<?php

namespace Kernel\Db\Adapter\Profiler;

use Zend\Db\Adapter\Exception;
use Zend\Db\Adapter\StatementContainerInterface;
use Zend\Db\Adapter\Profiler\Profiler as ZendProfiler;
use Zend\Log;

class Profiler extends ZendProfiler
{
    use Log\LoggerAwareTrait;

    public function profilerFinish()
    {
        parent::profilerFinish();

        $current = end($this->profiles);
        $parameters = [];
        if ($current['parameters']) {
            $parameters = $current['parameters']->getNamedArray();
        }

        $parameters = json_encode([], JSON_UNESCAPED_UNICODE);
        $this->getLogger()->info("{$current['sql']}, parameters: {$parameters}, elapse: {$current['elapse']}");

        return $this;
    }
}

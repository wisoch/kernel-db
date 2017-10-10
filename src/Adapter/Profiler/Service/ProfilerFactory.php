<?php

namespace Kernel\Db\Adapter\Profiler\Service;

use Interop\Container\ContainerInterface;
use Kernel\Db\Adapter\Profiler\Profiler;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Log\Logger;

class ProfilerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, array $options = null)
    {
    	$profile = new Profiler();
    	$profile->setLogger($container->get('Kernel\Log\Logger'));

        return $profile;
    }
}

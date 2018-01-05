<?php

namespace Kernel\Db\Adapter;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAbstractServiceFactory as ZendAdapterAbstractServiceFactory;

/**
 * Database adapter abstract service factory.
 *
 * Allows configuring several database instances (such as writer and reader).
 */
class AdapterAbstractServiceFactory extends ZendAdapterAbstractServiceFactory
{
    /**
     * Create a DB adapter
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  array $options
     * @return Adapter
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config   = $this->getConfig($container);
        $adapter  = new Adapter($config[$requestedName]);
        $profiler = $container->get("Kernel\Db\Adapter\Profiler\Profiler");
        
        return $adapter->setProfiler($profiler);
    }

    /**
     * Get db configuration, if any
     *
     * @param  ContainerInterface $container
     * @return array
     */
    protected function getConfig(ContainerInterface $container)
    {
        if ($this->config !== null) {
            return $this->config;
        }

        if (! $container->has('config')) {
            $this->config = [];
            return $this->config;
        }

        $config = $container->get('config');
        if (! isset($config['db'])
            || ! is_array($config['db'])
        ) {
            $this->config = [];
            return $this->config;
        }

        $config = $config['db'];
        if (! isset($config['adapters'])
            || ! is_array($config['adapters'])
        ) {
            $this->config = [];
            return $this->config;
        }

        $this->config = $config['adapters'];
        return $this->config;
    }
}

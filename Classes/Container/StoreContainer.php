<?php

namespace DMK\MKSamlAuth\Container;

use DMK\MKSamlAuth\Store\IdStore;
use DMK\MKSamlAuth\Store\RequestStateStore;
use DMK\MKSamlAuth\Store\SessionSsoStateStore;
use LightSaml\Build\Container\StoreContainerInterface;
use TYPO3\CMS\Core\SingletonInterface;

class StoreContainer implements StoreContainerInterface, SingletonInterface
{
    /**
     * @var SingletonContainer
     */
    private $container;

    public function __construct(SingletonContainer $container)
    {
        $this->container = $container;
    }

    public function getRequestStateStore()
    {
        return $this->container->getInstance(RequestStateStore::class);
    }

    public function getIdStateStore()
    {
        return $this->container->getInstance(IdStore::class);
    }

    public function getSsoStateStore()
    {
        return $this->container->getInstance(SessionSsoStateStore::class);
    }
}

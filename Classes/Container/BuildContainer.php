<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Container;

use LightSaml\Build\Container\BuildContainerInterface;
use TYPO3\CMS\Core\SingletonInterface;

class BuildContainer implements BuildContainerInterface, SingletonInterface
{
    /**
     * @var SingletonContainer
     */
    private $container;

    public function __construct(SingletonContainer $container)
    {
        $this->container = $container;
    }

    public function getSystemContainer()
    {
        return $this->container->getInstance(SystemContainer::class);
    }

    public function getPartyContainer()
    {
        return $this->container->getInstance(PartyContainer::class);
    }

    public function getStoreContainer()
    {
        return $this->container->getInstance(StoreContainer::class);
    }

    public function getProviderContainer()
    {
        return $this->container->getInstance(ProviderContainer::class);
    }

    public function getCredentialContainer()
    {
        return $this->container->getInstance(CredentialContainer::class);
    }

    public function getServiceContainer()
    {
        return $this->container->getInstance(ServiceContainer::class);
    }

    public function getOwnContainer()
    {
        return $this->container->getInstance(OwnContainer::class);
    }
}

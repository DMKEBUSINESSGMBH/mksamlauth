<?php

namespace DMK\MKSamlAuth\Container;

use DMK\MKSamlAuth\Store\CredentialStore;
use LightSaml\Build\Container\CredentialContainerInterface;
use TYPO3\CMS\Core\SingletonInterface;

class CredentialContainer implements CredentialContainerInterface, SingletonInterface
{
    /**
     * @var SingletonContainer
     */
    private $container;

    public function __construct(SingletonContainer $container)
    {
        $this->container = $container;
    }

    public function getCredentialStore()
    {
        return $this->container->getInstance(CredentialStore::class);
    }
}

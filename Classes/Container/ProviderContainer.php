<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Container;

use LightSaml\Build\Container\ProviderContainerInterface;
use LightSaml\Provider\Attribute\FixedAttributeValueProvider;
use LightSaml\Provider\NameID\FixedNameIdProvider;
use LightSaml\Provider\Session\FixedSessionInfoProvider;
use TYPO3\CMS\Core\SingletonInterface;

class ProviderContainer implements ProviderContainerInterface, SingletonInterface
{
    /**
     * @var SingletonContainer
     */
    private $container;

    public function __construct(SingletonContainer $container)
    {
        $this->container = $container;
    }

    public function getAttributeValueProvider()
    {
        return $this->container->getInstance(FixedAttributeValueProvider::class);
    }

    public function getSessionInfoProvider()
    {
        return $this->container->getInstance(FixedSessionInfoProvider::class);
    }

    public function getNameIdProvider()
    {
        return $this->container->getInstance(FixedNameIdProvider::class);
    }
}

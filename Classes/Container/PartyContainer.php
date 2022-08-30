<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Container;

use DMK\MKSamlAuth\EntityDescriptor\IdpEntityDescriptorStore;
use DMK\MKSamlAuth\EntityDescriptor\SpEntityDescriptorStore;
use LightSaml\Build\Container\PartyContainerInterface;
use LightSaml\Meta\TrustOptions\TrustOptions;
use LightSaml\Store\TrustOptions\FixedTrustOptionsStore;
use TYPO3\CMS\Core\SingletonInterface;

class PartyContainer implements PartyContainerInterface, SingletonInterface
{
    /**
     * @var SingletonContainer
     */
    private $container;

    public function __construct(SingletonContainer $container)
    {
        $this->container = $container;
    }

    public function getIdpEntityDescriptorStore()
    {
        return $this->container->getInstance(IdpEntityDescriptorStore::class);
    }

    public function getSpEntityDescriptorStore()
    {
        return $this->container->getInstance(SpEntityDescriptorStore::class);;
    }

    public function getTrustOptionsStore()
    {
        $trustOptions = new TrustOptions();
        $trustOptions->setSignAuthnRequest(true);
        $trustOptions->setEncryptAuthnRequest(true);

        /** @var FixedTrustOptionsStore $trustStore */
        $trustStore = $this->container->getInstance(FixedTrustOptionsStore::class);
        $trustStore->setTrustOptions($trustOptions);

        return $trustStore;
    }
}

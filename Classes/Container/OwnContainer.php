<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Container;

use DMK\MKSamlAuth\Authentication\SamlAuth;
use DMK\MKSamlAuth\Exception\RuntimeException;
use DMK\MKSamlAuth\Repository\IdentityProviderRepository;
use DMK\MKSamlAuth\Store\CredentialStore;
use DMK\MKSamlAuth\Utility\ConfigurationUtility;
use LightSaml\Build\Container\OwnContainerInterface;
use LightSaml\Builder\EntityDescriptor\SimpleEntityDescriptorBuilder;
use LightSaml\Credential\X509Certificate;
use TYPO3\CMS\Core\SingletonInterface;

class OwnContainer implements OwnContainerInterface, SingletonInterface
{
    /**
     * @var SingletonContainer
     */
    private $container;


    /**
     * @var array
     */
    private $configuration;

    public function __construct(ConfigurationUtility $configurationUtility, SingletonContainer $container)
    {
        $this->container = $container;
        $this->configuration = $configurationUtility->getConfiguration();
    }

    public function getOwnEntityDescriptorProvider()
    {
        if (false === \is_array($this->configuration)) {
            throw new RuntimeException(sprintf('No identity provider could be found!'));
        }

        $certificate = new X509Certificate();
        $certificate->loadPem($this->configuration['spCertificate']);

        return new SimpleEntityDescriptorBuilder(
            $this->configuration['spName'],
            $this->configuration['spName'],
            $this->configuration['idpUrl'],
            $certificate
        );
    }

    public function getOwnCredentials()
    {
        if (false === \is_array($this->configuration)) {
            throw new RuntimeException(sprintf('No identity provider could be found!'));
        }

        /** @var CredentialStore $store */
        $store = $this->container->getInstance(CredentialStore::class);

        return $store->getByEntityId($this->configuration['spName']);
    }
}

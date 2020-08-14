<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Container;

use DMK\MKSamlAuth\Authentication\SamlAuth;
use DMK\MKSamlAuth\Exception\RuntimeException;
use DMK\MKSamlAuth\Repository\IdentityProviderRepository;
use DMK\MKSamlAuth\Store\CredentialStore;
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
     * @var IdentityProviderRepository
     */
    private $repository;

    public function __construct(IdentityProviderRepository $repository, SingletonContainer $container)
    {
        $this->container = $container;
        $this->repository = $repository;
    }

    public function getOwnEntityDescriptorProvider()
    {
        $rootPage = SamlAuth::getRootPageIdFromRequest();
        $record = $this->repository->findByRootPage($rootPage);

        if (false === \is_array($record)) {
            throw new RuntimeException(sprintf('No identity provider could be found for root page with id "%s".', $rootPage));
        }

        $certificate = new X509Certificate();
        $certificate->loadPem($record['certificate']);

        return new SimpleEntityDescriptorBuilder(
            $record['name'],
            $record['name'],
            $record['url'],
            $certificate
        );
    }

    public function getOwnCredentials()
    {
        $rootPage = SamlAuth::getRootPageIdFromRequest();
        $record = $this->repository->findByRootPage($rootPage);

        if (false === \is_array($record)) {
            throw new RuntimeException(sprintf('No identity provider could be found for root page with id "%s".', $rootPage));
        }

        /** @var CredentialStore $store */
        $store = $this->container->getInstance(CredentialStore::class);

        return $store->getByEntityId($record['name']);
    }
}

<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Container;

use DMK\MKSamlAuth\Repository\IdentityProviderRepository;
use DMK\MKSamlAuth\Store\CredentialStore;
use LightSaml\Build\Container\OwnContainerInterface;
use LightSaml\Builder\EntityDescriptor\SimpleEntityDescriptorBuilder;
use LightSaml\Credential\CredentialInterface;
use LightSaml\Credential\KeyHelper;
use LightSaml\Credential\X509Certificate;
use LightSaml\Provider\EntityDescriptor\EntityDescriptorProviderInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
        $record = $this->repository->findByHostname(GeneralUtility::getIndpEnv('HTTP_HOST'));

        if (false === is_array($record)) {
            return null;
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
        $record = $this->repository->findByHostname(GeneralUtility::getIndpEnv('HTTP_HOST'));

        if (false === is_array($record)) {
            return null;
        }

        /** @var CredentialStore $store */
        $store = $this->container->getInstance(CredentialStore::class);

        return $store->getByEntityId($record['name']);
    }
}

<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Container;

use DMK\MKSamlAuth\Store\CredentialStore;
use DMK\MKSamlAuth\Store\SessionSsoStateStore;
use LightSaml\Binding\BindingFactory;
use LightSaml\Build\Container\ServiceContainerInterface;
use LightSaml\Provider\TimeProvider\SystemTimeProvider;
use LightSaml\Resolver\Credential\Factory\CredentialResolverFactory;
use LightSaml\Resolver\Endpoint\BindingEndpointResolver;
use LightSaml\Resolver\Endpoint\CompositeEndpointResolver;
use LightSaml\Resolver\Endpoint\DescriptorTypeEndpointResolver;
use LightSaml\Resolver\Endpoint\IndexEndpointResolver;
use LightSaml\Resolver\Endpoint\LocationEndpointResolver;
use LightSaml\Resolver\Endpoint\ServiceTypeEndpointResolver;
use LightSaml\Resolver\Session\SessionProcessor;
use LightSaml\Resolver\Signature\OwnSignatureResolver;
use LightSaml\State\Sso\SsoSessionState;
use LightSaml\Store\Sso\SsoStateSessionStore;
use LightSaml\Validator\Model\Assertion\AssertionTimeValidator;
use LightSaml\Validator\Model\Assertion\AssertionValidator;
use LightSaml\Validator\Model\NameId\NameIdValidator;
use LightSaml\Validator\Model\Signature\SignatureValidator;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\Container\Container;

class ServiceContainer implements ServiceContainerInterface, SingletonInterface
{
    private $container;

    public function __construct(SingletonContainer $container)
    {
        $this->container = $container;
    }

    public function getAssertionValidator()
    {
        return $this->container->getInstance(AssertionValidator::class);
    }

    public function getAssertionTimeValidator()
    {
        return $this->container->getInstance(AssertionTimeValidator::class);
    }

    public function getSignatureResolver()
    {
        return $this->container->getInstance(OwnSignatureResolver::class, [
            $this->getCredentialResolver()
        ]);
    }

    public function getEndpointResolver()
    {
        return $this->container->getInstance(CompositeEndpointResolver::class, [[
            $this->container->getInstance(BindingEndpointResolver::class),
            $this->container->getInstance(DescriptorTypeEndpointResolver::class),
            $this->container->getInstance(ServiceTypeEndpointResolver::class),
            $this->container->getInstance(IndexEndpointResolver::class),
            $this->container->getInstance(LocationEndpointResolver::class)
        ]]);
    }

    public function getNameIdValidator()
    {
        return $this->container->getInstance(NameIdValidator::class);
    }

    public function getBindingFactory()
    {
        return $this->container->getInstance(BindingFactory::class);
    }

    public function getSignatureValidator()
    {
        return $this->container->getInstance(SignatureValidator::class, [
            $this->getCredentialResolver()
        ]);
    }

    public function getCredentialResolver()
    {
        /** @var CredentialResolverFactory $factory */
        $factory = $this->container->getInstance(CredentialResolverFactory::class, [
            $this->container->getInstance(CredentialStore::class)
        ]);

        return $factory->build();
    }

    public function getLogoutSessionResolver()
    {
        throw new \LogicException('Not implemented');
    }

    public function getSessionProcessor()
    {
        return $this->container->getInstance(SessionProcessor::class, [
            $this->container->getInstance(SessionSsoStateStore::class),
            $this->container->getInstance(SystemTimeProvider::class)
        ]);
    }
}

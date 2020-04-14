<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Container;

use DMK\MKSamlAuth\Session\PhpSession;
use LightSaml\Build\Container\SystemContainerInterface;
use LightSaml\Provider\TimeProvider\SystemTimeProvider;
use LightSaml\Provider\TimeProvider\TimeProviderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SystemContainer implements SystemContainerInterface, SingletonInterface
{
    /**
     * @var SingletonContainer
     */
    private $container;

    public function __construct(SingletonContainer $container)
    {
        $this->container = $container;
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    public function getSession(): Session
    {
        static $session;

        if ($session) {
            return $session;
        }

        return $session = new Session(
            $this->container->getInstance(PhpSession::class)
        );
    }

    public function getTimeProvider(): TimeProviderInterface
    {
        return $this->container->getInstance(SystemTimeProvider::class);
    }

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->container->getInstance(EventDispatcherInterface::class);
    }

    public function getLogger(): LoggerInterface
    {
        return GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }
}

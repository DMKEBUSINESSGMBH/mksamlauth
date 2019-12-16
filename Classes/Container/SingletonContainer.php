<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Container;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Object\Container\Container;

class SingletonContainer implements SingletonInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var []
     */
    private $instances;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->instances = [];
    }

    public function getInstance(string $className, array $givenConstructorArguments = [])
    {
        if (isset($this->instances[$className])) {
            return $this->instances[$className];
        }

        return $this->instances[$className] = $this->container->getInstance($className, $givenConstructorArguments);
    }
}

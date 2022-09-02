<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth;

use DMK\MKSamlAuth\Enricher\EnricherInterface;
use DMK\MKSamlAuth\Model\FrontendUser;
use function is_a;
use function ksort;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class EnricherRegistry implements EnricherInterface
{
    private static $objects = [];

    public static function register($className, $priority = 0)
    {
        if (!is_a($className, EnricherInterface::class, true)) {
            throw new \LogicException(sprintf('The class "%s" does not implements "%s".', $className, EnricherInterface::class));
        }

        if (!\array_key_exists($priority, self::$objects)) {
            self::$objects[$priority] = [];
        }

        self::$objects[$priority][$className] = $className;
    }

    public static function unregister($className, $priority = 0)
    {
        if (self::$objects[$priority][$className] ?? false) {
            unset(self::$objects[$priority][$className]);
        }
    }

    public function process(FrontendUser $user, array $context)
    {
        foreach ($this->flatten(self::$objects) as $className) {
            GeneralUtility::makeInstance($className)->process($context);
        }
    }

    private function flatten($list)
    {
        ksort($list);

        foreach ($list as $_ => $objects) {
            yield from $objects;
        }
    }
}

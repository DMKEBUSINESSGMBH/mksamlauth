<?php

namespace DMK\MKSamlAuth\Utility;

use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Site\Entity\Site;

class ConfigurationUtility
{
    public const CONFIGURATION_NAMESPACE = 'mksamlauthConfig';
    public const REQUIRED_FIELDS = [
        'spName',
        'spCertificate',
        'idpEntityId',
        'idpCertificate',
    ];

    public static function isConfigurationComplete(array $configuration): bool
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($configuration[$field])) {
                return false;
            }
        }

        return true;
    }


    public function getConfiguration(bool $includeDisabled = false): ?array
    {
        $configuration = null;
        /** @var ServerRequest $typo3Request */
        $typo3Request = $GLOBALS['TYPO3_REQUEST'];
        if ($typo3Request) {
            /** @var Site $site */
            $site = $typo3Request->getAttribute('site');
            $fullConfig = $site->getConfiguration();
            $configuration = [];
            foreach ($fullConfig as $key => $value) {
                if (false !== strpos($key, self::CONFIGURATION_NAMESPACE)) {
                    $configuration[lcfirst(str_replace(self::CONFIGURATION_NAMESPACE, '', $key))] = $value;
                }
            }

            $isComplete = self::isConfigurationComplete($configuration);
            if (!$isComplete) {
                return null;
            }

            if (!$includeDisabled && !$configuration['enabled']) {
                return null;
            }
        }

        return $configuration;
    }
}

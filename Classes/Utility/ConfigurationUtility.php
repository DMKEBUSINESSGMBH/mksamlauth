<?php

namespace DMK\MKSamlAuth\Utility;

use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ConfigurationUtility
{
    public const CONFIGURATION_NAMESPACE = 'mksamlauthConfig';
    public const REQUIRED_FIELDS = [
        'spName',
        'spCertificate',
        'idpEntityId',
        'idpCertificate',
    ];

    /**
     * @var SiteFinder
     */
    private $siteFinder;

    public static function isConfigurationComplete(array $configuration): bool
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($configuration[$field])) {
                return false;
            }
        }

        return true;
    }

    public function __construct()
    {
        $this->siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
    }

    public function getConfiguration(bool $includeDisabled = false): ?array
    {
        $configuration = null;
        /** @var ServerRequest $typo3Request */
        $typo3Request = $GLOBALS['TYPO3_REQUEST'];
        if ($typo3Request) {
            /** @var Site $site */
            $site = $typo3Request->getAttribute('site');
            $configuration = $this->getConfigurationFromSite($site, $includeDisabled);
        }

        return $configuration;
    }

    public function getAllConfigurations(): array
    {
        $sites = $this->siteFinder->getAllSites();
        $configurations = [];
        foreach ($sites as $site) {
            $configuration = $this->getConfigurationFromSite($site, true);
            if ($configuration) {
                $configurations[$site->getRootPageId()] = $configuration;
            }
        }

        return $configurations;
    }

    public function getSpNamesForTCA(&$params): void
    {
        $configurations = $this->getAllConfigurations();
        foreach ($configurations as $rootPageId => $configuration) {
            $params['items'][] = [$configuration['spName'], $rootPageId];
        }
    }

    private function getConfigurationFromSite(Site $site, bool $includeDisabled = false): ?array
    {
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
        $configuration['rootPageId'] = $site->getRootPageId();

        return $configuration;
    }
}

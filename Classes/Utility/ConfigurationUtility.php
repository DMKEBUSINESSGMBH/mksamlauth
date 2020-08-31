<?php

namespace DMK\MKSamlAuth\Utility;

use TYPO3\CMS\Core\Http\ServerRequestFactory;
use TYPO3\CMS\Core\Routing\SiteMatcher;
use TYPO3\CMS\Core\Routing\SiteRouteResult;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;
use TYPO3\CMS\Core\Site\SiteFinder;

class ConfigurationUtility implements SingletonInterface
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

    /**
     * @var SiteMatcher
     */
    private $siteMatcher;

    public static function isConfigurationComplete(array $configuration): bool
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($configuration[$field])) {
                return false;
            }
        }

        return true;
    }

    public function __construct(SiteFinder $siteFinder, SiteMatcher $siteMatcher)
    {
        $this->siteMatcher = $siteMatcher;
        $this->siteFinder = $siteFinder;
    }

    public function getConfiguration(bool $includeDisabled = false): ?array
    {
        $configuration = null;
        /** @var Site $site */
        $site = $this->getCurrentSite();
        if ($site) {
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

    private function getConfigurationFromSite(SiteInterface $site, bool $includeDisabled = false): ?array
    {
        if (!$site instanceof Site) {
            return null;
        }

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

    private function getCurrentSite(): ?SiteInterface
    {
        $request = $GLOBALS['TYPO3_REQUEST'] ?? ServerRequestFactory::fromGlobals();
        /** @var SiteRouteResult $routeResult */
        $routeResult = $this->siteMatcher->matchRequest($request);
        return $routeResult->getSite();
    }
}

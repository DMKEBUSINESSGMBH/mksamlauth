<?php
/**
 * Ext_localconf
 *
 * @category TYPO3-Extension
 * @package  DMK\SamlAuth
 * @author   Eric Hertwig <dev@dmk-ebusiness.de>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.dmk-ebusiness.de/
 */

use DMK\MKSamlAuth\Authentication\SamlAuth;
use DMK\MKSamlAuth\EnricherRegistry;
use DMK\MKSamlAuth\Enricher;
use DMK\MKSamlAuth\Store\IdStore;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
(static function ($_EXTKEY) {
    ExtensionManagementUtility::addService(
        $_EXTKEY,
        'auth',
        SamlAuth::class,
        [
            'title' => 'Saml-Auth FE-User',
            'description' => 'Authenticates FE-Users/groups via Saml',
            'subtype' => 'authUserFE,getUserFE',
            'available' => true,
            'priority' => 70,
            'quality' => 70,
            'os' => '',
            'exec' => '',
            'className' => SamlAuth::class,
        ]
    );

    EnricherRegistry::register(Enricher\DummyPasswordEnricher::class, 100);
    EnricherRegistry::register(Enricher\SamlHostnameEnricher::class, 100);
    EnricherRegistry::register(Enricher\SimpleAttributeEnricher::class);
    EnricherRegistry::register(Enricher\SSOGroupEnricher::class, 10);
    EnricherRegistry::register(Enricher\DefaultGroupEnricher::class);

    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_alwaysFetchUser'] = true;

    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][IdStore::CACHE_KEY])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][IdStore::CACHE_KEY] = [];
    }
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][IdStore::CACHE_KEY]['backend'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][IdStore::CACHE_KEY]['backend'] = \TYPO3\CMS\Core\Cache\Backend\FileBackend::class;
    }

})('mksamlauth');

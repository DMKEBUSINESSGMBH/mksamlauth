<?php
/**
 * Ext_tables
 *
 * @category TYPO3-Extension
 * @package  DMK\SamlAuth
 * @author   Eric Hertwig <dev@dmk-ebusiness.de>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.dmk-ebusiness.de/
 */
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}


(static function ($_EXTKEY) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript',
        'MK Saml Auth');
})('mksamlauth');

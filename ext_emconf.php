<?php
/**
 * Extension Manager/Repository config file for ext "t3twig".
 *
 * @category TYPO3-Extension
 * @package  DMK\SamlAuth
 * @author   Eric Hertwig <dev@dmk-ebusiness.de>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.dmk-ebusiness.de/
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'MKSamlAuth',
    'description' => 'Auth for SAML IDP',
    'shy' => 0,
    'version' => '8.7.3',
    'dependencies' => 'cms',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'stable',
    'uploadfolder' => 0,
    'modify_tables' => '',
    'clearcacheonload' => 0,
    'lockType' => '',
    'category' => 'misc',
    'author' => 'DMK E-BUSINESS GmbH',
    'author_email' => 'dev@dmk-ebusiness.de',
    'author_company' => 'DMK E-BUSINESS GmbH',
    'CGLcompliance' => '',
    'CGLcompliance_note' => '',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
    '_md5_values_when_last_written' => '',
    'suggests' => [],
    'createDirs' => '',
];

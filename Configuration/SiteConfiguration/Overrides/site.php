<?php

declare(strict_types=1);

defined('TYPO3_MODE') || die();

call_user_func(static function ($_EXTKEY): void {
    $columns = [
        'mksamlauthConfigIdpUrl' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_url',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'mksamlauthConfigEnabled' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_enabled',
            'config' => [
                'type' => 'check',
            ],
        ],
        'mksamlauthConfigUserFolder' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_user_folder',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'pages',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
                'default' => 0,
            ],
        ],
        'mksamlauthConfigIdpCertificate' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_certificate',
            'config' => [
                'type' => 'text',
                'eval' => 'required',
            ],
        ],
        'mksamlauthConfigIdpEntityId' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_idp_entity_id',
            'config' => [
                'type' => 'input',
                'eval' => 'required',
            ],
        ],
        'mksamlauthConfigSpName' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_name',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required',
            ],
        ],
        'mksamlauthConfigSpCertificate' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_idp_certificate',
            'config' => [
                'type' => 'text',
                'eval' => 'required',
            ],
        ],
        'mksamlauthConfigSpCertKey' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_key',
            'config' => [
                'type' => 'text',
            ],
        ],
        'mksamlauthConfigSpPassphrase' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_passphrase',
            'config' => [
                'type' => 'input',
                'eval' => 'password,trim',
            ],
        ],
        'mksamlauthConfigDefaultGroupsEnable' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.default_groups_enable',
            'config' => [
                'type' => 'check',
            ],
        ],
        'mksamlauthConfigDefaultGroups' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.default_groups',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'fe_groups',
                'enableMultiSelectFilterTextfield' => true,
            ],
        ],
    ];
    $GLOBALS['SiteConfiguration']['site']['columns'] = array_merge($GLOBALS['SiteConfiguration']['site']['columns'],
        $columns);
    $GLOBALS['SiteConfiguration']['site']['palettes']['mksamlauth_general'] = [
        'showitem' => 'mksamlauthConfigEnabled,mksamlauthConfigUserFolder',
    ];

    $GLOBALS['SiteConfiguration']['site']['palettes']['mksamlauth_sp'] = [
        'showitem' => 'mksamlauthConfigSpName,--linebreak--,mksamlauthConfigSpCertificate,--linebreak--,mksamlauthConfigSpCertKey,--linebreak--,mksamlauthConfigSpPassphrase',
    ];

    $GLOBALS['SiteConfiguration']['site']['palettes']['mksamlauth_idp'] = [
        'showitem' => 'mksamlauthConfigIdpEntityId,--linebreak--,mksamlauthConfigIdpUrl,--linebreak--,mksamlauthConfigIdpCertificate',
    ];

    $GLOBALS['SiteConfiguration']['site']['palettes']['mksamlauth_features'] = [
        'showitem' => 'mksamlauthConfigDefaultGroupsEnable,--linebreak--,mksamlauthConfigDefaultGroups',
    ];

    $GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= ','.implode(', ', [
            '--div--;LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider;',
            '--palette--;LLL:EXT:mksamlauth/Resources/Private/Language/locallang_tabs.xlf:general;mksamlauth_general;',
            '--palette--;LLL:EXT:mksamlauth/Resources/Private/Language/locallang_tabs.xlf:sp;mksamlauth_sp',
            '--palette--;LLL:EXT:mksamlauth/Resources/Private/Language/locallang_tabs.xlf:idp;mksamlauth_idp',
            '--palette--;LLL:EXT:mksamlauth/Resources/Private/Language/locallang_tabs.xlf:features;mksamlauth_features',
        ]);
}, 'mksamlauth');

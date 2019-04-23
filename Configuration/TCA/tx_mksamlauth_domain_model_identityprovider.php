<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider',
        'label' => 'name',
    ],
    'columns' => [
        'name' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_name',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required'
            ]
        ],
        'url' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_url',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ]
        ],
        'domain' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_domain',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_domain',
            ]
        ],
        'user_folder' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_user_folder',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'pages',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
                'default' => 0
            ]
        ],
        'certificate' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_certificate',
            'config' => [
                'type' => 'text',
                'eval' => 'required'
            ]
        ],
        'cert_key' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_key',
            'config' => [
                'type' => 'text',
                'eval' => 'required'
            ]
        ],
        'passphrase' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_passphrase',
            'config' => [
                'type' => 'input',
                'eval' => 'password,trim'
            ]
        ],
        'default_groups_enable' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.default_groups_enable',
            'config' => [
                'type' => 'check',
            ]
        ],
        'default_groups' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.default_groups',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'fe_groups',
                'enableMultiSelectFilterTextfield' => true,
            ]
        ]
    ],
    'types' => [
        '0' => ['showitem' => 'name, url, certificate, cert_key, passphrase, domain, user_folder, default_groups_enable, default_groups'],
        '1' => ['showitem' => 'default_groups_enable, default_groups']
    ]
];

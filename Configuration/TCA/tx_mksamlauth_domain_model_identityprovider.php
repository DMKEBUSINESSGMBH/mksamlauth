<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider',
        'label' => 'name',
        'iconfile' => 'EXT:mksamlauth/Resources/Public/Icons/Extension.png',
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
        'root_page' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_root_page',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'pages',
                'eval' => 'required',
                'foreign_table_where' => ' AND {#pages}.{#sys_language_uid}=0 AND {#pages}.{#is_siteroot}=1 ORDER BY sorting'
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
        'idp_entity_id' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_idp_entity_id',
            'config' => [
                'type' => 'input',
                'eval' => 'required'
            ]
        ],
        'idp_certificate' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_idp_certificate',
            'config' => [
                'type' => 'text',
                'eval' => 'required'
            ]
        ],
        'cert_key' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider.item_key',
            'config' => [
                'type' => 'text',
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
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:mksamlauth/Resources/Private/Language/locallang_tabs.xlf:general,
                    root_page,user_folder,
                --div--;LLL:EXT:mksamlauth/Resources/Private/Language/locallang_tabs.xlf:sp,
                    name,certificate,cert_key,passphrase,
                --div--;LLL:EXT:mksamlauth/Resources/Private/Language/locallang_tabs.xlf:idp,
                    idp_entity_id,url,idp_certificate,
                --div--;LLL:EXT:mksamlauth/Resources/Private/Language/locallang_tabs.xlf:features,
                    default_groups_enable,default_groups
            '],
    ]
];

<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_group_mapping',
        'label' => 'idp_name',
    ],
    'columns' => [
        'idp_name' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_group_mapping.idp_name',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required'
            ]
        ],
        'idp_id' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_identityprovider',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_mksamlauth_domain_model_identityprovider',
            ]
        ],
        'group_ids' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksaml_auth.domain_model_group_mapping.group_ids',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'fe_groups',
                'enableMultiSelectFilterTextfield' => true,
            ]
        ]
    ],
    'types' => [
        '0' => ['showitem' => 'idp_name, idp_id, group_ids'],
    ]
];

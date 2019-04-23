<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_serviceprovider',
        'label' => 'name',
    ],
    'columns' => [
        'name' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_serviceprovider.item_name',
            'config' => [
                'type' => 'input',
                'eval' =>  'trim'
            ]
        ],
        'domain' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_serviceprovider.item_domain',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_domain',
            ]
        ],
        'certificate' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_serviceprovider.item_certificate',
            'config' => [
                'type' => 'text'
            ]
        ],
        'cert_key' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_serviceprovider.item_key',
            'config' => [
                'type' => 'text'
            ],
        ],
        'passphrase' => [
            'label' => 'LLL:EXT:mksamlauth/Resources/Private/Language/locallang_db.xlf:tx_mksamlauth_domain_model_serviceprovider.item_passphrase',
            'config' => [
                'type' => 'text',
                'eval' => 'password,trim'
            ]
        ]
    ],
    'types' => [
        '0' => ['showitem' => 'name, url, domain, certificate, cert_key, passphrase']
    ]
];

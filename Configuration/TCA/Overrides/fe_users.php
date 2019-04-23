<?php
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'fe_users',
    [
        'mksamlauth_host' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:t3users/locallang_db.xml:fe_users_t3usersroles',
            'config' => [
                'type' => 'none',
                'readOnly' => true,
            ]
        ],
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'mksamlauth_host');

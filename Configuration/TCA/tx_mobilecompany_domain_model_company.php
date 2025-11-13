<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'name,country,website,description',
        'iconfile' => 'EXT:mobile_company/Resources/Public/Icons/tx_mobilecompany_domain_model_company.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'name, country, founded_year, website, description, mobiles, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_mobilecompany_domain_model_company',
                'foreign_table_where' => 'AND {#tx_mobilecompany_domain_model_company}.{#pid}=###CURRENT_PID### AND {#tx_mobilecompany_domain_model_company}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.name',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.name.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'country' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.country',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.country.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'founded_year' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.founded_year',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.founded_year.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0
            ]
        ],
        'website' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.website',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.website.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'description' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.description',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.description.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'mobiles' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.mobiles',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_company.mobiles.description',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_mobilecompany_domain_model_mobile',
                'foreign_field' => 'company',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
    
    ],
];

<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile',
        'label' => 'model_name',
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
        'searchFields' => 'model_name,brand,specifications',
        'iconfile' => 'EXT:mobile_company/Resources/Public/Icons/tx_mobilecompany_domain_model_mobile.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'model_name, brand, price, release_date, specifications, companies, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
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
                'foreign_table' => 'tx_mobilecompany_domain_model_mobile',
                'foreign_table_where' => 'AND {#tx_mobilecompany_domain_model_mobile}.{#pid}=###CURRENT_PID### AND {#tx_mobilecompany_domain_model_mobile}.{#sys_language_uid} IN (-1,0)',
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

        'model_name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.model_name',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.model_name.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'brand' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.brand',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.brand.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'price' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.price',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.price.description',
            'config' => [
                'type' => 'input',
                'placeholder' => 'prize range 10000 - 100000',
                'size' => 30,
                //'min' => 10000,
                //'max' => 100000,
                'range' => [
                    'lower' => 10000,
                    'upper' => 100000,
                ],
                'eval' => 'double2,required',
            ]
        ],
        'release_date' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.release_date',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.release_date.description',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 30,
                'eval' => 'date',
                'default' => null,
            ],
        ],
        'specifications' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.specifications',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.specifications.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'minimal',
                //'richtextConfiguration' => 'customMinimal',
                //'cols' => 5,
                //'rows' => 2,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'companies' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.companies',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.companies.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_mobilecompany_domain_model_company',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
            
        ],
    
        'company' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];

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
        '1' => ['showitem' => 'model_name, slug, brand, price, image, release_date, specifications, companies, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
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
        'slug' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.slug',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.slug.description',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['model_name'],
                    'fieldSeparator' => '-',
                    'prefixParentPageSlug' => true,
                ], 
                'fallbackCharacter' => '-',
                'eval' => 'uniqueinSite',
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
                'range' => [
                    'lower' => 10000,
                    'upper' => 100000,
                ],
                'eval' => 'double2,required',
            ]
        ],
        'image'=> [
            'exclude' => true,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.image',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.image.description',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.image.addImage',
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => 'image',
                        'tablenames' => 'tx_mobilecompany_domain_model_mobile',
                        'table_local' => 'sys_file',
                    ],
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'release_date' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.release_date',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.release_date.description',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'format' => 'date',
                'size' => 30,
                'eval' => 'date',
                'default' => '0000-00-00',
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
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'companies' => [
            'exclude' => false,
            'label' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.companies',
            'description' => 'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobilecompany_domain_model_mobile.companies.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_mobilecompany_domain_model_company',
                'default'=>0,
                'minitems' => 0,
                'maxitems' => 1,
                'eval' => 'required',
            ],
        ],
    
        'company' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];

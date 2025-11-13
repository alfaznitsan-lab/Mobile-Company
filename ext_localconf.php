<?php

defined('TYPO3') or die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'MobileCompany',
        'Mobilecompanyplugin',
        [
            \Nitsan\MobileCompany\Controller\MobileController::class => 'list, show, new, create, edit, update, delete',
            \Nitsan\MobileCompany\Controller\CompanyController::class => 'list, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \Nitsan\MobileCompany\Controller\MobileController::class => 'list, create, update, delete',
            \Nitsan\MobileCompany\Controller\CompanyController::class => 'list, create, update, delete'
        ]
    );

    //List plugin
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'MobileCompany',
        'Mobilecompanylistplugin',
        [
            \Nitsan\MobileCompany\Controller\MobileController::class => 'list, show, new, create, edit, update, delete',
            \Nitsan\MobileCompany\Controller\CompanyController::class => 'list, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \Nitsan\MobileCompany\Controller\MobileController::class => 'create, update, delete',
            \Nitsan\MobileCompany\Controller\CompanyController::class => 'create, update, delete'
        ]
    );

    //detailed plugin
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'MobileCompany',
        'Mobilecompanydetailplugin',
        [
            \Nitsan\MobileCompany\Controller\MobileController::class => 'list, show, new, create, edit, update, delete',
            \Nitsan\MobileCompany\Controller\CompanyController::class => 'list, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \Nitsan\MobileCompany\Controller\MobileController::class => 'create, update, delete',
            \Nitsan\MobileCompany\Controller\CompanyController::class => 'create, update, delete'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    mobilecompanyplugin {
                        iconIdentifier = mobile_company-plugin-mobilecompanyplugin
                        title = LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobile_company_mobilecompanyplugin.name
                        description = LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobile_company_mobilecompanyplugin.description
                        tt_content_defValues {
                            CType = list
                            list_type = mobilecompany_mobilecompanyplugin
                        }
                    }

                    mobilecompanylistplugin {
                        iconIdentifier = mobile_company-plugin-mobilecompanylistplugin
                        title = LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobile_company_mobilecompanylistplugin.name
                        description = LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobile_company_mobilecompanylistplugin.description
                        tt_content_defValues {
                            CType = list
                            list_type = mobilecompany_mobilecompanylistplugin
                        }
                    }

                    mobilecompanydetailplugin {
                        iconIdentifier = mobile_company-plugin-mobilecompanydetailplugin
                        title = LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobile_company_mobilecompanydetailplugin.name
                        description = LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tx_mobile_company_mobilecompanydetailplugin.description
                        tt_content_defValues {
                            CType = list
                            list_type = mobilecompany_mobilecompanydetailplugin
                        }
                    }
                }
                show = *
            }
       }'
    );
}
)();

<?php
defined('TYPO3') || die();

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['mobilecompany_mobilecompanylistplugin'] = 'layout,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['mobilecompany_mobilecompanylistplugin'] = 'pi_flexform';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['mobilecompany_mobilecompanydetailplugin'] = 'layout,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['mobilecompany_mobilecompanydetailplugin'] = 'pi_flexform';
    
// --- Main Plugin ---
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'MobileCompany',
    'Mobilecompanyplugin',
    'Mobile Company Plugin'
);

// --- Mobile List Plugin ---
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'MobileCompany',
    'Mobilecompanylistplugin',
    'Mobile List Plugin'
);

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'mobilecompany_mobilecompanylistplugin',
    'FILE:EXT:mobile_company/Configuration/FlexForms/MobileList.xml'
);

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tt_content.list_type',
        'mobilecompany_mobilecompanylistplugin'
    ],
    'list_type',
    'mobile_company'
 );



// --- Mobile Detail Plugin ---
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'MobileCompany',
    'Mobilecompanydetailplugin', 
    'Mobile Detail Plugin'
);

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'mobilecompany_mobilecompanydetailplugin',
    'FILE:EXT:mobile_company/Configuration/FlexForms/MobileDetail.xml'
);

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:mobile_company/Resources/Private/Language/locallang_db.xlf:tt_content.list_type',
        'mobilecompany_mobilecompanydetailplugin'
    ],
    'list_type',
    'mobile_company'
 );

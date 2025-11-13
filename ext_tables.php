<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mobilecompany_domain_model_mobile', 'EXT:mobile_company/Resources/Private/Language/locallang_csh_tx_mobilecompany_domain_model_mobile.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mobilecompany_domain_model_mobile');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mobilecompany_domain_model_company', 'EXT:mobile_company/Resources/Private/Language/locallang_csh_tx_mobilecompany_domain_model_company.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mobilecompany_domain_model_company');

     // Mobile List Plugin
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'MobileCompany',
        'Mobilecompanylistplugin',
        'Mobile List Plugin'
    );

    // Mobile Detail Plugin
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'MobileCompany',
        'Mobilecompanydetailsplugin',
        'Mobile Details Plugin'
    );
})();

<?php
declare(strict_types=1);

namespace Nitsan\MobileCompany\Package\EventListener;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Package\Event\AfterPackageActivationEvent;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Log\SystemLogType;
use TYPO3\CMS\Core\Log\SystemLogGenericAction;
use TYPO3\CMS\Core\Log\SystemLogErrorClassification;

final class MyEventListener
{

    public function __invoke(AfterPackageActivationEvent $event): void
    {
        if ($event->getPackageKey() === 'mobile_company') {
            $logMessage = 'My extension(mobile_company) was successfully activated.';
            
            $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('sys_log');

            if (!$connection->isConnected()) {
                return;
            }
            
            $userId = 0;
            $workspace = 0;
            $data = [];
            $backendUser = $this->getBackendUser();

            if ($backendUser instanceof BackendUserAuthentication) {
                if (isset($backendUser->user['uid'])) {
                    $userId = (int)$backendUser->user['uid'];
                }
                $workspace = (int)$backendUser->workspace;
                if ($backUserId = $backendUser->getOriginalUserIdWhenInSwitchUserMode()) {
                    $data['originalUser'] = (int)$backUserId;
                }
            }

            $connection->insert(
                'sys_log',
                [
                    'tstamp' => $GLOBALS['EXEC_TIME'],
                    'userid' => $userId,
                    'action' => 0,
                    'tablename' => '',
                    'recpid' => 0,
                    'error' => 0,
                    'details' => str_replace('%', '%%', $logMessage),
                    'type' => 1,
                    'channel' => 'info',
                    'details_nr' => 0,
                    'IP' => (string)GeneralUtility::getIndpEnv('REMOTE_ADDR'),
                    'log_data' => empty($data) ? '' : serialize($data),
                    'workspace' => $workspace,
                    'level' => 0,
                ]
            );
        }
    }

    private function getBackendUser(): ?BackendUserAuthentication
    {
        if (isset($GLOBALS['BE_USER']) && $GLOBALS['BE_USER'] instanceof BackendUserAuthentication) {
            return $GLOBALS['BE_USER'];
        }
        return null;
    }
}

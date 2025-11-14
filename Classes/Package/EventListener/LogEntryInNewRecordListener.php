<?php
declare(strict_types=1);

namespace Nitsan\MobileCompany\Package\EventListener;

use Nitsan\MobileCompany\Event\LogEntryOnNewRecord;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SysLog\Action as SystemLogGenericAction;
use TYPO3\CMS\Core\SysLog\Error as SystemLogErrorClassification;
use TYPO3\CMS\Core\SysLog\Type as SystemLogType;

final class LogEntryInNewRecordListener
{
    public function __invoke(LogEntryOnNewRecord $event): void
    {
        $logMessage = $event->getLogMessage();
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
                DebugUtility::debug($userId);
            }
            $workspace = (int)$backendUser->workspace;
            if ($backUserId = $backendUser->getOriginalUserIdWhenInSwitchUserMode()) {
                $data['originalUser'] = (int)$backUserId;
                DebugUtility::debug($data);
            }
        }

        $connection->insert(
            'sys_log',
            [
                'tstamp' => time(),
                'userid' => $userId,
                'action' => SystemLogGenericAction::UNDEFINED,
                'error' => SystemLogErrorClassification::SYSTEM_ERROR,
                'details' => str_replace('%', '%%', $logMessage),
                'type' => SystemLogType::ERROR,
                'channel' => SystemLogType::toChannel(SystemLogType::ERROR),
                'details_nr' => 0,
                'IP' => (string)GeneralUtility::getIndpEnv('REMOTE_ADDR'),
                'log_data' => empty($data) ? '' : serialize($data),
                'workspace' => $workspace,
                'level' => SystemLogType::toLevel(SystemLogType::ERROR),
            ]
        );
    }

    private function getBackendUser(): ?BackendUserAuthentication{
        if (isset($GLOBALS['BE_USER']) && $GLOBALS['BE_USER'] instanceof BackendUserAuthentication) {
            return $GLOBALS['BE_USER'];
        }
        return null;
    }
}

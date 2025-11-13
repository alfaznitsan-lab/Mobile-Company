<?php

declare(strict_types=1);

namespace Nitsan\MobileCompany\Domain\Repository;


use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface; 

/**
 * This file is part of the "Mobile Company" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 Nitsan <nit@example.com>, Nitsan
 */

/**
 * The repository for Mobiles
 */
class MobileRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    private const TABLE = 'tx_mobilecompany_domain_model_mobile';
    protected $defaultOrderings = ['crdate' => QueryInterface::ORDER_ASCENDING];

    public function updateSysFileReferenceRecord(int $uid_local, int $uid_foreign, int $pid, string $table, string $field ) : void
    {
        $tableConnectionCategoryMM = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_file_reference');

        $sysFileReferenceData[$uid_local] = [
            'uid_local' => $uid_local,
            'uid_foreign' => $uid_foreign,
            'tablenames' => $table,
            'fieldname' => $field,
            'sorting_foreign' => 1,
            'pid' => $pid,
            'table_local' => 'sys_file'
        ];
        if (!empty($sysFileReferenceData)) {
            $tableConnectionCategoryMM->bulkInsert(
                'sys_file_reference',
                array_values($sysFileReferenceData),
                ['uid_local', 'uid_foreign', 'tablenames', 'fieldname', 'sorting_foreign', 'pid', 'table_local']
            );
        }
    }

    public function findByFilters($name = '', $brand = '', $prize = '', $company = '')
    {
        $query = $this->createQuery();
        $constraints = [];

        if (!empty($name)) {
            $constraints[] = $query->like('model_name', '%' . $name . '%');
        }

        if (!empty($brand)) {
            $constraints[] = $query->like('brand', '%' . $brand . '%');
        }

        if (!empty($prize)) {
            $constraints[] = $query->equals('price', (float)$prize);
        }

        if (!empty($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }

        return $query->execute();
    }

}

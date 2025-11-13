<?php
declare(strict_types=1);

namespace Nitsan\MobileCompany\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'mobilecompany:deleteoldrecords', description: 'Deletes old mobilecompany records.',schedulable: true)]

final class DeleteOldRecordsCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setHelp('This command delete x days record')
            ->addArgument(
                'days', 
                InputArgument::REQUIRED,
                'The number of days.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->info('Start delete record command...');
         $days = (int)$input->getArgument('days');

        $timestamp = (new \DateTime())->modify(sprintf('-%d days', $days))->getTimestamp();
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_mobilecompany_domain_model_mobile');
        $rowsAffected = $queryBuilder->delete('tx_mobilecompany_domain_model_mobile')
            ->where(
                $queryBuilder->expr()->lt(
                    'crdate',
                    $queryBuilder->createNamedParameter($timestamp, Connection::PARAM_INT)
                )
            )->executeStatement();
        $io->writeln(sprintf('Number of affected rows: %d', $rowsAffected));
        $io->writeln(sprintf('Records older than %d days (timestamp %d) were targeted.', $days, $timestamp));

        $io->success('Old records deleted successfully.');

        return Command::SUCCESS;
    }
}
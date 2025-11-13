<?php

declare(strict_types=1);

namespace Nitsan\MobileCompany\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * This file is part of the "Mobile Company" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 Nitsan <nit@example.com>, Nitsan
 */

/**
 * MobileController
 */
class MobileController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \TYPO3\CMS\Extbase\Mvc\View\ViewInterface
     */
    protected $view;

    /**
     * mobileRepository
     *
     * @var \Nitsan\MobileCompany\Domain\Repository\MobileRepository
     */
    protected $mobileRepository = null;

    /** 
     * company repository
     * 
     * @var \Vendor\Extension\Domain\Repository\CompanyRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $companyRepository = null;

    /**
     * Persistence manager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceFactory
     */
    protected $resourceFactory;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * @param \Nitsan\MobileCompany\Domain\Repository\MobileRepository $mobileRepository
     */
    public function injectMobileRepository(\Nitsan\MobileCompany\Domain\Repository\MobileRepository $mobileRepository)
    {
        $this->mobileRepository = $mobileRepository;
    }

    public function injectComapnyRepository(\Nitsan\MobileCompany\Domain\Repository\CompanyRepository $companyRepository) {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Inject persistence manager
     *
     * @param \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface $persistenceManager
     */
    public function injectPersistenceManager(\TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface $persistenceManager)
    {
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {        
        $filterBrand = $this->request->hasArgument('filterBrand') ? $this->request->getArgument('filterBrand') : '';
        $filterName = $this->request->hasArgument('filterName') ? $this->request->getArgument('filterName') : '';
        $filterPrize = $this->request->hasArgument('filterPrize') ? $this->request->getArgument('filterPrize') : '';

        $filteredMobiles = $this->mobileRepository->findByFilters($filterName, $filterBrand, $filterPrize, $filterCompany)->toArray();

        $itemsPerPage = (int)($this->settings['itemsPerPage'] ?? 5);
        $currentPageNumber = $this->request->hasArgument('currentPageNumber')?(int)$this->request->getArgument('currentPageNumber'): 1;

        if ($filteredMobiles) {
            $paginator = new ArrayPaginator($filteredMobiles, $currentPageNumber, $itemsPerPage);    
        }else{
            $filteredMobiles = [];
            $paginator = new ArrayPaginator($filteredMobiles, $currentPageNumber, $itemsPerPage);
        }
        $pagination = new SimplePagination($paginator);

        $this->view->assignMultiple(
            [
                'paginator' => $paginator,
                'pagination' => $pagination,
                'detailPid' => $this->settings['detailPid'] ?? null,
                'filterBrand' => $filterBrand,
                'filterName' => $filterName,
                'filterPrize' => $filterPrize,
            ],
        );
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \Nitsan\MobileCompany\Domain\Model\Mobile $mobile
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\Nitsan\MobileCompany\Domain\Model\Mobile $mobile): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assignmultiple(['mobile' => $mobile, 'listPid' => $this->settings['listPid'] ?? null,]);
        return $this->htmlResponse();
    }

    
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        $companies = $this->companyRepository->findall();
        $this->view->assign('companies', $companies);
        return $this->htmlResponse();
    }
    
    private function getUploadedFileData(string $tmpName, string $fileName): File
    {
        $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
        $storage = $resourceFactory->getDefaultStorage();
        $targetFolderPath = 'user_upload/';
        $folderPath = $storage->getFolder($targetFolderPath);
        //$folderPath = $storage->getRootLevelFolder();
        $newFile = $storage->addFile($tmpName, $folderPath,$fileName);
        return $newFile;
    }

    /**
     * action create
     *
     * @param \Nitsan\MobileCompany\Domain\Model\Mobile $newMobile
     */
    public function createAction(\Nitsan\MobileCompany\Domain\Model\Mobile $newMobile)
    {
        $this->mobileRepository->add($newMobile);

        $record = null;
        $this->persistenceManager->persistAll();

        if ($record) {
            $tableName = 'tx_mobilecompany_domain_model_mobile';
            $slugFieldName = 'slug';

            $fieldConfig = $GLOBALS['TCA'][$tableName]['columns'][$slugFieldName]['config'];
            $slugHelper = GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\SlugHelper::class, $tableName, $slugFieldName, $fieldConfig);

            $slug = $slugHelper->generate($record, $record['pid']);

            $evalInfo = GeneralUtility::trimExplode(',', $fieldConfig['eval'], true);
            if (in_array('uniqueInPid', $evalInfo, true)) {
                $recordState = RecordStateFactory::forName($tableName)->fromArray($record, $record['pid'], $record['uid']);
                $slug = $slugHelper->buildSlugForUniqueInPid($slug, $recordState);
            }

            $newMobile->setSlug($slug);
            $this->mobileRepository->update($newMobile);
        }
        
        // Handle uploaded image
        if($_FILES['tx_mobilecompany_mobilecompanylistplugin']['tmp_name']['image']){
            $newFile = $this->getUploadedFileData($_FILES['tx_mobilecompany_mobilecompanylistplugin']['tmp_name']['image'], $_FILES['tx_mobilecompany_mobilecompanylistplugin']['name']['image']);
            
            $fileData = $newFile->getProperties();
            if ($fileData) {
                $this->mobileRepository->updateSysFileReferenceRecord(
                    (int)$fileData['uid'],
                    (int)$newMobile->getUid(),
                    (int)$newMobile->getPid(),
                    'tx_mobilecompany_domain_model_mobile',
                    'image'
                );
                $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
                $fileObjects = $fileRepository->findByRelation(
                    'tx_mobilecompany_domain_model_mobile',
                    'image',
                    $newMobile->getUid()
                );
            }
        }
        
        $this->mobileRepository->add($newMobile);

        $this->addFlashMessage('The object was created.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->redirect('list');
    }

    /**
     * Initialize property mapping for create action
     */

    protected function initializeCreateAction(): void
    {
        $propertyMappingConfiguration = $this->arguments['newMobile']->getPropertyMappingConfiguration();

        $propertyMappingConfiguration->forProperty('releaseDate')->setTypeConverterOption(
            DateTimeConverter::class,
            DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'Y-m-d'
        );
    }

    /**
     * action edit
     *
     * @param \Nitsan\MobileCompany\Domain\Model\Mobile $mobile
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("mobile")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\Nitsan\MobileCompany\Domain\Model\Mobile $mobile): \Psr\Http\Message\ResponseInterface
    {
        $companies = $this->companyRepository->findall();
        $this->view->assign('companies', $companies);
        $this->view->assign('mobile', $mobile);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \Nitsan\MobileCompany\Domain\Model\Mobile $mobile
     */
    public function updateAction(\Nitsan\MobileCompany\Domain\Model\Mobile $mobile): void
    {
        $this->mobileRepository->update($mobile);

        $this->persistenceManager->persistAll();
        $record = null;
        if ($record) {
            $tableName = 'tx_mobilecompany_domain_model_mobile';
            $slugFieldName = 'slug';
            $fieldConfig = $GLOBALS['TCA'][$tableName]['columns'][$slugFieldName]['config'];
            $slugHelper = GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\SlugHelper::class, $tableName, $slugFieldName, $fieldConfig);
            $slug = $slugHelper->generate($record, $record['pid']);
            $evalInfo = GeneralUtility::trimExplode(',', $fieldConfig['eval'], true);
            if (in_array('uniqueInPid', $evalInfo, true)) {
                $recordState = RecordStateFactory::forName($tableName)->fromArray($record, $record['pid'], $record['uid']);
                $slug = $slugHelper->buildSlugForUniqueInPid($slug, $recordState);
            }
            $mobile->setSlug($slug);
            $this->mobileRepository->update($mobile);
        }

        if($_FILES['tx_mobilecompany_mobilecompanylistplugin']['tmp_name']['image']){
            $newFile = $this->getUploadedFileData($_FILES['tx_mobilecompany_mobilecompanylistplugin']['tmp_name']['image'], $_FILES['tx_mobilecompany_mobilecompanylistplugin']['name']['image']);
            
            $fileData = $newFile->getProperties();
            if ($fileData) {
                $this->mobileRepository->updateSysFileReferenceRecord(
                    (int)$fileData['uid'],
                    (int)$mobile->getUid(),
                    (int)$mobile->getPid(),
                    'tx_mobilecompany_domain_model_mobile',
                    'image'
                );
                $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
                $fileObjects = $fileRepository->findByRelation(
                    'tx_mobilecompany_domain_model_mobile',
                    'image',
                    $mobile->getUid()
                );
            }
        }
        $this->mobileRepository->update($mobile);

        $this->addFlashMessage('The object was updated.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::INFO);
        $this->redirect('list');
    }

    public function initializeUpdateAction(): void
    {
        $propertyMappingConfiguration = $this->arguments['mobile']->getPropertyMappingConfiguration();

        $propertyMappingConfiguration->forProperty('releaseDate')->setTypeConverterOption(
            DateTimeConverter::class,
            DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'Y-m-d'
        );
    }

    /**
     * action delete
     *
     * @param \Nitsan\MobileCompany\Domain\Model\Mobile $mobile
     */
    public function deleteAction(\Nitsan\MobileCompany\Domain\Model\Mobile $mobile)
    {
        $this->addFlashMessage('The Mobile was deleted.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->mobileRepository->remove($mobile);
        $this->redirect('list');
    }   
}

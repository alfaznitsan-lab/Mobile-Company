<?php

declare(strict_types=1);

namespace Nitsan\MobileCompany\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter;
use \TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Slug\SlugHelper;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Extbase\Domain\Model\FileReference; 
use TYPO3\CMS\Core\Resource\DuplicationBehavior; // Add this line
use TYPO3\CMS\Extbase\Property\TypeConverter\FileReferenceConverter;
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
        $mobiles = $this->mobileRepository->findAll();
        $this->view->assignMultiple(['mobiles' => $mobiles, 'detailPid' => $this->settings['detailPid'] ?? null,]);
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
    
    /**
     * action create
     *
     * @param \Nitsan\MobileCompany\Domain\Model\Mobile $newMobile
     */
    public function createAction(\Nitsan\MobileCompany\Domain\Model\Mobile $newMobile)
    {
        $this->mobileRepository->add($newMobile);

        // Generate slug after the record has been persisted and has a UID
        $record = null;
        $this->persistenceManager->persistAll();

        if ($record) {
            $tableName = 'tx_mobilecompany_domain_model_mobile';
            $slugFieldName = 'slug';

            // Initialize SlugHelper with the correct TCA config
            $fieldConfig = $GLOBALS['TCA'][$tableName]['columns'][$slugFieldName]['config'];
            $slugHelper = GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\SlugHelper::class, $tableName, $slugFieldName, $fieldConfig);

            // Generate the slug using the record data and its pid
            $slug = $slugHelper->generate($record, $record['pid']);

            // Handle slug uniqueness based on TCA 'eval' settings
            $evalInfo = GeneralUtility::trimExplode(',', $fieldConfig['eval'], true);
            if (in_array('uniqueInPid', $evalInfo, true)) {
                $recordState = RecordStateFactory::forName($tableName)->fromArray($record, $record['pid'], $record['uid']);
                $slug = $slugHelper->buildSlugForUniqueInPid($slug, $recordState);
            }

            // Update the object with the new slug and persist again.
            $newMobile->setSlug($slug);
            $this->mobileRepository->update($newMobile);
        }
        
        // Handle uploaded image
       /*$newImage = $_FILES['tx_mobilecompany_mobile']['tmp_name']['mobileImage'];
        DebugUtility::debug($newImage);

        if (!empty($newImage)) {
            $this->resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            $storage = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\StorageRepository::class)->getDefaultStorage();
            
            $imageFile = $_FILES['tx_mobilecompany_mobile']['tmp_name']['mobileImage'];
            $imageName = $_FILES['tx_mobilecompany_mobile']['name']['mobileImage'];

            $targetFolder = $storage->getFolder('fileadmin/user_upload');

            if (!$storage->hasFolder('fileadmin/user_upload')) {
                $targetFolder = $storage->createFolder('fileadmin/user_upload');
            }

            $newFile = $storage->addFile(
                $imageFile,
                $targetFolder,
                $imageName,
                DuplicationBehavior::RENAME
            );

            // Use the Extbase ObjectManager to create an instance of the Extbase FileReference
            if ($this->objectManager === null) {
                $this->objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
            }
            $fileReference = $this->objectManager->get(FileReference::class);
            $fileReference->setOriginalResource($newFile);
            $newMobile->setMobileImage($fileReference);
        }*/

        $this->mobileRepository->add($newMobile);

        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);

        $this->redirect('list');
    }
    
    /**
     * Initialize property mapping for create action
     */

    protected function initializeCreateAction(): void
    {
        $uploadFolder = '1:/user_upload/'; // Storage with UID 1, folder 'user_upload'

        // Set the configuration for the property mapper to handle the file upload.
        $this->arguments['newMobile']->getPropertyMappingConfiguration()
            ->forProperty('mobileImage')
            ->setTypeConverterOption(
                UploadedFileReferenceConverter::class,
                UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER,
                $uploadFolder
            );
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
    public function updateAction(\Nitsan\MobileCompany\Domain\Model\Mobile $mobile)
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

        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
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
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->mobileRepository->remove($mobile);
        $this->redirect('list');
    }   
}

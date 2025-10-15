<?php

declare(strict_types=1);

namespace Nitsan\MobileCompany\Controller;


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
     * mobileRepository
     *
     * @var \Nitsan\MobileCompany\Domain\Repository\MobileRepository
     */
    protected $mobileRepository = null;

    /**
     * @param \Nitsan\MobileCompany\Domain\Repository\MobileRepository $mobileRepository
     */
    public function injectMobileRepository(\Nitsan\MobileCompany\Domain\Repository\MobileRepository $mobileRepository)
    {
        $this->mobileRepository = $mobileRepository;
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
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($mobile); //debug command
        $this->view->assignMultiple(['mobile' => $mobile, 'listPid' => $this->settings['listPid'] ?? null,]);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \Nitsan\MobileCompany\Domain\Model\Mobile $newMobile
     */
    public function createAction(\Nitsan\MobileCompany\Domain\Model\Mobile $newMobile)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->mobileRepository->add($newMobile);
        $this->redirect('list');
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
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->mobileRepository->update($mobile);
        $this->redirect('list');
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

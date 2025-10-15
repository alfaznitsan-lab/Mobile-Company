<?php

declare(strict_types=1);

namespace Nitsan\MobileCompany\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 *
 * @author Nitsan <nit@example.com>
 */
class MobileControllerTest extends UnitTestCase
{
    /**
     * @var \Nitsan\MobileCompany\Controller\MobileController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\Nitsan\MobileCompany\Controller\MobileController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllMobilesFromRepositoryAndAssignsThemToView(): void
    {
        $allMobiles = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mobileRepository = $this->getMockBuilder(\Nitsan\MobileCompany\Domain\Repository\MobileRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $mobileRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMobiles));
        $this->subject->_set('mobileRepository', $mobileRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('mobiles', $allMobiles);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenMobileToView(): void
    {
        $mobile = new \Nitsan\MobileCompany\Domain\Model\Mobile();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('mobile', $mobile);

        $this->subject->showAction($mobile);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenMobileToMobileRepository(): void
    {
        $mobile = new \Nitsan\MobileCompany\Domain\Model\Mobile();

        $mobileRepository = $this->getMockBuilder(\Nitsan\MobileCompany\Domain\Repository\MobileRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $mobileRepository->expects(self::once())->method('add')->with($mobile);
        $this->subject->_set('mobileRepository', $mobileRepository);

        $this->subject->createAction($mobile);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenMobileToView(): void
    {
        $mobile = new \Nitsan\MobileCompany\Domain\Model\Mobile();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('mobile', $mobile);

        $this->subject->editAction($mobile);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenMobileInMobileRepository(): void
    {
        $mobile = new \Nitsan\MobileCompany\Domain\Model\Mobile();

        $mobileRepository = $this->getMockBuilder(\Nitsan\MobileCompany\Domain\Repository\MobileRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $mobileRepository->expects(self::once())->method('update')->with($mobile);
        $this->subject->_set('mobileRepository', $mobileRepository);

        $this->subject->updateAction($mobile);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenMobileFromMobileRepository(): void
    {
        $mobile = new \Nitsan\MobileCompany\Domain\Model\Mobile();

        $mobileRepository = $this->getMockBuilder(\Nitsan\MobileCompany\Domain\Repository\MobileRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $mobileRepository->expects(self::once())->method('remove')->with($mobile);
        $this->subject->_set('mobileRepository', $mobileRepository);

        $this->subject->deleteAction($mobile);
    }
}

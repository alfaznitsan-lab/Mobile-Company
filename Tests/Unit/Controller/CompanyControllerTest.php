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
class CompanyControllerTest extends UnitTestCase
{
    /**
     * @var \Nitsan\MobileCompany\Controller\CompanyController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\Nitsan\MobileCompany\Controller\CompanyController::class))
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
    public function listActionFetchesAllCompaniesFromRepositoryAndAssignsThemToView(): void
    {
        $allCompanies = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $companyRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $companyRepository->expects(self::once())->method('findAll')->will(self::returnValue($allCompanies));
        $this->subject->_set('companyRepository', $companyRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('companies', $allCompanies);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenCompanyToView(): void
    {
        $company = new \Nitsan\MobileCompany\Domain\Model\Company();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('company', $company);

        $this->subject->showAction($company);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenCompanyToCompanyRepository(): void
    {
        $company = new \Nitsan\MobileCompany\Domain\Model\Company();

        $companyRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $companyRepository->expects(self::once())->method('add')->with($company);
        $this->subject->_set('companyRepository', $companyRepository);

        $this->subject->createAction($company);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenCompanyToView(): void
    {
        $company = new \Nitsan\MobileCompany\Domain\Model\Company();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('company', $company);

        $this->subject->editAction($company);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenCompanyInCompanyRepository(): void
    {
        $company = new \Nitsan\MobileCompany\Domain\Model\Company();

        $companyRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $companyRepository->expects(self::once())->method('update')->with($company);
        $this->subject->_set('companyRepository', $companyRepository);

        $this->subject->updateAction($company);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenCompanyFromCompanyRepository(): void
    {
        $company = new \Nitsan\MobileCompany\Domain\Model\Company();

        $companyRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $companyRepository->expects(self::once())->method('remove')->with($company);
        $this->subject->_set('companyRepository', $companyRepository);

        $this->subject->deleteAction($company);
    }
}

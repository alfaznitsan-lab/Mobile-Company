<?php

declare(strict_types=1);

namespace Nitsan\MobileCompany\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Nitsan <nit@example.com>
 */
class CompanyTest extends UnitTestCase
{
    /**
     * @var \Nitsan\MobileCompany\Domain\Model\Company|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Nitsan\MobileCompany\Domain\Model\Company::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName(): void
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('name'));
    }

    /**
     * @test
     */
    public function getCountryReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCountry()
        );
    }

    /**
     * @test
     */
    public function setCountryForStringSetsCountry(): void
    {
        $this->subject->setCountry('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('country'));
    }

    /**
     * @test
     */
    public function getFoundedYearReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getFoundedYear()
        );
    }

    /**
     * @test
     */
    public function setFoundedYearForIntSetsFoundedYear(): void
    {
        $this->subject->setFoundedYear(12);

        self::assertEquals(12, $this->subject->_get('foundedYear'));
    }

    /**
     * @test
     */
    public function getWebsiteReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getWebsite()
        );
    }

    /**
     * @test
     */
    public function setWebsiteForStringSetsWebsite(): void
    {
        $this->subject->setWebsite('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('website'));
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription(): void
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('description'));
    }

    /**
     * @test
     */
    public function getMobilesReturnsInitialValueForMobile(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getMobiles()
        );
    }

    /**
     * @test
     */
    public function setMobilesForObjectStorageContainingMobileSetsMobiles(): void
    {
        $mobile = new \Nitsan\MobileCompany\Domain\Model\Mobile();
        $objectStorageHoldingExactlyOneMobiles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneMobiles->attach($mobile);
        $this->subject->setMobiles($objectStorageHoldingExactlyOneMobiles);

        self::assertEquals($objectStorageHoldingExactlyOneMobiles, $this->subject->_get('mobiles'));
    }

    /**
     * @test
     */
    public function addMobileToObjectStorageHoldingMobiles(): void
    {
        $mobile = new \Nitsan\MobileCompany\Domain\Model\Mobile();
        $mobilesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $mobilesObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($mobile));
        $this->subject->_set('mobiles', $mobilesObjectStorageMock);

        $this->subject->addMobile($mobile);
    }

    /**
     * @test
     */
    public function removeMobileFromObjectStorageHoldingMobiles(): void
    {
        $mobile = new \Nitsan\MobileCompany\Domain\Model\Mobile();
        $mobilesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $mobilesObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($mobile));
        $this->subject->_set('mobiles', $mobilesObjectStorageMock);

        $this->subject->removeMobile($mobile);
    }
}

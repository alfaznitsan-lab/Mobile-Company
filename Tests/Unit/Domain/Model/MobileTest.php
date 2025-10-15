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
class MobileTest extends UnitTestCase
{
    /**
     * @var \Nitsan\MobileCompany\Domain\Model\Mobile|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Nitsan\MobileCompany\Domain\Model\Mobile::class,
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
    public function getModelNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getModelName()
        );
    }

    /**
     * @test
     */
    public function setModelNameForStringSetsModelName(): void
    {
        $this->subject->setModelName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('modelName'));
    }

    /**
     * @test
     */
    public function getBrandReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBrand()
        );
    }

    /**
     * @test
     */
    public function setBrandForStringSetsBrand(): void
    {
        $this->subject->setBrand('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('brand'));
    }

    /**
     * @test
     */
    public function getPriceReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getPrice()
        );
    }

    /**
     * @test
     */
    public function setPriceForFloatSetsPrice(): void
    {
        $this->subject->setPrice(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('price'));
    }

    /**
     * @test
     */
    public function getReleaseDateReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getReleaseDate()
        );
    }

    /**
     * @test
     */
    public function setReleaseDateForDateTimeSetsReleaseDate(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setReleaseDate($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('releaseDate'));
    }

    /**
     * @test
     */
    public function getSpecificationsReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSpecifications()
        );
    }

    /**
     * @test
     */
    public function setSpecificationsForStringSetsSpecifications(): void
    {
        $this->subject->setSpecifications('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('specifications'));
    }

    /**
     * @test
     */
    public function getCompaniesReturnsInitialValueForCompany(): void
    {
        self::assertEquals(
            null,
            $this->subject->getCompanies()
        );
    }

    /**
     * @test
     */
    public function setCompaniesForCompanySetsCompanies(): void
    {
        $companiesFixture = new \Nitsan\MobileCompany\Domain\Model\Company();
        $this->subject->setCompanies($companiesFixture);

        self::assertEquals($companiesFixture, $this->subject->_get('companies'));
    }
}

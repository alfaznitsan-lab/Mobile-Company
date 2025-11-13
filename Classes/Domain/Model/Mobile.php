<?php

declare(strict_types=1);

namespace Nitsan\MobileCompany\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

/**
 * This file is part of the "Mobile Company" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 Nitsan <nit@example.com>, Nitsan
 */

/**
 * Mobile device informatio
 */
class Mobile extends AbstractEntity
{

    /**
     * Mobile model name
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $modelName = null;

    /**
     * Mobile brand
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $brand = null;

    /**
     * Price of the mobile
     *
     * @var float
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $price = null;

    /**
     * Release date
     *
     * @var \DateTime
     */
    protected $releaseDate = null;


    /**
     * Technical specifications
     *
     * @var string
     */
    protected $specifications = null;

    /**
     * @var ObjectStorage<FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $image = null;

    /**
     * companies
     *
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * 
     */
    protected $companies = null;

    /**
     * Returns the modelName
     *
     * @return string
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * Sets the modelName
     *
     * @param string $modelName
     * @return void
     */
    public function setModelName(string $modelName)
    {
        $this->modelName = $modelName;
    }
        
    /**
    * slug
    *
    * @var string
    */
    protected $slug = '';
    public function getSlug(): string
    {
        return $this->slug;
    }  

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * Returns the brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Sets the brand
     *
     * @param string $brand
     * @return void
     */
    public function setBrand(string $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Returns the price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the price
     *
     * @param float $price
     * @return void
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
    * Returns the releaseDate
    *
    * @return \DateTime releaseDate
    */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Sets the releaseDate
     *
     * @param \DateTime $releaseDate
     * @return void
     */
    public function setReleaseDate(\DateTime $releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * Returns the specifications
     *
     * @return string
     */
    public function getSpecifications()
    {
        return $this->specifications;
    }

    
    /**
     * Sets the specifications
     *
     * @param string $specifications
     * @return void
     */
    public function setSpecifications(string $specifications)
    {
        $this->specifications = $specifications;
    }

    /**
     * Returns the companies
     *
     * @return \Nitsan\MobileCompany\Domain\Model\Company companies
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * Sets the companies
     *
     * @param \Nitsan\MobileCompany\Domain\Model\Company $companies
     * @return void
     */
    public function setCompanies(\Nitsan\MobileCompany\Domain\Model\Company $companies)
    {
        $this->companies = $companies;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        // Do not remove the next line: It would break the functionality
        $this->image = new ObjectStorage();
    }

    /**
     * @psalm-return ObjectStorage<FileReference>
     */
    public function getImage(): ObjectStorage
    {
        return $this->image;
    }

    public function setImage(ObjectStorage $image): void
    {
        $this->image = $image;
    }

}
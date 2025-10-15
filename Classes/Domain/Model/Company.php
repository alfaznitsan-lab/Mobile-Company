<?php

declare(strict_types=1);

namespace Nitsan\MobileCompany\Domain\Model;


/**
 * This file is part of the "Mobile Company" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 Nitsan <nit@example.com>, Nitsan
 */

/**
 * Company/Manufacturer information
 */
class Company extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * company name
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $name = null;

    /**
     * country of origin
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $country = null;

    /**
     * Year established
     *
     * @var int
     */
    protected $foundedYear = null;

    /**
     * Company website URL
     *
     * @var string
     */
    protected $website = null;

    /**
     * Company description
     *
     * @var string
     */
    protected $description = null;

    /**
     * mobiles
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Nitsan\MobileCompany\Domain\Model\Mobile>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $mobiles = null;

    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->mobiles = $this->mobiles ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns the country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the country
     *
     * @param string $country
     * @return void
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    /**
     * Returns the foundedYear
     *
     * @return int
     */
    public function getFoundedYear()
    {
        return $this->foundedYear;
    }

    /**
     * Sets the foundedYear
     *
     * @param int $foundedYear
     * @return void
     */
    public function setFoundedYear(int $foundedYear)
    {
        $this->foundedYear = $foundedYear;
    }

    /**
     * Returns the website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Sets the website
     *
     * @param string $website
     * @return void
     */
    public function setWebsite(string $website)
    {
        $this->website = $website;
    }

    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Adds a Mobile
     *
     * @param \Nitsan\MobileCompany\Domain\Model\Mobile $mobile
     * @return void
     */
    public function addMobile(\Nitsan\MobileCompany\Domain\Model\Mobile $mobile)
    {
        $this->mobiles->attach($mobiles);
    }

    /**
     * Removes a Mobile
     *
     * @param \Nitsan\MobileCompany\Domain\Model\Mobile $mobileToRemove The Mobile to be removed
     * @return void
     */
    public function removeMobile(\Nitsan\MobileCompany\Domain\Model\Mobile $mobileToRemove)
    {
        $this->mobiles->detach($mobileToRemove);
    }

    /**
     * Returns the mobiles
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Nitsan\MobileCompany\Domain\Model\Mobile> mobiles
     */
    public function getMobiles()
    {
        return $this->mobiles;
    }

    /**
     * Sets the mobiles
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Nitsan\MobileCompany\Domain\Model\Mobile> $mobiles
     * @return void
     */
    public function setMobiles(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $mobiles)
    {
        $this->mobiles = $mobiles;
    }
}

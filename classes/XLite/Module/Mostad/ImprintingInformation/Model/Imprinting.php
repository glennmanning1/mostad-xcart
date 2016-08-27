<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Nova Horizons
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  X-Cart 5
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/x-cart/license License Agreement
 * @link      http://novahorizons.io/
 */

namespace XLite\Module\Mostad\ImprintingInformation\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * Class Imprinting
 * @package XLite\Module\Mostad\ImprintingInformation\Model
 *
 * @Entity()
 * @Table(name="imprinting")
 */
class Imprinting extends \XLite\Model\AEntity
{
    const STATUS_NEW    = 'NEW';
    const STATUS_SAME   = 'SAME';
    const STATUS_UPDATE = 'UPDATE';
    /**
     * @var int
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * Item order
     *
     * @var \XLite\Model\Order
     *
     * @OneToOne  (targetEntity="XLite\Model\Order", inversedBy="imprinting")
     * @JoinColumn (name="order_id", referencedColumnName="order_id", onDelete="CASCADE")
     */
    protected $order;

    /**
     * @var string
     * @Column(type="string", length=10)
     */
    protected $status = self::STATUS_NEW;

    /**
     * @var string
     * @Column(name="firm_name", type="string", length=255, nullable=true)
     */
    protected $firmName;

    /**
     * @var string
     * @Column(name="designation", type="string", length=255, nullable=true)
     */
    protected $designation;

    /**
     * @var string
     * @Column(name="name", type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var string
     * @Column(name="address", type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     * @var string
     * @Column(name="address2", type="string", length=255, nullable=true)
     */
    protected $address2;
    /**
     * @var string
     * @Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var \XLite\Model\State
     * @OneToOne(targetEntity="\XLite\Model\State")
     * @JoinColumn(name="state_id", referencedColumnName="state_id")
     *
     */
    protected $state;

    /**
     * @var string
     * @Column(name="zip", type="string", length=255, nullable=true)
     */
    protected $zip;

    /**
     * @var string
     * @Column(name="phone_code", type="string", length=255, nullable=true)
     */
    protected $phoneCode;

    /**
     * @var string
     * @Column(name="phone", type="string", length=255, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     * @Column(name="fax_code", type="string", length=255, nullable=true)
     */
    protected $faxCode;

    /**
     * @var string
     * @Column(name="fax", type="string", length=255, nullable=true)
     */
    protected $fax;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $website;

    /**
     * @var boolean
     * @Column(name="add_logo", type="boolean")
     */
    protected $addLogo = false;

    /**
     * @var string
     * @Column(name="online_firm_name", type="string", length=255, nullable=true)
     */
    protected $onlineFirmName;

    /**
     * @var string
     * @Column(name="online_email", type="string", length=255, nullable=true)
     */
    protected $onlineEmail;

    /**
     * @var string
     * @Column(name="online_website", type="string", length=255, nullable=true)
     */
    protected $onlineWebsite;

    /**
     * @var bool
     * @Column(name="online_add_logo", type="boolean")
     */
    protected $onlineAddLogo = false;

    /**
     * @var boolean
     * @Column(name="online_add_to_site", type="boolean")
     */
    protected $onlineAddToSite = false;
    /**
     * @var boolean
     * @Column(type="boolean")
     */
    protected $confirm = false;


    public static $addressFields = [
        'firmName'    => 'Firm Name',
        'designation' => 'Designation',
        'name'        => 'Name',
        'address'     => 'Address',
        'address2'    => 'Address 2',
        'city'        => 'City',
        'state'       => 'State',
        'zip'         => 'Zip Code',
        'phone'       => 'Phone',
        'fax'         => 'FAX',
    ];


    public static function getStatusArray()
    {
        return [
            self::STATUS_NEW    => 'I am ordering imprinting for the first time. I have indicated my imprint information in the fields below.',
            self::STATUS_UPDATE => 'My imprint information has changed. My imprint changes are indicated in the fields below.(Additional $17 change fee will be added to your order.) ',
            self::STATUS_SAME   => 'My imprint has NOT changed. Use my imprint information that you have on file.',
        ];
    }

    public function isNew()
    {
        return $this->status == self::STATUS_NEW;
    }

    public function isSame()
    {
        return $this->status == self::STATUS_SAME;
    }

    public function isUpdate()
    {
        return $this->status == self::STATUS_UPDATE;
    }
}
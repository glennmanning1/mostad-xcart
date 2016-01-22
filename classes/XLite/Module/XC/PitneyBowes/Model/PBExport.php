<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\XC\PitneyBowes\Model;

/**
 * The "pbexport" model class
 *
 * @Entity
 * @Table  (name="pb_exports",
 *      indexes={
 *          @Index (name="status", columns={"status"}),
 *      }
 * )
 * @HasLifecycleCallbacks
 */
class PBExport extends \XLite\Model\AEntity
{
    const STATUS_APPROVED               = 1;
    const STATUS_FAILED                 = 2;
    const STATUS_PENDING                = 0;

    /**
     * Export Unique ID
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Export filename
     *
     * @var string
     *
     * @Column (type="text")
     */
    protected $filename = '';

    /**
     * Export date (UNIX timestamp)
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $exportDate;

    /**
     * Export status
     *
     * @var integer
     *
     * @Column (type="smallint")
     */
    protected $status = self::STATUS_PENDING;

    /**
     * Export errors
     *
     * @var string
     *
     * @Column (type="text")
     */
    protected $errors = '';

    /**
     * True if export is not full
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $differential = false;

    /**
     * Define if review is approved
     *
     * @return boolean
     */
    public function isApproved()
    {
        return $this->getStatus() == static::STATUS_APPROVED;
    }

    /**
     * Define if review is approved
     *
     * @return boolean
     */
    public function isFailed()
    {
        return $this->getStatus() == static::STATUS_FAILED;
    }

    /**
     * Define if review is not approved
     *
     * @return boolean
     */
    public function isPending()
    {
        return $this->getStatus() == static::STATUS_PENDING;
    }

    /**
     * Prepare creation date
     *
     * @return void
     *
     * @PrePersist
     */
    public function prepareBeforeCreate()
    {
        if (!$this->getExportDate()) {
            $this->setExportDate(\XLite\Core\Converter::time());
        }
    }
}

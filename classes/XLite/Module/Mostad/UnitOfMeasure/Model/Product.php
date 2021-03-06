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

namespace XLite\Module\Mostad\UnitOfMeasure\Model;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

class Product extends \XLite\Model\Product implements \XLite\Base\IDecorator
{
    const UOM_EACH    = 'EACH';
    const UOM_BOX     = 'BOX';
    const UOM_PACKAGE = 'PACKAGE';

    /**
     * @var integer
     *
     * @Column(name="uom_quantity", type="integer")
     */
    protected $uomQuantity = 1;

    /**
     * @var string
     * @Column(name="uom_descriptor", type="string", length=10)
     */
    protected $uomDescriptor = self::UOM_EACH;

    /**
     * @var int
     * @Column(name="order_quantity", type="integer")
     */
    protected $orderQuantity = 1;

    /**
     * @var string
     * @Column(name="friendly_descriptor", type="string", nullable=true)
     */
    protected $friendlyDescriptor;
    
    static $unitsOfMeasure =  array(
            self::UOM_EACH    => 'each',
            self::UOM_BOX     => 'bx',
            self::UOM_PACKAGE => 'pkg',
        );

    protected $pluralUnitsOfMeasure = array(
            self::UOM_EACH    => 'each',
            self::UOM_BOX     => 'boxes',
            self::UOM_PACKAGE => 'packages',
        );
    
    public function getUomDescriptor($friendly = false, $amount = 1)
    {
        if (!$this->uomDescriptor) {
            $this->uomDescriptor = self::UOM_EACH;
        }
        if ($friendly) {
            return self::$unitsOfMeasure[$this->uomDescriptor];
        }
        
        return $this->uomDescriptor;
    }

    public function getUomQuantity()
    {
        if (!$this->uomQuantity) {
            $this->uomQuantity = 1;
        }

        return $this->uomQuantity;
    }

    public function getUomDisplay($amount = 1)
    {
        $desciptor = $this->getUomDescriptor(true, $amount);

        if ($this->getUomQuantity() > 1) {
            $desciptor .= ' of ' . $this->getUomQuantity();
        }

        return $desciptor;
    }

    public function getFriendlyUom()
    {
        if ($this->friendlyDescriptor) {
            return $this->friendlyDescriptor;
        }

        return $this->getUomDisplay();
    }
    
    

}
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
    
    static $unitsOfMeasure =  array(
            self::UOM_EACH    => 'each',
            self::UOM_BOX     => 'box',
            self::UOM_PACKAGE => 'package',
        );
    
    public function getUomDescriptor($friendly = false)
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

}
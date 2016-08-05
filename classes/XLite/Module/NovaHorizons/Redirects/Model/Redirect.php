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
 * @author    Nova Horizons LLC <xcart@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horizons LLC <xcart@novahorizons.io>. All rights reserved
 * @license   https://novahorizons.io/x-cart/license License Agreement
 * @link      https://novahorizons.io/
 */

namespace XLite\Module\NovaHorizons\Redirects\Model;

/**
 * @Entity
 * @Table (name="redirect")
 */

class Redirect extends \XLite\Model\AEntity
{
    /**
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer")
     */
    protected $id;

    /**
     * @Column (type="boolean")
     */
    protected $enabled = true;

    /**
     * @Column (type="string")
     */
    protected $path = '';

    /**
     * @Column (type="string")
     */
    protected $target = '';
}

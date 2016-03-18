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

namespace XLite\Module\Mostad\BlogUpdates\Model;

/**
 * Blog Post Cache Data
 *
 * @Entity()
 * @Table(name="blog_post")
 */
class BlogPost extends \XLite\Model\AEntity
{
    /**
     * Unique id
     *
     * @var integer
     *
     * @Id()
     * @GeneratedValue()
     * @Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $date;

    /**
     * @var string
     *
     * @Column(type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @var string
     *
     * @Column(type="string", length=255, nullable=false)
     */
    protected $link;

    /**
     * @var \DateTime
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $cached;

    /**
     * BlogPost constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->cached = new \DateTime('now');
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->date->format('M');
    }

    /**
     * @return string
     */
    public function getDay()
    {
        return $this->date->format('j');
    }
}
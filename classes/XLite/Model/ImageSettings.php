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

namespace XLite\Model;

/**
 * Image settings model
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\ImageSettings")
 * @Table  (name="images_settings",
 *      uniqueConstraints={
 *          @UniqueConstraint (name="code_model", columns={"code", "model"})
 *      })
 */
class ImageSettings extends \XLite\Model\AEntity
{
    /**
     * Unique Id
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer")
     */
    protected $id;

    /**
     * Image size code
     *
     * @var string
     *
     * @Column (type="string")
     */
    protected $code;

    /**
     * Model (class name of image model)
     *
     * @var string
     *
     * @Column (type="string")
     */
    protected $model;

    /**
     * Image max width
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $width;

    /**
     * Image max height
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $height;

    /**
     * Get image setting name
     *
     * @return string
     */
    public function getName()
    {
        return static::t('imgsize-' . $this->getImageType() . '-' .$this->getCode());
    }

    /**
     * Get image type by model class
     *
     * @return string
     */
    protected function getImageType()
    {
        $imageTypes = $this->getImageTypes();

        return !empty($imageTypes[$this->getModel()]) ? $imageTypes[$this->getModel()] : $this->getModel();
    }

    /**
     * Get list of available image size types
     *
     * @return array
     */
    protected function getImageTypes()
    {
        return array(
            \XLite\Logic\ImageResize\Generator::MODEL_PRODUCT => 'product',
            \XLite\Logic\ImageResize\Generator::MODEL_CATEGORY => 'category',
        );
    }
}

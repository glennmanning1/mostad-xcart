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

namespace XLite\Model\Shipping;

/**
 * Shipping method model
 *
 * @Entity (repositoryClass="XLite\Model\Repo\Shipping\Method")
 * @Table  (name="shipping_methods",
 *      indexes={
 *          @Index (name="processor", columns={"processor"}),
 *          @Index (name="carrier", columns={"carrier"}),
 *          @Index (name="enabled", columns={"enabled"}),
 *          @Index (name="position", columns={"position"})
 *      }
 * )
 */
class Method extends \XLite\Model\Base\I18n
{
    /**
     * A unique ID of the method
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer")
     */
    protected $method_id;

    /**
     * Processor class name
     *
     * @var string
     *
     * @Column (type="string", length=255)
     */
    protected $processor = '';

    /**
     * Carrier of the method (for instance, "UPS" or "USPS")
     *
     * @var string
     *
     * @Column (type="string", length=255)
     */
    protected $carrier = '';

    /**
     * Unique code of shipping method (within processor space)
     *
     * @var string
     *
     * @Column (type="string", length=255)
     */
    protected $code = '';

    /**
     * Whether the method is enabled or disabled
     *
     * @var string
     *
     * @Column (type="boolean")
     */
    protected $enabled = false;

    /**
     * A position of the method among other registered methods
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $position = 0;

    /**
     * Shipping rates (relation)
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @OneToMany (targetEntity="XLite\Model\Shipping\Markup", mappedBy="shipping_method", cascade={"all"})
     */
    protected $shipping_markups;

    /**
     * Tax class (relation)
     *
     * @var \XLite\Model\TaxClass
     *
     * @ManyToOne  (targetEntity="XLite\Model\TaxClass")
     * @JoinColumn (name="tax_class_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $taxClass;

    /**
     * Added status
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $added = false;

    /**
     * Specific module family name
     *
     * @var string
     *
     * @Column (type="string", length=255)
     */
    protected $moduleName = '';

    /**
     * Flag:
     *   1 - method has been got from marketplace,
     *   0 - method has been added after distr or module installation
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $fromMarketplace = false;

    /**
     * Icon URL (used for methods from marketplace)
     *
     * @var string
     *
     * @Column (type="string", length=255, nullable=true)
     */
    protected $iconURL;

    /**
     * Table type
     *
     * @var string
     *
     * @Column (type="string", options={ "fixed": true }, length=3, nullable=true)
     */
    protected $tableType;

    /**
     * Handling fee (surcharge) for online methods
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=4)
     */
    protected $handlingFee = 0;

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     */
    public function __construct(array $data = array())
    {
        $this->shipping_markups = new \Doctrine\Common\Collections\ArrayCollection();

        parent::__construct($data);
    }

    /**
     * Get processor class object
     *
     * @return null|\XLite\Model\Shipping\Processor\AProcessor
     */
    public function getProcessorObject()
    {
        return \XLite\Model\Shipping::getProcessorObjectByProcessorId($this->getProcessor());
    }

    /**
     * Returns processor module
     *
     * @return \XLite\Model\Module
     */
    public function getProcessorModule()
    {
        $module = null;
        $processor = $this->getProcessorObject();

        if ($processor) {
            $module = $this->getProcessorObject()->getModule();
        } else {
            $moduleName = $this->getModuleName();

            if ($moduleName) {
                list ($author, $name) = explode('_', $moduleName);
                /** @var \XLite\Model\Repo\Module $repo */
                $repo = \XLite\Core\Database::getRepo('XLite\Model\Module');
                $module = $repo->findModuleByName($author . '\\' . $name);
            }
        }

        return $module;
    }

    /**
     * Get payment method admin zone icon URL
     *
     * @return string
     */
    public function getAdminIconURL()
    {
        $url = $this->getProcessorObject()
            ? $this->getProcessorObject()->getAdminIconURL($this)
            : $this->getIconURL();

        if (true === $url || null === $url) {
            $module = $this->getProcessorModule();
            $url = $module
                ? \XLite\Core\Layout::getInstance()->getResourceWebPath(
                    'modules/' . $module->getAuthor() . '/' . $module->getName() . '/method_icon.jpg'
                )
                : null;
        }

        return $url;
    }

    /**
     * Return true if rates exists for this shipping method
     *
     * @return boolean
     */
    public function hasRates()
    {
        return (bool) $this->getRatesCount();
    }

    /**
     * Get count of rates specified for this shipping method
     *
     * @return integer
     */
    public function getRatesCount()
    {
        return count($this->getShippingMarkups());
    }

    /**
     * Check if method is enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled
            && (null === $this->getProcessorObject() || $this->getProcessorObject()->isConfigured());
    }

    /**
     * Returns present status
     *
     * @return boolean
     */
    public function isAdded()
    {
        return (bool) $this->added;
    }

    /**
     * Set present status
     *
     * @param boolean $value Value
     */
    public function setAdded($value)
    {
        $changed = $this->added !== $value;
        $this->added = (bool) $value;

        if (!$this->added) {
            $this->setEnabled(false);

        } elseif ($changed) {
            $last = $this->getRepository()->findOneCarrierMaxPosition();
            $this->setPosition($last ? $last->getPosition() + 1 : 0);
        }
    }

    /**
     * Check if shipping method is from marketplace
     *
     * @return bool
     */
    public function isFromMarketplace()
    {
        return (bool) $this->getFromMarketplace();
    }

    /**
     * Returns module author and name (with underscore as separator)
     *
     * @return string
     */
    public function getModuleName()
    {
        $result = $this->moduleName;

        if (!$this->isFromMarketplace()) {
            $processor = $this->getProcessorObject();
            if ($processor) {
                $module = $processor->getModule();
                $result = $module->getAuthor() . '_' . $module->getName();
            }
        }

        return $result;
    }

    /**
     * Return parent method for online carrier service
     *
     * @return \XLite\Model\Shipping\Method
     */
    public function getParentMethod()
    {
        return 'offline' !== $this->getProcessor() && '' !== $this->getCarrier()
            ? $this->getRepository()->findOnlineCarrier($this->getProcessor())
            : null;
    }

    /**
     * Retuns children methods for online carrier
     *
     * @return array
     */
    public function getChildrenMethods()
    {
        return 'offline' !== $this->getProcessor() && '' === $this->getCarrier()
            ? $this->getRepository()->findMethodsByProcessor($this->getProcessor(), false)
            : array();
    }

    /**
     * Returns handling fee
     *
     * @return float
     */
    public function getHandlingFee()
    {
        $parentMethod = $this->getParentMethod();

        return $parentMethod ? $parentMethod->getHandlingFee() : $this->handlingFee;
    }
}

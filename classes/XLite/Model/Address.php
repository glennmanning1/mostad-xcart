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
 * Address model
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\Address")
 * @Table  (name="profile_addresses",
 *      indexes={
 *          @Index (name="is_billing", columns={"is_billing"}),
 *          @Index (name="is_shipping", columns={"is_shipping"})
 *      }
 * )
 * @HasLifecycleCallbacks
 */
class Address extends \XLite\Model\Base\PersonalAddress
{

    /**
     * Address type codes
     */
    const BILLING  = 'b';
    const SHIPPING = 's';

    /**
     * Address fields collection
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @OneToMany (targetEntity="XLite\Model\AddressFieldValue", mappedBy="address", cascade={"all"})
     */
    protected $addressFields;

    /**
     * Flag: is it a billing address
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $is_billing = false;

    /**
     * Flag: is it a shipping address
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $is_shipping = false;

    /**
     * Flag: is it a work address
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $isWork = false;

    /**
     * Profile: many-to-one relation with profile entity
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne (targetEntity="XLite\Model\Profile", inversedBy="addresses", cascade={"persist","merge","detach"})
     * @JoinColumn (name="profile_id", referencedColumnName="profile_id", onDelete="CASCADE")
     */
    protected $profile;

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     */
    public function __construct(array $data = array())
    {
        $this->addressFields = new \Doctrine\Common\Collections\ArrayCollection();

        parent::__construct($data);
    }

    /**
     * Universal setter
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return true|null Returns TRUE if the setting succeeds. NULL if the setting fails
     */
    public function setterProperty($property, $value)
    {
        $result = parent::setterProperty($property, $value);

        if (null === $result) {
            $addressField = \XLite\Core\Database::getRepo('XLite\Model\AddressField')
                ->findOneBy(array('serviceName' => $property));

            if ($addressField) {
                $repo = \XLite\Core\Database::getRepo('XLite\Model\AddressFieldValue');

                $addressFieldValue = $this->getFieldValue($property);

                if ($addressFieldValue) {
                    $addressFieldValue->setValue($value);
                    if ($this->isPersistent()) {
                        $repo->update($addressFieldValue);
                    }

                } else {
                    $addressFieldValue = new \XLite\Model\AddressFieldValue();
                    $addressFieldValue->map(
                        array(
                            'address'      => $this,
                            'addressField' => $addressField,
                            'value'        => $value,
                        )
                    );
                    $this->addAddressFields($addressFieldValue);
                    if ($this->isPersistent()) {
                        $repo->insert($addressFieldValue);
                    }
                }

                $result = true;

            } else {
                // Log wrong access to property
                $this->logWrongAddressPropertyAccess($property, false);
            }
        }

        return $result;
    }

    /**
     * Update searchFakeField of profile
     *
     * @return boolean
     */
    public function update()
    {
        $result = parent::update();

        if ($this->getProfile()) {
            \XLite\Core\Database::getEM()->refresh($this->getProfile());
            $this->getProfile()->updateSearchFakeField();
        }

        return $result;
    }

    /**
     * Update searchFakeField of profile
     *
     * @return boolean
     */
    public function delete()
    {
        // We are using id because we can't user em->refresh or em->merge
        $profileId = $this->getProfile()
            ? $this->getProfile()->getProfileId()
            : null;

        $result = parent::delete();
        if ($profileId) {
            $profile = \XLite\Core\Database::getRepo('XLite\Model\Profile')->find($profileId);

            $profile->updateSearchFakeField();
        }

        return $result;
    }

    /**
     * Update searchFakeField of profile
     *
     * @return boolean
     */
    public function create()
    {
        $result = parent::create();

        if ($this->getProfile()) {
            \XLite\Core\Database::getEM()->refresh($this->getProfile());
            $this->getProfile()->updateSearchFakeField();
        }

        return $result;
    }

    /**
     * Universal getter
     *
     * @param string $property
     *
     * @return mixed|null Returns NULL if it is impossible to get the property
     */
    public function getterProperty($property)
    {
        $result = parent::getterProperty($property);

        if (null === $result) {
            $addressField = static::getAddressFieldByServiceName($property);

            if ($addressField) {
                $addressFieldValue = $this->getFieldValue($property);

                $result = $addressFieldValue
                    ? $addressFieldValue->getValue()
                    : static::getDefaultFieldPlainValue($property);

            } else {
                // Log wrong access to property
                $this->logWrongAddressPropertyAccess($property);
            }
        }

        return $result;
    }

    /**
     * Disable default logging of access to wrong property
     *
     * @param string  $property Property name
     * @param boolean $isGetter Flag: is called property getter (true) or setter (false) OPTIONAL
     *
     * @return void
     */
    protected function logWrongPropertyAccess($property, $isGetter = true)
    {
    }

    /**
     * Log access to unknown address property
     *
     * @param string  $property Property name
     * @param boolean $isGetter Flag: is called property getter (true) or setter (false) OPTIONAL
     *
     * @return void
     */
    protected function logWrongAddressPropertyAccess($property, $isGetter = true)
    {
        parent::logWrongPropertyAccess($property, $isGetter);
    }

    /**
     * Return true if specified property exists
     *
     * @param string $name Property name
     *
     * @return boolean
     */
    public function isPropertyExists($name)
    {
        return parent::isPropertyExists($name)
            || (bool) static::getAddressFieldByServiceName($name);
    }

    /**
     * Get field value
     *
     * @param string $name Field name
     *
     * @return \XLite\Model\AddressFieldValue
     */
    public function getFieldValue($name)
    {
        $addressFieldValue = null;

        $addressField = static::getAddressFieldByServiceName($name);

        if ($addressField) {
            foreach ($this->getAddressFields() as $field) {
                if ($field->getAddressField()
                    && (int) $field->getAddressField()->getId() === (int) $addressField->getId()
                ) {
                    $addressFieldValue = $field;
                    break;
                }
            }
        }

        return $addressFieldValue;
    }

    public static function createDefaultShippingAddress()
    {
        $address = new \XLite\Model\Address();

        $requiredFields = array('country', 'state', 'custom_state', 'zipcode', 'city');

        $data = array();
        foreach ($requiredFields as $fieldName) {
            if (!isset($data[$fieldName]) && \XLite\Model\Address::getDefaultFieldValue($fieldName)) {
                $data[$fieldName] = \XLite\Model\Address::getDefaultFieldValue($fieldName);
            }
        }

        $address->map($data);

        return $address;
    }

    /**
     * Get default value for the field
     *
     * @param string $fieldName Field service name
     *
     * @return mixed
     */
    public static function getDefaultFieldValue($fieldName)
    {
        $result = null;

        switch ($fieldName) {
            case 'country':
                $code = \XLite\Core\Config::getInstance()->Shipping->anonymous_country;
                $result = \XLite\Core\Database::getRepo('XLite\Model\Country')->findOneByCode($code);
                break;

            case 'state':
                $id = \XLite\Core\Config::getInstance()->Shipping->anonymous_state;
                $result = \XLite\Core\Database::getRepo('XLite\Model\State')->find($id);
                break;

            case 'custom_state':
                $result = \XLite\Core\Config::getInstance()->Shipping->anonymous_custom_state;
                break;

            case 'zipcode':
                $result = \XLite\Core\Config::getInstance()->Shipping->anonymous_zipcode;
                break;

            case 'city':
                $result = \XLite\Core\Config::getInstance()->Shipping->anonymous_city;
                break;

            default:
        }

        return $result;
    }


    /**
     * Get required fields by address type
     *
     * @param string $atype Address type code
     *
     * @return array
     */
    public function getRequiredFieldsByType($atype)
    {
        switch ($atype) {
            case static::BILLING:
                $list = \XLite\Core\Database::getRepo('XLite\Model\AddressField')->getBillingRequiredFields();
                break;

            case static::SHIPPING:
                $list = \XLite\Core\Database::getRepo('XLite\Model\AddressField')->getShippingRequiredFields();
                break;

            default:
                $list = null;
                // TODO - add throw exception
        }

        return $list;
    }

    /**
     * Clone
     *
     * @return \XLite\Model\AEntity
     */
    public function cloneEntity()
    {
        $entity = parent::cloneEntity();

        foreach (\XLite\Core\Database::getRepo('XLite\Model\AddressField')->findAllEnabled() as $field) {
            $entity->setterProperty($field->getServiceName(), $this->getterProperty($field->getServiceName()));
        }

        if ($this->getProfile()) {
            $entity->setProfile($this->getProfile());
        }

        return $entity;
    }

    /**
     * Get country
     *
     * @return \XLite\Model\Country
     */
    public function getCountry()
    {
        $result = $this->country;

        if (!$result) {
            $countryField = \XLite\Core\Database::getRepo('XLite\Model\AddressField')
                ->findOneBy(array('serviceName' => 'country_code', 'enabled' => false));
            if ($countryField) {
                $result = \XLite\Model\Address::getDefaultFieldValue('country');
            }
        }

        return $result;
    }
}

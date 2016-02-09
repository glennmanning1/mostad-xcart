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
 * Abstract entity
 */
abstract class AEntity extends \XLite\Base\SuperClass
{
    /**
     * Possible action by entity Repo
     */
    const ACTION_INSERT = 'insert';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    /**
     * Cache enabled flag (cache)
     *
     * @var array
     */
    protected static $cacheEnabled = array();

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     */
    public function __construct(array $data = array())
    {
        parent::__construct();

        if (!empty($data)) {
            $this->map($data);
        }
    }

    /**
     * Map data to entity columns
     *
     * @param array $data Data
     *
     * @return \XLite\Model\AEntity
     */
    public function map(array $data)
    {
        foreach ($data as $key => $value) {
            // Map only existing properties with setter methods or direct
            $method = 'set' . \Includes\Utils\Converter::convertToPascalCase($key);

            if (method_exists($this, $method)) {
                // $method is assembled from 'set' + getMethodName()
                $this->$method($value);

            } else {
                $this->setterProperty($key, $value);
            }
        }

        return $this;
    }

    /**
     * Common getter
     *
     * @param string $name Property name
     *
     * @return mixed
     */
    public function __get($name)
    {
        // Accessor method name
        return $this->{'get' . \Includes\Utils\Converter::convertToPascalCase($name)}();
    }

    /**
     * Common setter
     *
     * @param string $name  Property name
     * @param mixed  $value Property value
     *
     * @return mixed
     */
    public function __set($name, $value)
    {
        // Mutator method name
        return $this->{'set' . \Includes\Utils\Converter::convertToPascalCase($name)}($value);
    }

    /**
     * Common isset
     *
     * @param string $name Property name
     *
     * @return boolean
     */
    public function __isset($name)
    {
        return !is_null($this->__get($name));
    }

    /**
     * Common unset
     *
     * @param string $name Property name
     *
     * @return void
     */
    public function __unset($name)
    {
        $this->__set($name, null);
    }

    /**
     * Get entity repository
     *
     * @return \XLite\Model\Repo\ARepo
     */
    public function getRepository()
    {
        return \XLite\Core\Database::getRepo(get_class($this));
    }

    /**
     * Check cache after entity persis or remove
     *
     * @return void
     */
    public function checkCache()
    {
        $class = get_class($this);

        if (!isset(static::$cacheEnabled[$class])) {
            $repo = $this->getRepository();

            static::$cacheEnabled[$class] = ($repo && is_subclass_of($repo, '\XLite\Model\Repo\ARepo'))
                ? $repo->hasCacheCells()
                : false;
        }

        if (static::$cacheEnabled[$class]) {
            $this->getRepository()->deleteCacheByEntity($this);
        }
    }

    /**
     * Detach static
     *
     * @return void
     */
    public function detach()
    {
        \XLite\Core\Database::getEM()->detach($this);
    }

    /**
     * Emulate the Doctrine autogenerated methods.
     * TODO - DEVCODE - to remove!
     *
     * @param string $method Method name
     * @param array  $args   Call arguments OPTIONAL
     *
     * @return mixed
     */
    public function __call($method, array $args = array())
    {
        $result = preg_match('/^(get|set)(\w+)$/Si', $method, $matches) && !empty($matches[2]);
        if ($result) {
            $property = \XLite\Core\Converter::convertFromCamelCase($matches[2]);
            $result = 'set' === $matches[1]
                ? $this->setterProperty($property, array_shift($args))
                : $this->getterProperty($property);
        } else {
            $result = null;
        }

        return $result;
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
        return property_exists($this, $name) || property_exists($this, \XLite\Core\Converter::convertFromCamelCase($name));
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
        $result = property_exists($this, $property);

        if ($result) {
            // Get property value
            $this->$property = $value;

        } else {
            // Log wrong access to property
            $this->logWrongPropertyAccess($property, false);
        }

        return $result ?: null;
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
        $result = null;

        if (property_exists($this, $property)) {
            // Get property value
            $result = $this->$property;

        } else {
            // Log wrong access to property
            $this->logWrongPropertyAccess($property);
        }

        return $result;
    }

    /**
     * Log access to unknow property
     *
     * @param string  $property Property name
     * @param boolean $isGetter Flag: is called property getter (true) or setter (false) OPTIONAL
     *
     * @return void
     */
    protected function logWrongPropertyAccess($property, $isGetter = true)
    {
        if (LOG_DEBUG == \Includes\Utils\ConfigParser::getOptions(array('log_details', 'level'))) {
            \XLite\Logger::getInstance()->log(
                sprintf(
                    'Requested %s for unknown property: %s::%s',
                    $isGetter ? 'getter' : 'setter',
                    get_class($this),
                    $property
                ),
                LOG_ERR
            );
        }
    }

    /**
     * Check if entity is persistent
     *
     * @return boolean
     */
    public function isPersistent()
    {
        return (bool) $this->getUniqueIdentifier();
    }

    /**
     * Check if the entity is in the DETACHED state
     *
     * @return boolean
     */
    public function isDetached()
    {
        return \Doctrine\ORM\UnitOfWork::STATE_DETACHED === $this->getEntityState();
    }

    /**
     * The Entity state getter
     *
     * @return integer
     */
    protected function getEntityState()
    {
        return \XLite\Core\Database::getEM()->getUnitOfWork()->getEntityState($this);
    }

    /**
     * Get entity unique identifier name
     *
     * @return string
     */
    public function getUniqueIdentifierName()
    {
        return $this->getRepository()->getPrimaryKeyField();
    }

    /**
     * Get entity unique identifier value
     *
     * @return integer
     */
    public function getUniqueIdentifier()
    {
        return $this->{'get' . \Includes\Utils\Converter::convertToPascalCase($this->getUniqueIdentifierName())}();
    }

    /**
     * Update entity
     *
     * @return boolean
     */
    public function update()
    {
        \XLite\Core\Database::getEM()->persist($this);
        \XLite\Core\Database::getEM()->flush();

        return true;
    }

    /**
     * Create entity
     *
     * @return boolean
     */
    public function create()
    {
        return $this->update();
    }

    /**
     * Delete entity
     *
     * @return boolean
     */
    public function delete()
    {
        \XLite\Core\Database::getEM()->remove($this);
        \XLite\Core\Database::getEM()->flush();
        \XLite\Core\Database::getEM()->clear();

        return true;
    }

    /**
     * Process files
     *
     * @param string $field        Field
     * @param array  $data Data to save
     *
     * @return void
     */
    public function processFiles($field, array $data)
    {
        $entityProperties = $this->getRepository()->getEntityProperties();
        $entityProperties = $entityProperties[1][$field];
        if ($entityProperties && is_array($data)) {
            $value = $this->getterProperty($field);
            if ($entityProperties['many']) {
                foreach ($value as $file) {
                    if (isset($data[$file->getId()])) {
                        $this->processFile($file, $data[$file->getId()], $entityProperties);
                        unset($data[$file->getId()]);
                    }
                }
                foreach ($data as $k => $tempData) {
                    $this->processFile(null, $tempData, $entityProperties);
                }

            } else {
                $this->processFile($value, $data, $entityProperties);
            }
        }
    }

    /**
     * Process files
     *
     * @param mixed $file       File
     * @param array $data       Data to save
     * @param array $properties Properties
     *
     * @return void
     */
    protected function processFile($file, $data, $properties)
    {
        $temporaryFile = isset($data['temp_id'])
            ? \XLite\Core\Database::getRepo('\XLite\Model\TemporaryFile')->find($data['temp_id'])
            : null;

        if (isset($data['delete']) && $data['delete']) {
            if ($file) {
                if ($properties['many']) {
                    $this->{$properties['getter']}()->removeElement($file);

                } else {
                    $this->{$properties['setter']}(null);
                }
                \XLite\Core\Database::getEM()->remove($file);
            }

        } elseif ($temporaryFile) {
            if (!$file) {
                $file = new $properties['entityName'];
                $file->{$properties['mappedSetter']}($this);
                \XLite\Core\Database::getEM()->persist($file);
                $this->{$properties['setter']}($file);
            }

            if ($temporaryFile->isURL()) {
                $file->loadFromURL($temporaryFile->getPath(), false);

            } else {
                $file->loadFromLocalFile(
                    $temporaryFile->getStoragePath(),
                    pathinfo($temporaryFile->getPath(), \PATHINFO_FILENAME)
                    . '.' . pathinfo($temporaryFile->getPath(), \PATHINFO_EXTENSION)
                );
            }
        }

        if ($file) {
            if (isset($data['alt'])) {
                $file->setterProperty('alt', $data['alt']);
            }

            if (isset($data['position'])) {
                $file->setterProperty('orderby', $data['position']);
            }

            if ($file instanceof \XLite\Model\Base\Image) {
                if (!$this->isPersistent()) {
                    $this->update();
                } else {
                    \XLite\Core\Database::getEM()->flush();
                }

                $file->prepareSizes();
            }
        }

        if ($temporaryFile) {
            \XLite\Core\Database::getEM()->remove($temporaryFile);
        }
    }

    /**
     * Clone
     *
     * @return \XLite\Model\AEntity
     */
    public function cloneEntity()
    {
        $class = $this instanceof \Doctrine\ORM\Proxy\Proxy
            ? get_parent_class($this)
            : get_class($this);

        $entity = new $class();

        $fields = $this->getFieldsDefinition($class);
        $map    = array();

        foreach (array_keys($fields) as $field) {
            $map[$field] = $this->$field;
        }

        return $entity->map($map);
    }

    /**
     * Get model fields list
     *
     * @return array
     */
    public function getFieldsDefinition($class = null)
    {
        if (!$class) {
            $class = $this instanceof \Doctrine\ORM\Proxy\Proxy
                ? get_parent_class($this)
                : get_class($this);
        }

        $fields = \XLite\Core\Database::getEM()->getClassMetadata($class)->fieldMappings;

        return $fields;
    }

    /**
     * Since Doctrine lifecycle callbacks do not allow to modify associations, we've added this method
     *
     * @param string $type Type of current operation
     *
     * @return void
     */
    public function prepareEntityBeforeCommit($type)
    {
    }
}

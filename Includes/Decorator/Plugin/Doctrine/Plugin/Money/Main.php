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

namespace Includes\Decorator\Plugin\Doctrine\Plugin\Money;

/**
 * Main 
 *
 */
class Main extends \Includes\Decorator\Plugin\Doctrine\Plugin\APlugin
{
    /**
     * List of <file, code> pairs (code replacements)
     *
     * @var array
     */
    protected $replacements = array();

    /**
     * Autogenerated net getter
     *
     * @var string
     */
    protected $templateGet = <<<CODE
    /**
     * Get <purpose> <fieldName>
     *
     * @return float
     */
    public function get<methodName>()
    {
        return \XLite\Logic\Price::getInstance()->apply(\$this, '<getter>', array(<behaviors>), '<purpose>');
    }
CODE;

    /**
     * Execute certain hook handler
     *
     * @return void
     */
    public function executeHookHandler()
    {
        // It's the metadata collected by Doctrine
        foreach ($this->getMetadata() as $main) {
            $node = static::getClassesTree()->find($main->name);

            // Process only certain classes
            if (!$node->isTopLevelNode() && !$node->isDecorator()) {

                foreach ($main->fieldMappings as $field => $info) {
                    if ('money' == $info['type']) {                        
                        $fieldName = \Includes\Utils\Converter::convertToCamelCase($field);
                        $purposes = array(
                            'net' => '',
                        );
                        $behaviors = array();

                        if (isset($info['options']) && is_array($info['options'])) {
                            foreach ($info['options'] as $option) {
                                if ($option instanceOf \XLite\Core\Doctrine\Annotation\Behavior) {
                                    $behaviors = array_merge($behaviors, $option->list);
    
                                } elseif ($option instanceOf \XLite\Core\Doctrine\Annotation\Purpose) {
                                    $purposes[$option->name] = $option->source;
                                }
                            }
                        }

                        foreach ($purposes as $purpose => $source) {
                            $camelField = ucfirst(\Doctrine\Common\Util\Inflector::camelize($field));
                            $source = $source
                                ? ucfirst($source) . $camelField
                                : $camelField;
                            $this->addReplacement(
                                $main,
                                'get',
                                array(
                                    '<getter>'     => 'get' . $source,
                                    '<fieldName>'  => $fieldName,
                                    '<methodName>' => ucfirst($purpose) . $camelField,
                                    '<behaviors>'  => $behaviors ? '\'' . implode('\',\'', $behaviors) . '\'' : '',
                                    '<purpose>'    => $purpose,
                                )
                            );
                        }
                    }
                }
            }
        }

        // Populate changes
        $this->writeData();
    }

    // {{{ Replacements

    /**
     * Add code to replace
     *
     * @param \Doctrine\ORM\Mapping\ClassMetadata $data        Class metadata
     * @param string                              $template    Template to use
     * @param array                               $substitutes List of entries to substitude
     *
     * @return void
     */
    protected function addReplacement(\Doctrine\ORM\Mapping\ClassMetadata $data, $template, array $substitutes)
    {
        if (!empty($substitutes)) {
            $file = \Includes\Utils\Converter::getClassFile($data->reflClass->getName());

            if (!isset($this->replacements[$file])) {
                $this->replacements[$file] = '';
            }

            $this->replacements[$file] .= $this->substituteTemplate($template, $substitutes) . PHP_EOL . PHP_EOL;
        }
    }

    // }}}

    // {{{ Methods to write changes

    /**
     * Put prepared code into the files
     *
     * @return void
     */
    protected function writeData()
    {
        foreach ($this->replacements as $file => $code) {
            \Includes\Utils\FileManager::write(
                $file = \Includes\Decorator\ADecorator::getCacheClassesDir() . $file,
                \Includes\Decorator\Utils\Tokenizer::addCodeToClassBody($file, $code)
            );
        }
    }

    /**
     * Substitute entries in code template
     *
     * @param string $template Template to prepare
     * @param array  $entries  List of <entry, value> pairs
     *
     * @return string
     */
    protected function substituteTemplate($template, array $entries)
    {
        return str_replace(array_keys($entries), $entries, $this->{'template' . ucfirst($template)});
    }

    // }}}

    // {{{ Auxiliary methods

    /**
     * Alias
     *
     * @param string $class Class name OPTIONAL
     *
     * @return array|\Doctrine\ORM\Mapping\ClassMetadata
     */
    protected function getMetadata($class = null)
    {
        return \Includes\Decorator\Plugin\Doctrine\Utils\EntityManager::getAllMetadata($class);
    }

    // }}}
}

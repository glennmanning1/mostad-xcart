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

namespace XLite\View\Tabs;

/**
 * ATabs is a component allowing you to display multiple widgets as tabs depending
 * on their targets
 */
abstract class AJsTabs extends \XLite\View\AView
{
    /**
     * Information on tab widgets and their targets defined as an array(tab) descriptions:
     *
     *      array(
     *          $target => array(
     *              'weight'    => $weight // Weight of the tab
     *              'title'     => $tabTitle,
     *              'widget'    => $optionalWidgetClass,
     *              'template'  => $optionalWidgetTemplate,
     *          ),
     *          ...
     *      );
     *
     * If a widget class is not specified for a target, the ATabs descendant will be used as the widget class.
     * If a template is not specified for a target, it will be used from the tab widget class.
     *
     * @var array
     */
    protected $tabs = array();

    /**
     * Cached result of the getTabs() method
     *
     * @var array
     */
    protected $processedTabs;

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        foreach ($this->getTabs() as $tab) {
            if (!empty($tab['jsFiles'])) {
                if (is_array($tab['jsFiles'])) {
                    $list = array_merge($list, $tab['jsFiles']);

                } else {
                    $list[] = $tab['jsFiles'];
                }
            }
        }

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        foreach ($this->getTabs() as $tab) {
            if (!empty($tab['cssFiles'])) {
                if (is_array($tab['cssFiles'])) {
                    $list = array_merge($list, $tab['cssFiles']);

                } else {
                    $list[] = $tab['cssFiles'];
                }
            }
        }

        return $list;
    }

    /**
     * Checks whether no widget class is specified for the selected tab
     *
     * @param array $tab Tab
     *
     * @return boolean
     */
    public function isTemplateOnlyTab($tab)
    {
        return empty($tab['widget']) && !empty($tab['template']);
    }

    /**
     * Checks whether both a template and a widget class are specified for the selected tab
     *
     * @param array $tab Tab
     *
     * @return boolean
     */
    public function isFullWidgetTab($tab)
    {
        return !empty($tab['widget']) && !empty($tab['template']);
    }

    /**
     * Checks whether no template is specified for the selected tab
     *
     * @param array $tab Tab
     *
     * @return boolean
     */
    public function isWidgetOnlyTab($tab)
    {
        return !empty($tab['widget']) && empty($tab['template']);
    }

    /**
     * Returns a widget class name for the selected tab
     *
     * @param array $tab Tab
     *
     * @return string
     */
    public function getTabWidget($tab)
    {
        return isset($tab['widget']) ? $tab['widget'] : '';
    }

    /**
     * Returns a template name for the selected tab
     *
     * @param array $tab Tab
     *
     * @return string
     */
    public function getTabTemplate($tab)
    {
        return isset($tab['template']) ? $tab['template'] : '';
    }

    /**
     * Checks whether no template is specified for the selected tab
     *
     * @param array $tab Tab
     *
     * @return boolean
     */
    public function isCommonTab($tab)
    {
        return empty($tab['widget']) && empty($tab['template']);
    }

    /**
     * Flag: display (true) or hide (false) tabs
     *
     * @return boolean
     */
    protected function isWrapperVisible()
    {
        return true;
    }

    /**
     * Returns the default widget template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'common/js_tabs.tpl';
    }

    /**
     * Returns the current target
     *
     * @return string
     */
    protected function getCurrentTarget()
    {
        return \XLite\Core\Request::getInstance()->target;
    }

    /**
     * Checks whether the tabs navigation is visible, or not
     *
     * @return boolean
     */
    protected function isTabsNavigationVisible()
    {
        return 1 < count($this->getTabs());
    }

    /**
     * Returns tab URL
     *
     * @param string $name Tab name
     *
     * @return string
     */
    protected function buildTabURL($name)
    {
        return $this->buildURL(\XLite\Core\Request::getInstance()->target) . '#' . $name;
    }

    /**
     * Checks whether a tab is selected
     *
     * @param string $target Tab target
     *
     * @return boolean
     */
    protected function isSelectedTab($target)
    {
        return ($target === $this->getCurrentTarget());
    }

    /**
     * Returns default values for a tab description
     *
     * @return array
     */
    protected function getDefaultTabValues()
    {
        return array(
            'title'     => '',
            'widget'    => '',
            'template'  => '',
        );
    }

    /**
     * Sorting the tabs according their weight
     *
     * @return array
     */
    protected function prepareTabs()
    {
        $tabs = $this->tabs;
        // Manage the omitted weights of tabs
        $index = 1;
        foreach ($tabs as $target => $tab) {
            if (!isset($tab['weight'])) {
                $tabs[$target]['weight'] = $index;
            }
            $index++;
        }
        // Sort the tabs via compareTabs method
        uasort($tabs, array($this, 'compareTabs'));
        return $tabs;
    }
    
    /**
     * This method is used for comparing tabs
     * By default they are compared according their weight
     *
     * @param array $tab1
     * @param array $tab2
     *
     * @return boolean
     */
    public function compareTabs($tab1, $tab2)
    {
        return $tab1['weight'] > $tab2['weight'];
    }
    

    /**
     * Returns an array(tab) descriptions
     *
     * @return array
     */
    protected function getTabs()
    {
        // Process tabs only once
        if (null === $this->processedTabs) {
            $this->processedTabs = array();
            $defaultValues = $this->getDefaultTabValues();

            foreach ($this->prepareTabs() as $target => $tab) {
                $tab['selected'] = $this->isSelectedTab($target);
                $tab['url'] = $this->buildTabURL($target);

                // Set default values for missing tab parameters
                $tab += $defaultValues;

                $this->processedTabs[$target] = $tab;
            }

        }

        return $this->processedTabs;
    }

    /**
     * getTitle
     *
     * @return string
     */
    protected function getTitle()
    {
        return null;
    }
}

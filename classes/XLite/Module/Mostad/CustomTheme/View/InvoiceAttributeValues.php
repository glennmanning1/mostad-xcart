<?php


namespace XLite\Module\Mostad\CustomTheme\View;


class InvoiceAttributeValues extends \XLite\View\InvoiceAttributeValues implements \XLite\Base\IDecorator
{

    /**
     * Get attribute value to display with order item
     *
     * @return string
     */
    protected function getDisplayOptionValues()
    {
        $result = array();

        foreach ($this->getParam(self::PARAM_ITEM)->getAttributeValues() as $av) {
            $result[] = $av->getName().": ".$av->getValue();
        }

        return implode(' / ', $result);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 2/29/16
 * Time: 4:01 PM
 */

namespace XLite\Module\Mostad\CustomTheme\Controller\Customer;


abstract class ACustomer extends \XLite\Controller\Customer\ACustomer implements \XLite\Base\IDecorator
{
    const TEMPLATE_PATH = 'modules/Mostad/CustomTheme/categoryListingTemplate/';

    const DEFAULT_TEMPLATE = 'center.tpl';

    public function getListingTemplate()
    {

        if (method_exists($this, 'getCategory') && $this->getCategory()) {
            $template = $this->getCategory()->getListingTemplate();

            if (!empty($template) && $template !== self::DEFAULT_TEMPLATE) {
                return self::TEMPLATE_PATH . $template;
            }
        }

        return self::DEFAULT_TEMPLATE;
    }

}
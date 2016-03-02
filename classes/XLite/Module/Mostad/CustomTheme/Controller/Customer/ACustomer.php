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

    public function getListingTemplate()
    {

        if (function_exists('getCategory')) {
            $template = $this->getCategory()->getListingTemplate();

            if ($template) {
                return self::TEMPLATE_PATH . $template;
            }
        }

        return 'center.tpl';
    }

}
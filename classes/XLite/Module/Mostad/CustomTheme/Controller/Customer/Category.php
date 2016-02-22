<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 2/18/16
 * Time: 6:20 PM
 */

namespace XLite\Module\Mostad\CustomTheme\Controller\Customer;


abstract class Category extends \XLite\Controller\Customer\Category implements \XLite\Base\IDecorator
{

    const TEMPLATE_PATH = 'modules/Mostad/CustomTheme/categoryListingTemplate/';

    public function getListingTemplate()
    {
        $template = $this->getCategory()->getListingTemplate();

        if (empty($template)) {
            return 'center.tpl';
        }

        return self::TEMPLATE_PATH . $template;
    }

}
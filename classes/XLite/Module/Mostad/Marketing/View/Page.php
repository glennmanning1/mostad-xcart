<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 1/26/16
 * Time: 4:03 PM
 */

namespace XLite\Module\Mostad\Marketing\View;


class Page extends \XLite\Module\CDev\SimpleCMS\View\Page implements \XLite\Base\IDecorator
{

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
//        if ($this->isDisableLayout()) {
//            return 'modules/Mostad/Marketing/page/body.tpl';
//        }
        return 'modules/CDev/SimpleCMS/page/body.tpl';
    }

}
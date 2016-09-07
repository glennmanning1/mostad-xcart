<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 9/7/16
 * Time: 4:29 PM
 */

namespace XLite\Module\Mostad\CustomTheme\View;


class TopCategories extends \XLite\View\TopCategories implements \XLite\Base\IDecorator
{

    /**
     * Get widge title
     *
     * @return string
     */
    protected function getHead()
    {
        return 'Products';
    }

}
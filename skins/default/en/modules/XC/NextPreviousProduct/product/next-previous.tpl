{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Next previous product links
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="next-previous-product">
    <div>
        <div IF="isPreviousAvailable()" class="next-previous-link">
            <widget
                template="modules/XC/NextPreviousProduct/product/parts/body.tpl"
                next="{0}"
                item="{previousItem}"
                dataString="{getDataStringPrevious())}"
            />
        </div>
        <span IF="isShowSeparator()" class="next-previous-separator">|</span>
        <div IF="isNextAvailable()" class="next-previous-link">
            <widget
                template="modules/XC/NextPreviousProduct/product/parts/body.tpl"
                next="{1}"
                item="{nextItem}"
                dataString="{getDataStringNext())}"
            />
        </div>
    </div>
</div>

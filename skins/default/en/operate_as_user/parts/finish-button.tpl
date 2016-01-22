{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Finish button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="operate_as_user", weight="40")
 *}
<widget
    class="\XLite\View\Button\Link"
    location="{getFinishOperateAsUrl()}"
    style='finish-button btn-sm'
    label='Quit'
    disabled='false'
/>
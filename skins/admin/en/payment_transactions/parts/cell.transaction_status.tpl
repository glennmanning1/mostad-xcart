{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment status cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="plain-value">
    <span class="value">{getHumanStatus(entity.status)}</span>
</div>
<div IF="isTransactionStatusPopoverVisible(entity)" class="details">
    <widget
        class="\XLite\View\Tooltip"
        text="{getTransactionStatusPopoverContent(entity)}"
        entityTest="{entity}"
        caption="{getTransactionStatusPopoverTitle():h}"
        isImageTag="false"
        placement="left"
        className="help" />
</div>

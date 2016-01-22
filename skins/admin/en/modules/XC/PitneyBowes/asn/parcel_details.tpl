{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Create ASN form
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="{getClass()}">
    {displayCommentedData(getURLParams())}
    <ul IF="!isParcelEmpty()">
        <li foreach="entity.getParcelItems(),parcelItem">
            <span>{parcelItem.orderItem.getName()} - {parcelItem.getAmount()}</span>
        </li>
    </ul>
    <div IF="isParcelEmpty()">
        {t(#No items found.#)}
    </div>
</div>

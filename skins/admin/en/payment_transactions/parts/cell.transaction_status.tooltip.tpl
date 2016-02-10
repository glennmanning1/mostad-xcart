{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment status cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<span class="tooltip-title">{t(#Transactions details#)}</span>
<div class="tooltip-content">
    <ul>
        <li FOREACH="entity.getTransactionData(),dataCell" class="data-cell">
            <span class="data-cell-title">{t(dataCell.getLabel())}</span>
            <span class="data-cell-value">{getCellValue(dataCell):h}</span>
        </li>
    </ul>
</div>

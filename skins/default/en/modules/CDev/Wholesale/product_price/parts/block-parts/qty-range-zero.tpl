{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Wholesale prices table
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="wholesale.price.widgetlist", weight="20")
 *}

<td IF="wholesalePrice.getQuantityRangeEnd()=0">
  <span class="items-range">{wholesalePrice.getQuantityRangeBegin()}</span>
  <span class="items-label">{t(#or more items#)}</span>
</td>

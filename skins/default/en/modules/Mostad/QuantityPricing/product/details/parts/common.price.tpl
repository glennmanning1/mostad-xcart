{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product price
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.details.page.info", weight="40")
 * @ListChild (list="product.details.quicklook.info", weight="40")
 *}
{if:!hasQuantityPrices()}
<widget class="\XLite\View\Price" product="{product}" />
{end:}
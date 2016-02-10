{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product low stock label
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.product.grid.customer.info", weight="31")
 * @ListChild (list="itemsList.product.list.customer.info", weight="2000")
 *}

<span IF="product.isShowStockWarning()" class="product-items-available low-stock">{t(#Only X left in stock#,_ARRAY_(#X#^product.getAvailableAmount()))}</span>

{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Item thumbnail
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.product.list.customer.photo", weight="10")
 *}
<a 
  href="{getProductURL(product,categoryId)}"
  class="product-thumbnail">
  <widget 
    class="\XLite\View\Image" 
    image="{product.getImage()}" 
    maxWidth="{getIconWidth()}" 
    maxHeight="{getIconHeight()}" 
    alt="{product.name}" 
    verticalAlign="top" 
    className="photo" />
</a>

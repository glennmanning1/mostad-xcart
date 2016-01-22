{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Gallery widget
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="product-image-gallery"{if:isVisibleAsHidden()} style="display:none;"{end:}>
  <ul>
    {foreach:product.getPublicImages(),i,image}
    <li {printTagAttributes(getListItemClassAttribute(i,image)):h}>
      <a href="{image.getFrontURL()}" rel="lightbox" rev="width: {image.getWidth()}, height: {image.getHeight()}" title="{image.getAlt()}"><widget class="\XLite\View\Image" image="{image}" alt="{getAlt(image, i)}" maxWidth="60" maxHeight="60" /></a>
      <widget class="\XLite\View\Image" className="middle" style="display: none;" image="{image}" maxWidth="{getWidgetMaxWidth()}" maxHeight="{getWidgetMaxHeight()}" alt="{getAlt(image, i)}" />
    </li>
    {end:}
  </ul>
</div>

<script type="text/javascript">
var lightBoxImagesDir = '{getLightBoxImagesDir()}';
</script>

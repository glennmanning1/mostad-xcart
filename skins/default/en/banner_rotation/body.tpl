{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Banner rotation widget template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div id="banner-rotation-widget" class="carousel slide banner-carousel">
  {displayCommentedData(getCommentedData())}

  <!-- Indicators -->
  <ol class="carousel-indicators" IF="{isRotationEnabled()}">
    {foreach:getImages(),i,image}
      <li data-target="#banner-rotation-widget" data-slide-to="{i}"></li>
    {end:}
  </ol>

  <div class="carousel-inner" role="listbox">
    {foreach:getImages(),image}
      <a href="{image.bannerRotationSlide.getLink()}" class="item">
        <img src="{image.getFrontURL()}" alt="{image.getAlt()}" >
      </a>
    {end:}
  </div>
</div>

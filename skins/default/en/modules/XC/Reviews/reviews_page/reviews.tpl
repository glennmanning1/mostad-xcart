{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Reviews list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="reviews")
 *}

<div class="reviews">

  <ul class="reviews-list" IF="getPageData()">
    <li FOREACH="getPageData(),review" class="{getClass(review)}">
      <list name="reviews.review" review="{review}" />
    </li>
  </ul>

</div>

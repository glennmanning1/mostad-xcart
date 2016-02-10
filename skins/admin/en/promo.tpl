{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Banner images list & upload
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div IF="isPromoBlockVisible(promoId)" class="promo-block {promoId}-promo" data-promo-id="{promoId}">
  <div class="promo-content">{promoContent:h}</div>
  <div class="close">{displaySVGImage(#images/icon-close-round.svg#)}</div>
</div>

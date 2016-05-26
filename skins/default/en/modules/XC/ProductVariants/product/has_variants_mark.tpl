{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product details image block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.details.quicklook.image", weight="10")
 *}
<div IF="product"
    class="has-variants-mark"
    data-value="{product.hasVariants()}"
    style="display: none;">
</div>


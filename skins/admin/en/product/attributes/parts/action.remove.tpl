{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Add offline method
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.attributes.actions", weight="10")
 *}

<div IF="isRemovable()" class="actions">
	<widget class="XLite\View\Button\Remove" buttonName="delete[{itemId}]" label="{getPemoveText()}" style="delete" />
</div>
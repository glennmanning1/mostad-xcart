{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Horizontal minicart checkout button block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="minicart.horizontal.buttons", weight="10")
 *}
<widget IF="cart.checkCart()" class="\XLite\View\Button\SimpleLink" label="Checkout" location="{buildURL(#checkout#)}" style="regular-main-button checkout" />
<widget IF="!cart.checkCart()" class="\XLite\View\Button\SimpleLink" label="Checkout" location="{buildURL(#checkout#)}" style="regular-main-button checkout" disabled="true" />

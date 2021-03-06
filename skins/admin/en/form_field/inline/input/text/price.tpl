{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Price inline view
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<span class="symbol" IF="currency.getPrefix()">{currency.getPrefix():h}</span>
<span class="value">{getViewValue(singleField):h}</span>
<span class="symbol" IF="currency.getSuffix()">{currency.getSuffix():h}</span>


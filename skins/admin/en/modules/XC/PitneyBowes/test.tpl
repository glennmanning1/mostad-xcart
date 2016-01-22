{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Test rates page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:isCatalogExported()}
<widget class="XLite\Module\XC\PitneyBowes\View\Model\TestRates" />
{else:}
<p class="rates-unavailable"> {t(#Test rates are unavailable. You have to make at least one approved catalog extraction to be able to get shipping rates.#)}</p>
{end:}
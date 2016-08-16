{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Promo block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2016 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="crud.modulesettings.formHeader", zone="admin", weight="50")
 *}

<widget IF="#CDev\GoogleAnalytics#=module.getActualName()" template="promo.tpl" promoId="ga-promo" promoContent="{t(#Want help with SEO? Ask X-Cart Guru#,_ARRAY_(#url#^getSeoPromoURL()))}" />

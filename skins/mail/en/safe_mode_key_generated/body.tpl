{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Safe mode key generated email body (to admin)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
{if:keyChanged}
<p>{t(#New access codes were generated.#)}</p>
{end:}

<p>{t(#You need these links in case you want to recover your store#,_ARRAY_(#article#^article_url)):h}</p>

{if:current_snapshot_url}
<p>{t(#Restores to current state of active addons (use in case of emergency)#)}:</p>
<p>{current_snapshot_url}</p>
{end:}

<p>{t(#Disables all addons except ones that are provided by X-Cart Team & Qualiteam (soft reset)#)}:</p>
<p>{soft_reset_url}</p>

<p>{t(#Disables all addons except ones that are provided by X-Cart Team (hard reset)#)}:</p>
<p>{hard_reset_url}</p>

<p>{t(#More info is available in X-Cart's Knowledge Base article 'What to do if you cannot access your store...'#,_ARRAY_(#article#^article_url)):h}</p>
  
{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * If entry disabled or enabled
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.prepare.entries_list_update.sections.table.columns", weight="200")
 *}

{if:entry.isEnabled()}
  <td class="status">&nbsp;</td>
{else:}
  <td IF="entry.isInstalled()" class="status disabled">{t(#Now disabled#)}</td>
  <td IF="!entry.isInstalled()" class="status not-installed">{t(#Will be installed#)}</td>
{end:}

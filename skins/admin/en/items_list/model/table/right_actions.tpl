{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Right actions
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="separator"></div>
<div FOREACH="getRightActions(),tpl" class="{getActionCellClass(i,tpl)}"><widget template="{tpl:h}" /></div>

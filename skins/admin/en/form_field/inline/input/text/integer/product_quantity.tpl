{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product quantity
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:entity.inventory.getEnabled()}
  <widget template="form_field/inline/view.tpl" />
{else:}
  &infin;
{end:}

{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Register form template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<list name="customer.order_list.before" />

<widget target="order_list" class="\XLite\View\Tabber" body="{pageTemplate}" switch="page" />

<list name="customer.order_list.after" />

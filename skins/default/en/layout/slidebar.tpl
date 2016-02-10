{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Slidebar
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 *}

<nav id="slidebar">
    <ul>
        <li class="slidebar-categories">
            <span data-toggle="dropdown">{t(#Categories#)}</span>
            <list name="layout.header.categories" />
        </li>
        <list name="header.menu" />
    </ul>
</nav>
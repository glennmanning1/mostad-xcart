{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Next product links
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="next_previous.product.body.dropdown", weight="100")
 *}

<p class="next-previous-image">
    <a href="{getItemURL(item)}">
        <widget
            class="\XLite\View\Image"
            image="{item.getImage()}"
            maxWidth="{getIconWidth()}"
            maxHeight="{getIconHeight()}"
            alt="{item.name}"
            className="photo" />
    </a>
</p>

{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product price value
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/ License Agreement
 * @link      http://novahorizons.io/
 *
 *}

{if:getBlogData()}
<div class="blog-content">
    <h2>From Our Blog</h2>
    <ul>
        {foreach:getBlogData(),key,value}
        <li>
            <div class="blog-date-icon">{value.getMonth()} {value.getDay()}</div>
            <div class="blog-blurb">{value.getTitle()}</div>
            <div class="blog-link"><a href="{value.getLink()}">Read article</a></div>
        </li>
        {end:}
    </ul>
</div>
{end:}
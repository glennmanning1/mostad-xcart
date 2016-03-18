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
<section id="recent-blogs">
    <h2>From Our Blog</h2>
    <ul>
        {foreach:getBlogData(),key,value}
        <li>
            <div class="date">{value.getMonth()} <b>{value.getDay()}</b></div>
            <div class="details">
                {value.getTitle()}<br />
                <a href="{value.getLink()}" target="_blank">Read article</a>
            </div>
            <div class="blog-link"></div>
        </li>
        {end:}
    </ul>
</div>
{end:}
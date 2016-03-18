{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/ License Agreement
 * @link      http://novahorizons.io/
*}

{if:getProductClassName()}
    {getProductClassName()}
{else:}
    {getDefaultText()}
{end:}
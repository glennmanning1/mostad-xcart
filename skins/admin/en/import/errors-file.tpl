{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Errors file template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
{foreach:getFiles(),file}
{file.file} - {getMessageType(#E#)}: {file.countE} - {getMessageType(#W#)}: {file.countW}{getEOL():h}
{foreach:getMessagesGroups(file.file),type,messageGroup}
{if:messageGroup}
{getEOL():h}
{getMessageType(type)}{getEOL():h}
{foreach:messageGroup,type,errorGroup}
{getGroupErrorMessage(errorGroup):h} ({getErrorText(errorGroup)}) - {getGroupErrorRows(errorGroup)}{getEOL():h}
{end:}
{end:}
{end:}
{end:}

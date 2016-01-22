{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Common layout
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<!DOCTYPE html>
<html lang="{currentLanguage.getCode()}"{foreach:getHTMLAttributes(),k,v} {k}="{v}"{end:}>
  <widget class="\XLite\View\Header" />
<body {if:getBodyClass()}class="{getBodyClass()}"{end:}>
{displayCommentedData(getCommonJSData()):s}
<list name="body" />
{**
 * Please note that any custom list child of 'body' will NOT have its CSS/JS resources loaded because the resources block is being 'body' child itself. Use 'layout.main' or 'layout.footer' instead.
 *}
</body>
</html>

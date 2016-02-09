{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
*}
<span class="input-field-wrapper {getWrapperClass()}">
  {displayCommentedData(getCommentedData())}
  <input{getAttributesCode():h} />
  <br />
  If you do not have seller account, you can register here:<br />
  <a href="https://payments.amazon.com/signup?LD=SPEXUSAPA_XCart_core" target="_blank">USA</a>,&nbsp;
  <a href="https://payments.amazon.co.uk/preregistration/lpa?LD=SPEXUKAPA_XCart_core" target="_blank">UK</a>,&nbsp;
  <a href="https://payments.amazon.de/preregistration/lpa?LD=SPEXDEAPA_XCart_core" target="_blank">Germany</a>
</span>

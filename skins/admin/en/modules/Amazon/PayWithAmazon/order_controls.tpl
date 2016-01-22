{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.operations", weight="105")
*}
{if:isAmazonControlsVisible()}

  <h2>{t(#PayWithAmazon available actions#)}</h2>

  <script type="text/javascript">
    //<![CDATA[
    var lbl_amazon_pa_confirm_capture = '{t(#This operation will capture funds from customer. Please confirm to proceed.#)}';
    var lbl_amazon_pa_confirm_void = '{t(#This operation will cancel order. Payment authorization will be voided. Please confirm to proceed.#)}';
    var lbl_amazon_pa_confirm_refund = '{t(#This operation will refund funds to customer. Please confirm to proceed.#)}';

    function amz_submit_form(formObj, formMode) {getLdelim()}
      if (!formObj)
        return false;

      if (formObj.tagName != "FORM") {getLdelim()}
        if (!formObj.form)
          return false;
        formObj = formObj.form;
      {getRdelim()}

      if (formObj.action) 
        formObj.action.value = formMode;

      return formObj.submit();
    {getRdelim()}
    //]]>
  </script>

  {t(#Amazon Order Ref ID#)}: <b>{getOrderDetail(#AmazonOrderReferenceId#)}</b>

  <table>
  <tr>

  {if:isCaptureButtonVisible()}
  <td>
    {if:order.getDetail(#amazon_pa_capture_status#)}
      {t(#Capture status#)}: <b>{getOrderDetail(#amazon_pa_capture_status#)}</b>
    {else:}
      <input type="button" value="{t(#Capture#)}" onclick="javascript: if(confirm(lbl_amazon_pa_confirm_capture)) amz_submit_form(this, 'amz_capture');" />&nbsp;
    {end:}
  </td>

  <td>
    <input type="button" value="{t(#Void#)}" onclick="javascript: if(confirm(lbl_amazon_pa_confirm_void)) amz_submit_form(this, 'amz_void');" />
  </td>
  {end:}

  {if:isRefundButtonVisible()}
  <td>
    {if:order.getDetail(#amazon_pa_refund_status#)}
      {t(#Refund status#)}: <b>{getOrderDetail(#amazon_pa_refund_status#)}</b>
      <br />
      <input type="button" value="{t(#Refresh status#)}" onclick="javascript: amz_submit_form(this, 'amz_refresh_refund_status');" />
    {else:}
      <input type="button" value="{t(#Refund#)}" onclick="javascript: if(confirm(lbl_amazon_pa_confirm_refund)) amz_submit_form(this, 'amz_refund');" />
    {end:}
  </td>
  {end:}

  {if:isRefreshButtonVisible()}
  <td>
    <input type="button" value="{t(#Refresh status#)}" onclick="javascript: amz_submit_form(this, 'amz_refresh');" />
  </td>
  {end:}

  </tr>

  </table>
  <br >
  <br />
{end:}

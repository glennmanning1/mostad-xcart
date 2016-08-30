{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Create profile checkbox
 *}

<p class="subbox subnote create-warning">
  {t(#There is already an account with your email address. You can sign in or continue as guest#,_ARRAY_(#URL#^buildURL(#login#))):h}
</p>

<div class="subbox create checkbox">
  <label>
    <input type="checkbox" id="create_profile" name="create_profile" value="1" checked="{isCreateProfile()}" />
    {t(#Create an account to track the status of this order and easily reorder items in the future#)}
  </label>
</div>

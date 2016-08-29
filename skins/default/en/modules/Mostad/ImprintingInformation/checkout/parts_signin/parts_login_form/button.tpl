{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Sign-in
 * @ListChild (list="checkout.signin.form", weight="30")
 *}
<tr><td class="sign-in-button">
  <widget class="\XLite\View\Button\Submit" label="{t(#Sign in#)}" button-type="btn-primary" />
  <list name="customer.signin.popup.links" />
</td></tr>

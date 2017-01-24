{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shipping address : create profile checkbox
 * @ListChild (list="checkout.shipping.address.email", weight="100")
 *}

<widget IF="isAnonymous()" template="modules/Mostad/ImprintingInformation/checkout/steps/shipping/parts/address.create.tpl" />

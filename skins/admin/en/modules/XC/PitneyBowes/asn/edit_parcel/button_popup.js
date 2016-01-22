/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Add payment method JS controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function PopupButtonEditParcel()
{
  PopupButtonEditParcel.superclass.constructor.apply(this, arguments);
}

extend(PopupButtonEditParcel, PopupButton);

PopupButtonEditParcel.prototype.pattern = '.edit-parcel-button.editable';

core.autoload(PopupButtonEditParcel);

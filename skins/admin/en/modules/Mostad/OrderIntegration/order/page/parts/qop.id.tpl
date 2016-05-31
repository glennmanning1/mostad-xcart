{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order: QOP ID
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2016 Nova Horizons LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/x-cart/license License Agreement
 * @link      http://novahorizons.io/
 *
 * @ListChild (list="order.operations", weight="50")
 *}

<div class="order-note staff-note">
    <div class="order-note-box">
        <h2>QOP Order ID</h2>
        <label for="qopOrderId">
            <input type="text" id="qopOrderId" name="qopOrderId" value="{order.getQopOrderId()}" class="not-affect-recalculate form-control"/>
        </label>
    </div>
</div>

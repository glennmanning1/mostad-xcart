{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Imprinting page template
 *  
 * @author    Creative Development LLC <info@cdev.ru> 
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 *}
<div id="imprinting-form" class="container-fluid">
    <div class="row header">
        <div class="col-md-12">
            <h3>Imprint and Display Information:</h3>
        </div>
    </div>
    <widget class="XLite\Module\Mostad\ImprintingInformation\View\Form\Model\Imprinting" name="imprinting_information"/>
        <widget name="imprinting_model" class="XLite\Module\Mostad\ImprintingInformation\View\Model\Imprinting"/>
    <widget name="imprinting_information" end/>
</div>

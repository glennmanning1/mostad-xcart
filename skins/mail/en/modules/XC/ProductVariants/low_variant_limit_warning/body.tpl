{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Low limit warning email body (to admin)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<p>
  {getNotificationText():h}
</p>
<p>
  {t(#SKU#)}: {data.sku}<br />
  {t(#Product name#)}: {data.name}<br />
  {t(#Attributes#)}<br />
  <ul>
    <li FOREACH="data.attributes,av">
        {av.name}: <span>{av.value}</span>
    </li>
  </ul>
  <br />
  {t(#In stock#)}: {t(#X items#,_ARRAY_(#count#^data.amount))}
</p>
<p>
  {t(#Click the link to increase variant amount#):h}: <a href="{data.variantsTabUrl}">{data.variantsTabUrl}</a>
</p>

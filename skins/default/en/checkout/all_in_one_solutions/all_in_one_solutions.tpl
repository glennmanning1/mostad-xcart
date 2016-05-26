{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * All in one soulitions checkout block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="all-in-one-solutions-wrapper">
  <div class="all-in-one-solutions">
    <div class="all-in-one-solutions-header-block">
      <list name="all-in-one-solutions.header"/>
    </div>
    <span FOREACH="getSolutions(),solution" class="single-solution">
      {solution.display()}
    </span>
  </div>
  <div class="all-in-one-solutions-delimiter">
    {t(#or use the form below#)}
  </div>
</div>

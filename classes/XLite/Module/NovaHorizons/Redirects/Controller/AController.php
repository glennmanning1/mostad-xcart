<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Nova Horizons
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  X-Cart 5
 * @author    Nova Horizons LLC <xcart@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horizons LLC <xcart@novahorizons.io>. All rights reserved
 * @license   https://novahorizons.io/x-cart/license License Agreement
 * @link      https://novahorizons.io/
 */

namespace XLite\Module\NovaHorizons\Redirects\Controller;

/**
 * Abstract controller
 */
abstract class AController extends \XLite\Controller\AController implements \XLite\Base\IDecorator
{

    protected function display404()
    {
        $this->checkForNovaRedirect();

        parent::display404();
    }

    protected function checkForNovaRedirect()
    {
        $source = $_SERVER['REQUEST_URI'];

        $result = \XLite\Core\Database::getRepo('\XLite\Module\NovaHorizons\Redirects\Model\Redirect')->findBy(
                array('target' => $source, 'enabled' => 1),
                null,
                1
        )
        ;

        if (!empty($result)) {
            $path = $result[0]->getPath();

            $this->setWidgetParams(array(
                                           static::PARAM_REDIRECT_CODE => 301,
                                   )
            );
            $this->redirect($path);
        }
    }

}

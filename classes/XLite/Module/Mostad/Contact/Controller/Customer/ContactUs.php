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
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/x-cart/license License Agreement
 * @link      http://novahorizons.io/
 */

namespace XLite\Module\Mostad\Contact\Controller\Customer;


class ContactUs extends \XLite\Module\CDev\ContactUs\Controller\Customer\ContactUs implements \XLite\Base\IDecorator
{

    /**
     * Send message
     *
     * @return void
     */
    protected function doActionSend()
    {
        $data = \XLite\Core\Request::getInstance()->getData();
        $config = \XLite\Core\Config::getInstance()->CDev->ContactUs;
        $isValid = true;

        foreach ($this->requiredFields as $key => $name) {
            if (
                !isset($data[$key])
                || empty($data[$key])
            ) {
                $isValid = false;
                \XLite\Core\TopMessage::addError(
                    static::t('The X field is empty', array('name' => $name))
                );
            }
        }

        if (
            $isValid
            && false === filter_var($data['email'], FILTER_VALIDATE_EMAIL)
        ) {
            $isValid = false;
            \XLite\Core\TopMessage::addError(
                \XLite\Core\Translation::lbl(
                    'The value of the X field has an incorrect format',
                    array('name' => $this->requiredFields['email'])
                )
            );
        }

        if (
            $isValid
            && $config->recaptcha_private_key
            && $config->recaptcha_public_key
        ) {

            if (isset($data['g-recaptcha-response'])) {
                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $postData = 'secret='.$config->recaptcha_private_key.'&response=' .$data['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR'];
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $result = curl_exec($ch);

                curl_close($ch);

                $result = json_decode($result);

                if (!$result->success) {
                    $isValid = false;
                }

            } else {
                $isValid = false;
            }


            if (!$isValid) {
                \XLite\Core\TopMessage::addError('Please enter the correct captcha');
            }
        }

        if ($isValid) {
            $errorMessage = \XLite\Core\Mailer::sendContactUsMessage(
                $data,
                \XLite\Core\Config::getInstance()->CDev->ContactUs->email
                    ?: \XLite\Core\Config::getInstance()->Company->support_department
            );

            if ($errorMessage) {
                \XLite\Core\TopMessage::addError($errorMessage);

            } else {
                unset($data['message']);
                unset($data['subject']);
                \XLite\Core\TopMessage::addInfo('Message has been sent');
            }
        }

        \XLite\Core\Session::getInstance()->contact_us = $data;
    }

}
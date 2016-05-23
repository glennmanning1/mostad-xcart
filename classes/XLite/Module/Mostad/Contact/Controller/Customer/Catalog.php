<?php

namespace XLite\Module\Mostad\Contact\Controller\Customer;

class Catalog extends \XLite\Controller\Customer\ACustomer
{

    /**
     * Fields
     *
     * @var   array
     */
    protected $requiredFields = array(
            'name'  => 'Your name',
            'email' => 'Your e-mail',
    );

    public function getTitle()
    {
        return static::t('Catalog Request');
    }

    /**
     * Return value of data
     *
     * @param string $field Field
     *
     * @return string
     */
    public function getValue($field)
    {
        $data = \XLite\Core\Session::getInstance()->catalog_request;

        $value = $data && isset($data[$field]) ? $data[$field] : '';

        if (
                !$value
                && in_array($field, array('name', 'email'))
        ) {
            $auth = \XLite\Core\Auth::getInstance();
            if ($auth->isLogged()) {
                if ('email' == $field) {
                    $value = $auth->getProfile()->getLogin();

                } elseif (0 < $auth->getProfile()->getAddresses()->count()) {
                    $value = $auth->getProfile()->getAddresses()->first()->getName();
                }
            }
        }

        return $value;
    }

    /**
     * Send message
     *
     * @return void
     */
    protected function doActionSend()
    {
        $data    = \XLite\Core\Request::getInstance()->getData();
        $config  = \XLite\Core\Config::getInstance()->CDev->ContactUs;
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
            require_once LC_DIR_MODULES . '/CDev/ContactUs/recaptcha/recaptchalib.php';

            $resp = recaptcha_check_answer(
                    $config->recaptcha_private_key,
                    $_SERVER['REMOTE_ADDR'],
                    $data['recaptcha_challenge_field'],
                    $data['recaptcha_response_field']
            );

            $isValid = $resp->is_valid;

            if (!$isValid) {
                \XLite\Core\TopMessage::addError('Please enter the correct captcha');
            }
        }

        if ($isValid) {
            $errorMessage = \XLite\Core\Mailer::sendCatalogRequestMessage(
                    $data,
                    \XLite\Core\Config::getInstance()->CDev->ContactUs->email
                            ?: \XLite\Core\Config::getInstance()->Company->support_department
            );

            if ($errorMessage) {
                \XLite\Core\TopMessage::addError($errorMessage);

            } else {
                unset($data['message']);
                \XLite\Core\TopMessage::addInfo('Message has been sent');
            }
        }

        \XLite\Core\Session::getInstance()->custom_service_contact = $data;
    }
}
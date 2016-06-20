<?php

namespace XLite\Module\Mostad\Contact\View\Page\Customer;

/**
 * Design page view
 *
 * @ListChild (list="center")
 */
class Contact extends \XLite\View\AView
{

    const TARGET = 'contact';

    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(parent::getAllowedTargets(), array(self::TARGET));
    }

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/CDev/ContactUs/contact_us/style.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/Mostad/Contact/contact/body.tpl';
    }

    protected function getCaptcha()
    {
        $config = \XLite\Core\Config::getInstance()->CDev->ContactUs;
        $result = '';

        if (
            $config->recaptcha_private_key
            && $config->recaptcha_public_key
        ) {
            $result = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>'
                      . "\n"
                      . '<div class="g-recaptcha" data-sitekey="'.$config->recaptcha_public_key.'"></div>';
        }

        return $result;
    }
}
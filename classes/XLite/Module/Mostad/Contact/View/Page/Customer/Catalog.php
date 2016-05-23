<?php

namespace XLite\Module\Mostad\Contact\View\Page\Customer;

/**
 * Design page view
 *
 * @ListChild (list="center")
 */
class Catalog extends \XLite\View\AView
{

    const TARGET = 'catalog';

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
        return 'modules/Mostad/Contact/catalog/body.tpl';
    }

    /**
     * Return captcha
     *
     * @return string
     */
    protected function getCaptcha()
    {
        $config = \XLite\Core\Config::getInstance()->CDev->ContactUs;
        $result = '';

        if (
            $config->recaptcha_private_key
            && $config->recaptcha_public_key
        ) {
            require_once LC_DIR_MODULES . '/CDev/ContactUs/recaptcha/recaptchalib.php';
            $result = recaptcha_get_html($config->recaptcha_public_key);
        }

        return $result;
    }
}
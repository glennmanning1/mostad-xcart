<?php
/**
 * @author Phillip
 */

namespace XLite\Module\Mostad\Contact\View\Form;
use XLite\Module\Mostad\Contact\View\Page\Customer\Contact;

/**
 * Contact us form
 */
class ContactForm extends \XLite\View\Form\AForm
{
    /**
     * Return default value for the "target" parameter
     *
     * @return string
     */
    protected function getDefaultTarget()
    {
        return Contact::TARGET;
    }

    /**
     * Return default value for the "action" parameter
     *
     * @return string
     */
    protected function getDefaultAction()
    {
        return 'send';
    }
}
<?php

namespace XLite\Module\Mostad\Contact\Controller\Customer;

class Catalog extends ContactUs
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
     * @return string
     */
    protected function getDataSessionKey()
    {
        return 'custom_service_contact';
    }

    /**
     * Name of method on \XLite\Core\Mailer to call to send form data
     *
     * @return string
     */
    protected function getMailerMethodName()
    {
        return 'sendCatalogRequestMessage';
    }

    public function getStateName($stateId)
    {
        $state = \XLite\Core\Database::getRepo('XLite\Model\State')->find($stateId);

        if (!$state) {
            return null;
        }

        return $state->getCode();
    }
}
<?php

namespace XLite\Module\Mostad\Contact\Controller\Customer;

use XLite\Module\CDev\SimpleCMS\Model\Page;

class Contact extends ContactUs
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

    protected $params = array('target', 'page');

    /**
     * @var Page
     */
    protected $cmsPage = null;

    public function getTitle()
    {
        if ($this->getCmsPage()) {
            return static::t($this->getCmsPage()->getName());
        }
        return static::t('Contact Form');
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
        return 'sendRequestMessage';
    }

    /**
     * @param $stateId
     *
     * @return null
     */
    public function getStateName($stateId)
    {
        $state = \XLite\Core\Database::getRepo('XLite\Model\State')->find($stateId);

        if (!$state) {
            return null;
        }

        return $state->getCode();
    }

    /**
     * @return Page|null
     */
    protected function getCmsPage()
    {
        if (!$this->cmsPage) {
            $this->cmsPage = $this->getPageId()
                ? \XLite\Core\Database::getRepo('XLite\Module\CDev\SimpleCMS\Model\Page')->findOneByCleanUrl($this->getPageId())
                : null;
        }

        return $this->cmsPage;
    }

    /**
     * Return page slug
     *
     * @return integer
     */
    public function getPageId()
    {
        return \XLite\Core\Request::getInstance()->page;
    }

    /**
     * @return string|null
     */
    public function getPageBody()
    {
        return $this->getCmsPage() ? $this->getCmsPage()->getBody() : null;
    }
}
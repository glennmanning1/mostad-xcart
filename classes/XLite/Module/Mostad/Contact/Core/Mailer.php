<?php

namespace XLite\Module\Mostad\Contact\Core;

/**
 * Mailer core class
 */
abstract class Mailer extends \XLite\Core\Mailer implements \XLite\Base\IDecorator
{
    const TYPE_CATALOG_REQUEST = 'CatalogRequest';

    /**
      * `From` storage
      *
      * @var string
      */
     protected static $fromStorage = null;

     /**
      * Make some specific preparations for "Custom Headers" for SiteAdmin email type
      *
      * @param array  $customHeaders "Custom Headers" field value
      *
      * @return array new "Custom Headers" field value
      */
     protected static function prepareCustomHeadersContactUs($customHeaders)
     {
         $customHeaders[] = 'Reply-To: ' . static::$fromStorage;

         return $customHeaders;
     }

     /**
      * Send contact us message
      *
      * @param array  $data  Data
      * @param string $email Email
      *
      * @return string | null
      */
     public static function sendRequestMessage(array $data, $email)
     {
         static::$fromStorage = $data['email'];
         $data['message'] = htmlspecialchars($data['message']);

         static::register('data', $data);

         static::compose(
             static::TYPE_CATALOG_REQUEST,
             static::getSiteAdministratorMail(),
             $email,
             'modules/Mostad/Contact/Contact',
             array(),
             true,
             \XLite::ADMIN_INTERFACE
         );

         return static::getMailer()->getLastError();
     }

}

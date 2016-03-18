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

namespace XLite\Module\Mostad\BlogUpdates\View;


class BlogUpdates extends \XLite\View\AView
{

    /**
     * @var array
     */
    protected $currentPosts = array();

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/Mostad/BlogUpdates/body.tpl';
    }

    /**
     * @return array
     */
    protected function getBlogData()
    {
        if (!empty($this->currentPosts)) {
            return $this->currentPosts;
        }
        $this->currentPosts = \XLite\Core\Database::getRepo('XLite\Module\Mostad\BlogUpdates\Model\BlogPost')
            ->getCurrentPosts();

        if (empty($this->currentPosts)) {
            $this->currentPosts = $this->getFreshPosts();
        }

        return $this->currentPosts;
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function getFreshPosts()
    {
        $output = array();
        $url = \XLite\Core\Config::getInstance()->Mostad->BlogUpdates->wp_blog_url;

        if (empty($url)) {
            return $output;
        }

        $ch = curl_init($url);
        $em = \XLite\Core\Database::getEM();

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (!$result = curl_exec($ch)) {
            return $this->getNewestPosts();
        }
        curl_close($ch);

        $connection = $em->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $truncateSql = $platform->getTruncateTableSQL(
            $currentPosts = \XLite\Core\Database::getRepo('XLite\Module\Mostad\BlogUpdates\Model\BlogPost')->getTableName()
        );
        $connection->executeUpdate($truncateSql);

        $data = new \SimpleXMLElement($result);

        foreach ($data->channel->item as $item) {
            if (count($output) >= 2) {
                break;
            }
            $date = new \DateTime($item->pubDate);

            $post = new \XLite\Module\Mostad\BlogUpdates\Model\BlogPost();

            $post->setDate($date);
            $post->setTitle($item->title);
            $post->setLink($item->link);

            $em->persist($post);

            $output[] = $post;
        }

        $em->flush();

        return $output;
    }

    /**
     * @return mixed
     */
    protected function getNewestPosts()
    {
        return \XLite\Core\Database::getRepo('XLite\Module\Mostad\BlogUpdates\Model\BlogPost')
            ->getNewestPosts();
    }
}
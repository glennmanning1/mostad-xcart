<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 2/18/16
 * Time: 10:37 AM
 */

namespace XLite\Module\Mostad\CustomTheme\Model;


abstract class Category extends \XLite\Model\Category implements \XLite\Base\IDecorator
{
    /**
     * The selected listing template
     *
     * @var string
     *
     * @Column(type="string", length=255)
     */
    protected $listingTemplate = '';

    /**
     * @return string
     */
    public function getListingTemplate()
    {
        return $this->listingTemplate;
    }

    /**
     * @param string $listingTemplate
     *
     * @return Category
     */
    public function setListingTemplate($listingTemplate)
    {
        $this->listingTemplate = $listingTemplate;

        return $this;
    }

}
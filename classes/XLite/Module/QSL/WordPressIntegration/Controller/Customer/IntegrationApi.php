<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\QSL\WordPressIntegration\Controller\Customer;

/**
 * Integration Api controller
 */
class IntegrationApi extends \XLite\Controller\Customer\Cart
{
    /**
     * Cache of the product models
     *
     * @var array
     */
    protected $products;

    /**
     * Default image (no image) dimensions
     */
    const DEFAULT_IMAGE_WIDTH  = 300;
    const DEFAULT_IMAGE_HEIGHT = 300;

    /**
     * Check - amount is set into request data or not
     *
     * @return boolean
     */
    protected function isSetCurrentAmount()
    {
        return true;
    }

    /**
     * Return product amount
     *
     * @return integer
     */
    protected function getCurrentAmount()
    {
        $amount = $this->products[0];
        $amount = explode("_", $amount);
        $amount = $amount[1];

        return (!is_null($amount)) ? intval($amount) : 1;
    }

    /**
     * Return current product Id
     *
     * @return integer
     */
    protected function getCurrentProductId() 
    {
        $product = $this->products[0];
        $product = explode("_", $product);
        $product = $product[0];

        return (!is_null($product)) ? intval($product) : false;
    }

    /**
     * Search products by substring
     *
     * @return void
     */
    protected function doActionSearch() 
    {
        $textForSearch = \XLite\Core\Request::getInstance()->text_for_search;
        $cnd = new \XLite\Core\CommonCell();
        $cnd->{\XLite\Model\Repo\Product::P_SUBSTRING}  = $textForSearch;
        $cnd->{\XLite\Model\Repo\Product::P_BY_TITLE}   = 'Y';
        $cnd->{\XLite\Model\Repo\Product::P_BY_SKU}     = 'Y';

        $products = \XLite\Core\Database::getRepo('XLite\Model\Product')->search($cnd);

        $data = array();
        $schema = new \XLite\Module\XC\RESTAPI\Core\Schema\Native();
        $printer = new \XLite\Module\XC\RESTAPI\Core\Printer\JSON($schema);

        foreach ($products as $product) {
            $data[] = $this->convertModelProduct($product); 
        }

        $printer->printOutput($data);

        die();
    }

    /**
     * Add products to cart
     *
     * @return void
     */
    protected function doActionAddProductsToCart() 
    {
        if (!$this->getCart()->isEmpty()) {
            // Clear cart
            $this->getCart()->clear();

            // Update cart properties
            $this->updateCart();
        }

        $this->products = \XLite\Core\Request::getInstance()->products;
        $productsCount = count($this->products);

        for ($i = 0; $i < $productsCount; $i++) {
            if (
                !\XLite\Core\Request::getInstance()->attribute_values
                && \XLite\Core\Config::getInstance()->General->force_choose_product_options
                && $this->getCurrentProduct()
                && $this->getCurrentProduct()->hasEditableAttributes()
            ) {
                //Error
            } else {
                // Add product to the cart and set a top message (if needed)
                $item = $this->getCurrentItem();
                $this->addItem($item);

                unset($this->product);
            }
            $product = array_shift($this->products);
        }

        // Update cart
        $this->updateCart();
        $this->setReturnURL($this->buildURL('checkout'));
    }


    /**
     * Get products in category
     *
     * @return void
     */
    protected function doActionGetProductsInCategory() 
    {
        $request = \XLite\Core\Request::getInstance();
        $method = 'GET';
        $schema = new \XLite\Module\XC\RESTAPI\Core\Schema\Native($request, $method);
        $printer = new \XLite\Module\XC\RESTAPI\Core\Printer\JSON($schema);

        header('Content-Type: application/json');
        $data = array();

        $categoryId = \XLite\Core\Request::getInstance()->category;

        if (is_numeric($categoryId)) {
            $category = \XLite\Core\Database::getRepo('\XLite\Model\Category')->find($categoryId);
            if ($category) {
                $products = $category->getProducts();
                foreach ($products as $product) {
                    $data[] = $this->convertModelProduct($product); 
                }

                $printer->printOutput($data);
            }
        }
        die ();
    }

    /**
     * Get list of categories
     *
     * @return void
     */
    protected function doActionGetCategories() 
    {
        $categories = \XLite\Core\Database::getRepo('\XLite\Model\Category')->findAll();

        $data = array();
        foreach ($categories as $category) {
            $data[] = $this->convertModelCategory($category);
        }

        $schema = new \XLite\Module\XC\RESTAPI\Core\Schema\Native();
        $printer = new \XLite\Module\XC\RESTAPI\Core\Printer\JSON($schema);

        header('Content-Type: application/json');
        $printer->printOutput($data);
        die ();
    }

    /**
     * Get category by id
     *
     * @return void
     */
    protected function doActionGetCategoryById() 
    {
        $categoryId = \XLite\Core\Request::getInstance()->category;
        if (is_numeric($categoryId)) {
            $category = \XLite\Core\Database::getRepo('\XLite\Model\Category')->find($categoryId);
            if ($category) {
                $data = $this->convertModelCategory($category);

                $schema = new \XLite\Module\XC\RESTAPI\Core\Schema\Native();
                $printer = new \XLite\Module\XC\RESTAPI\Core\Printer\JSON($schema);

                header('Content-Type: application/json');
                $printer->printOutput($data);
            }
        }
        die ();
    }

    /**
     * Process model (image)
     *
     * @param \XLite\Model\Image
     *
     * @return array
     */
    protected function processImage(\XLite\Model\Image $image)
    {
        $width = 0;
        $height = 0;
        $resizedURL = '';
        list(
            $width,
            $height,
            $resizedURL
        ) = $image->getResizedURL(160, 160);

        $result = array(
            'url' => $image->getFrontURL(),
            'width' => $width,
            'height' => $height
        );

        return $result;
    }

    /**
     * Convert model (product)
     * 
     * @param \XLite\Model\Product $model Product
     *  
     * @return array
     */
    protected function convertModelCategory(\XLite\Model\Category $model)
    {
        $translations = array();
        foreach ($model->getTranslations() as $translation) {
            $translations[$translation->getCode()] = array(
                'name' => $translation->getName(),
            );
        }

        $category = array(
            'categoryId'       => $model->getCategoryId(),
            'name'             => $model->getName(),
            'URL'              => $model->getFrontURL(),
            'enabled'          => $model->getEnabled(),
            'pos'              => $model->getPos(),
            'lpos'             => $model->getLpos(),
            'rpos'             => $model->getRpos(),
            'depth'            => $model->getDepth(),
            'translations'     => $translations,
        );

        $image = $model->getImage();
        if ($image) {
            $category['image'] = $this->processImage($image);
        }

        return $category;
    }


    /**
     * Convert model (product)
     * 
     * @param \XLite\Model\Product $model Product
     *  
     * @return array
     */
    protected function convertModelProduct(\XLite\Model\Product $model)
    {
        $language = \XLite\Core\Config::getInstance()->General->default_language;
        $translation = $model->getSoftTranslation($language);

        $images = array();
        foreach ($model->getImages() as $image) {
            $images[] = $this->processImage($image);
        }

        $categories = array();
        foreach ($model->getCategories() as $category) {
            $categories[] = $category->getStringPath();
        }

        $memberships = array();
        foreach ($model->getMemberships() as $membership) {
            $memberships[] = $membership->getName();
        }

        $translations = array();
        foreach ($model->getTranslations() as $translation) {
            $translations[$translation->getCode()] = array(
                'name'             => $translation->getName(),
                'description'      => $translation->getDescription(),
                'shortDescription' => $translation->getShortDescription(),
            );
        }

        $currency = \XLite::getInstance()->getCurrency();

        return array(
            'sku'              => $model->getSku(),
            'productId'        => $model->getProductId(),
            'name'             => $translation->getName(),
            'description'      => $translation->getDescription(),
            'shortDescription' => $translation->getBriefDescription(),
            'price'            => $model->getPrice(),
            'currencySymbol'   => $currency->getSymbol(),
            'weight'           => $model->getWeight(),
            'quantity'         => $model->getInventory()->getAmount(),
            'releaseDate'      => $model->getArrivalDate() ? date('c', $model->getArrivalDate()) : null,
            'image'            => $images,
            'URL'              => $model->getFrontURL(),
            'enabled'          => $model->getEnabled(),
            'freeShipping'     => $model->getFreeShipping(),
            'categories'       => $categories,
            'memberships'      => $memberships,
            'translations'     => $translations
        );
    }
}

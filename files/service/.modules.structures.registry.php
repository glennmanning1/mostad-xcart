# <?php if (!defined('LC_DS')) { die(); } ?>

Amazon\PayWithAmazon:
    tables: {  }
    columns: {  }
CDev\AuthorizeNet:
    tables: {  }
    columns: {  }
CDev\ContactUs:
    tables: {  }
    columns: {  }
CDev\Coupons:
    tables: [coupons, product_class_coupons, membership_coupons, coupon_categories, order_coupons]
    columns: {  }
CDev\FeaturedProducts:
    tables: [featured_products]
    columns: {  }
CDev\FedEx:
    tables: {  }
    columns: {  }
CDev\GoogleAnalytics:
    tables: {  }
    columns: {  }
CDev\Moneybookers:
    tables: {  }
    columns: {  }
CDev\Quantum:
    tables: {  }
    columns: {  }
CDev\SimpleCMS:
    tables: [page_images, menu_quick_flags, menus, menu_translations, pages, page_translations]
    columns: { clean_urls: { page_id: 'page_id INT UNSIGNED DEFAULT NULL' } }
CDev\TinyMCE:
    tables: {  }
    columns: {  }
CDev\TwoCheckout:
    tables: {  }
    columns: {  }
CDev\USPS:
    tables: {  }
    columns: {  }
CDev\VolumeDiscounts:
    tables: [volume_discounts]
    columns: {  }
CDev\XMLSitemap:
    tables: {  }
    columns: {  }
QSL\CloudSearch:
    tables: [search_cache]
    columns: {  }
XC\ColorSchemes:
    tables: {  }
    columns: {  }
XC\EPDQ:
    tables: {  }
    columns: {  }
XC\IdealPayments:
    tables: {  }
    columns: {  }
XC\SagePay:
    tables: {  }
    columns: {  }
XC\Stripe:
    tables: {  }
    columns: {  }
XC\ThemeTweaker:
    tables: [theme_tweaker_template]
    columns: {  }
XC\UPS:
    tables: {  }
    columns: {  }
XC\Upselling:
    tables: [upselling_products]
    columns: {  }
CDev\Wholesale:
    tables: [olesalePrice, product_min_quantities, wholesale_prices]
    columns: {  }
Mostad\CustomTheme:
    tables: {  }
    columns: {  }
Mostad\Marketing:
    tables: {  }
    columns: { pages: { disableLayout: 'disableLayout TINYINT(1) NOT NULL' } }

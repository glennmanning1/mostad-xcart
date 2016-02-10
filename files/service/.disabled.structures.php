# <?php if (!defined('LC_DS')) { die(); } ?>

CDev\Bestsellers:
    tables: {  }
    columns: { products: { sales: 'sales INT UNSIGNED NOT NULL' } }
XC\CanadaPost:
    tables: [k, capost_delivery_service_options, capost_delivery_services, order_capost_parcel_items, order_capost_parcel_manifest_link_storage, order_capost_parcel_manifest_links, order_capost_parcel_manifests, order_capost_parcel_shipments_manifests, order_capost_parcel_shipment_link_storage, order_capost_parcel_shipment_links, order_capost_parcel_shipment_tracking_options, order_capost_parcel_shipment_tracking_files, order_capost_parcel_shipment_tracking_events, order_capost_parcel_shipment_tracking, order_capost_parcel_shipment, order_capost_parcels, order_capost_office, capost_return_items, capost_return_link_storage, capost_return_links, capost_returns]
    columns: {  }
XC\FreeShipping:
    tables: {  }
    columns: { products: { freeShip: 'freeShip TINYINT(1) NOT NULL', freightFixedFee: 'freightFixedFee NUMERIC(14, 4) NOT NULL' }, shipping_methods: { free: 'free TINYINT(1) NOT NULL' } }
CDev\GoSocial:
    tables: {  }
    columns: { categories: { ogMeta: 'ogMeta LONGTEXT NOT NULL', useCustomOG: 'useCustomOG TINYINT(1) NOT NULL' }, pages: { ogMeta: 'ogMeta LONGTEXT NOT NULL', showSocialButtons: 'showSocialButtons TINYINT(1) NOT NULL' }, products: { ogMeta: 'ogMeta LONGTEXT NOT NULL', useCustomOG: 'useCustomOG TINYINT(1) NOT NULL' } }
XC\News:
    tables: [news, news_message_translations]
    columns: { clean_urls: { news_message_id: 'news_message_id INT UNSIGNED DEFAULT NULL' } }
XC\PitneyBowes:
    tables: [pb_parcel_item, pb_exports, pb_order, pb_parcel, product_restrictions]
    columns: { orders: { pb_order_id: 'pb_order_id INT UNSIGNED DEFAULT NULL' }, products: { exported_pb: 'exported_pb TINYINT(1) NOT NULL', gpc: 'gpc VARCHAR(100) DEFAULT NULL', gtin: 'gtin VARCHAR(25) DEFAULT NULL', hs_code: 'hs_code VARCHAR(6) DEFAULT NULL', mpn: 'mpn VARCHAR(100) DEFAULT NULL', model_number: 'model_number VARCHAR(200) DEFAULT NULL', stock_number: 'stock_number VARCHAR(100) DEFAULT NULL', hazmat: 'hazmat TINYINT(1) DEFAULT NULL', chemicals: 'chemicals TINYINT(1) DEFAULT NULL', pesticide: 'pesticide TINYINT(1) DEFAULT NULL', rppc: 'rppc TINYINT(1) DEFAULT NULL', non_spillable: 'non_spillable TINYINT(1) DEFAULT NULL', fuel: 'fuel TINYINT(1) DEFAULT NULL', ormd: 'ormd TINYINT(1) DEFAULT NULL', battery: 'battery VARCHAR(100) DEFAULT NULL', product_condition: 'product_condition VARCHAR(1) DEFAULT NULL', country_code: 'country_code CHAR(2) DEFAULT NULL' } }
CDev\ProductAdvisor:
    tables: [product_stats]
    columns: {  }
CDev\Sale:
    tables: {  }
    columns: { products: { participateSale: 'participateSale TINYINT(1) NOT NULL', discountType: 'discountType VARCHAR(32) NOT NULL', salePriceValue: 'salePriceValue NUMERIC(14, 4) NOT NULL' } }
CDev\SalesTax:
    tables: [sales_tax_rates, sales_taxes, sales_tax_translations]
    columns: {  }
CDev\UserPermissions:
    tables: {  }
    columns: { permissions: { enabled: 'enabled TINYINT(1) NOT NULL' }, roles: { enabled: 'enabled TINYINT(1) NOT NULL' } }

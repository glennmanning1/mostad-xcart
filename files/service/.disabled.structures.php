# <?php if (!defined('LC_DS')) { die(); } ?>

CDev\Sale:
    tables: {  }
    columns: { products: { participateSale: 'participateSale TINYINT(1) NOT NULL', discountType: 'discountType VARCHAR(32) NOT NULL', salePriceValue: 'salePriceValue NUMERIC(14, 4) NOT NULL' } }
CDev\SalesTax:
    tables: [sales_tax_rates, sales_taxes, sales_tax_translations]
    columns: {  }

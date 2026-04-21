# [Magento 2 Rocket JavaScript Extension](https://magefan.com/rocket-javascript-deferred-javascript) by Magefan


[![Total Downloads](https://poser.pugx.org/magefan/module-rocketjavascript/downloads)](https://packagist.org/packages/magefan/module-rocketjavascript)
[![Latest Stable Version](https://poser.pugx.org/magefan/module-rocketjavascript/v/stable)](https://packagist.org/packages/magefan/module-rocketjavascript)


<a href="https://savelife.in.ua/en/donate-en/#donate-army-card-monthly"><img width="830" height="208" src="https://cm.magefan.com/blog/support-ukraine.png"></a>

<img width="150" height="100" src="https://magefan.com/media/wysiwyg/made_in_ukraine.jpg">

## Magento2 Footer JavaScript
## Magento2 Deferred JavaScript
## Magento2 Optimized Bundle JavaScript


<a href="https://magefan.com/rocket-javascript-deferred-javascript"><img width="190" height="70" src="https://cm.magefan.com/wysiwyg/products/download-magefan-extensions.png"></a>
  
## Configuration
  * To enable or disable extension please navigate to Magento 2 Admin Panel > Stores > Magefan Extensions > Rocket JavaScript

## Requirements
  * Magento Community Edition 2.1.x-2.4.x or Magento Enterprise Edition 2.1.x-2.4.x
  
## Installation
* [Install Rocket JavaScript Extension for Magento 2 via Composer or an archive](https://magefan.com/blog/rocket-javascript-installation)

## Get List Of Used JS On A Single Page
```
/* Use in browser console */
globalSrc = '';
jQuery('script').each(function(){
if (!jQuery(this).attr('src')) return;
var src = jQuery(this).attr('src');
if (src.indexOf(require.toUrl('')) != -1 && src.indexOf('Magefan_LazyLoad') == -1) {
var src = (src.replace(require.toUrl(''), ''));
globalSrc += "\n" + src;
}
})
console.log(globalSrc);

```
## Demo

Try out our open demo and if you like our extension **please give us some star on Github ★**
<table>
  <tbody>
    <tr>
      <td align="center" valign="middle">
        Storefront Demo
      </td>
      <td align="center" valign="middle">
        Admin Panel Demo
      </td align="center" valign="middle">
    </tr>
    <tr>
      <td align="center" valign="middle">
        <a href="https://rjs.demo.magefan.top/">
          <img
            src="https://magefan.com/static/version1520969775/frontend/Magefan/new/en_US/images/product-tab-demo-1.jpg"
            alt="Magneto 2 Rocket JavaScript Extension Storefront Demo"
            height="220"
          >
        </a>
      </td>
      <td align="center" valign="middle">
        <a href="https://rjs.demo.magefan.top/admin/admin/">
          <img
            src="https://cs.magefan.com/version1732118579/frontend/Magefan/next/en_US/Magefan_CssOptimizer/images/product-tab-demo-2.jpg"
            alt="Magento 2 Rocket JavaScript Extension Admin Panel Demo"
            height="220"
          >
        </a>
      </td>
    </tr>
    <tr>
      <td align="center" valign="middle">
        <a href="https://rjs.demo.magefan.top/">
          view
        </a>
      </td>
      <td align="center" valign="middle">
        <a href="https://rjs.demo.magefan.top/admin/admin/">
          view
        </a>
      </td>
    </tr>
  </tbody>
</table>

## Support
If you have any issues, please [contact us](mailto:support@magefan.com)
then if you still need help, open a bug report in GitHub's
[issue tracker](https://github.com/magefan/module-rocketjavascript/issues).

Please do not use Magento Marketplace's Reviews or (especially) the Q&A for support.
There isn't a way for us to reply to reviews and the Q&A moderation is very slow.

## License
The code is licensed under [Open Software License ("OSL") v. 3.0](http://opensource.org/licenses/osl-3.0.php).

## [Magento Extensions](https://magefan.com/magento-2-extensions) by Magefan

### Magento 2 SEO Extensions

* [Magento SEO](https://magefan.com/magento-2-seo-extension)
* [Magento 2 Rich Snippets](https://magefan.com/magento-2-rich-snippets)
* [Magento 2 HTML Sitemap](https://magefan.com/magento-2-html-sitemap-extension)
* [Magento 2 XML Sitemap](https://magefan.com/magento-2-xml-sitemap-extension)
* [Magento 2 Twitter Cards](https://magefan.com/magento-2-twitter-cards-extension)
* [Magento Open Graph Tags](https://magefan.com/magento-2-open-graph-extension-og-tags)

### [Magento 2 Google Extensions](https://magefan.com/magento-2-extensions/google-extensions)

* [Magento Google Tag Manager](https://magefan.com/magento-2-google-tag-manager)
* [Magento 2 Google Analytics 4](https://magefan.com/magento-2-google-analytics-4)
* [Magento Google Shopping Feed](https://magefan.com/magento-2-google-shopping-feed-extension)
* [Magento Google Customer Reviews](https://magefan.com/magento-2-google-customer-reviews)
* [Magento 2 Google Indexing](https://magefan.com/magento-2-google-indexing-api)

### [Magento Speed Optimisation Extensions](https://magefan.com/magento-2-extensions/speed-optimization)

* [Magento 2 Google Page Speed Optimizer](https://magefan.com/magento-2-google-page-speed-optimizer)
* [Magento 2 WebP Images](https://magefan.com/magento-2-webp-optimized-images)
* [Magento Full Page Cache Extension](https://magefan.com/magento-2-full-page-cache-warmer)
* [Magento 2 Lazy Load Images](https://magefan.com/magento-2-image-lazy-load-extension)

### [Magento Admin Extensions](https://magefan.com/magento-2-extensions/admin-extensions)

* [Magento 2 Dynamic Category](https://magefan.com/magento-2-dynamic-categories)
* [Magento 2 Size Chart](https://magefan.com/magento-2-size-chart)
* [Magento 2 Security Extension](https://magefan.com/magento-2-security-extension)
* [Magento 2 Admin Action Log](https://magefan.com/magento-2-admin-action-log)
* [Magento Extended Product Grid](https://magefan.com/magento-2-product-grid-inline-editor)
* [Magento 2 Product Tabs](https://magefan.com/magento-2/extensions/product-tabs)
* [Magento 2 Product Widget](https://magefan.com/magento-2-product-widget)
* [Magento 2 Email Attachments](https://magefan.com/magento-2-email-attachments)
* [Magento 2 Admin View](https://magefan.com/magento-2-admin-view-extension)
* [Magento 2 Email Notifications](https://magefan.com/magento-2-admin-email-notifications)
* [Magento 2 Login As Customer](https://magefan.com/login-as-customer-magento-2-extension)

### [Magento Order Management Extensions](https://magefan.com/magento-2-extensions/order-management)

* [Magento Order Editor](https://magefan.com/magento-2-edit-order-extension)
* Better [Magento 2 Order Grid](https://magefan.com/magento-2-better-order-grid-extension)
* [Magento 2 Guest to Customer](https://magefan.com/magento2-convert-guest-to-customer)
* [Magento POS System](https://magefan.com/magento-pos-system)

### Magento 2 Blog Extensions

* [Magento 2 Blog Extension](https://magefan.com/magento2-blog-extension)
* [Magento 2 Multi Blog](https://magefan.com/magento-2-multi-blog-extension)

### [Magento Marketing Extensions](https://magefan.com/magento-2-extensions/marketing-automation)

* [Magento 2 Facebook Pixel](https://magefan.com/magento-2-facebook-pixel-extension)
* [Magento TikTok Pixel](https://magefan.com/magento-2-tiktok-pixel)
* [Magento 2 Dynamic Blocks](https://magefan.com/magento-2-cms-display-rules-extension) and Pages
* [Magento 2 Cookie Consent](https://magefan.com/magento-2-cookie-consent)
* [Magento 2 Base Price](https://magefan.com/magento-2-base-price)
* [Magento 2 Price History](https://magefan.com/magento-2-price-history)
* [Magento 2 Mautic Extension](https://magefan.com/magento-2-mautic-extension)
* [Magento 2 YouTube Video](https://magefan.com/magento2-youtube-extension)

### [Magento Promotions Extensions](https://magefan.com/magento-2-extensions/promotions-extensions)

* [Magento 2 Automatic Related Products](https://magefan.com/magento-2-automatic-related-products)
* [Magento 2 Product Labels](https://magefan.com/magento-2-product-labels)
* [Magento 2 Coupon Code Extension](https://magefan.com/magento-2-coupon-code-link)

### [Magento 2 Multi-Language Extensions](https://magefan.com/magento-2-extensions/multi-language-extensions)

* [Magento 2 Hreflang Tags](https://magefan.com/magento2-alternate-hreflang-extension)
* [Magento 2 Currency Switcher](https://magefan.com/magento-2-currency-switcher-auto-currency-by-country)
* [Magento 2 Language Switcher](https://magefan.com/magento-2-auto-language-switcher)
* [Magento 2  Store Switcher](https://magefan.com/magento-2-geoip-switcher-extension)
* [Magento 2 Translation Extension](https://magefan.com/magento-2-translation-extension)

### [Developers Tools](https://magefan.com/magento-2-extensions/developer-tools)

* [Magento Zero Downtime Deployment](https://magefan.com/blog/magento-2-zero-downtime-deployment)
* [Magento 2 Cron Schedule](https://magefan.com/magento-2-cron-schedule)
* [Magento 2 CLI Extension](https://magefan.com/magento2-cli-extension)
* [Magento 2 Conflict Detector](https://magefan.com/magento2-conflict-detector)

### [Shopify Apps](https://magefan.com/shopify/apps) by Magefan

* [Shopify Login As Customer](https://apps.shopify.com/login-as-customer)
* [Shopify Blog](https://apps.shopify.com/magefan-blog)
* [Shopify Size Chart](https://magefan.com/shopify/apps/size-chart)
* [Shopify Google Indexer](https://magefan.com/shopify/apps/google-indexing)
* [Shopify Product Feeds](https://magefan.com/shopify/apps/product-feed)
* [Shopify Server GTM & GA4](https://magefan.com/shopify/apps/gtm-and-ga4)

### [Magento 2 Services](https://magefan.com/services) by Magefan

* [Magento Speed Optimization Service](https://magefan.com/magento-speed-optimization-service)
* [Magent SEO Service](https://magefan.com/magento-2-seo-service)
* [Custom Magento Development](https://magefan.com/custom-development)
* [Magento Installation Service](https://magefan.com/installation-service)

{* vim: set ts=2 sw=2 sts=2 et: *}
{**
 * @ListChild (list="head", weight="999000")
 *}

 <!-- Facebook Pixel Code -->

<script>
!function(f,b,e,v,n,t,s) { if(f.fbq)return;n=f.fbq=function() { n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments) }; if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s) } (window,
document,'script','//connect.facebook.net/en_US/fbevents.js');

// Insert Your Facebook Pixel ID below. 
fbq('init', '174358386341061');
fbq('track', 'PageView');
</script>

<!-- Insert Your Facebook Pixel ID below. --> 
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=174358386341061&ev=PageView&noscript=1"
/></noscript>

<!-- End Facebook Pixel Code -->

<!-- ViewContent event-->

{if:getTarget()=#product#}
<script>
// ViewContent
// Track key page views (ex: product page, landing page or article)
fbq('track', 'ViewContent', {
content_name: '{product.getName()}',
content_category: '{product.category.getStringPath()}',
content_ids: ['{product.getID()}'],
content_type: 'product',
value: {product.getPrice()},
currency: '{xlite.currency.getCode()}' /* Default Store Currency */
});
</script>
{end:}

<!-- initiate checkout and purchase events-->

{if:getTarget()=#checkout#}
<script>
// InitiateCheckout
// Track when people enter the checkout flow (ex. click/landing page on checkout button)
fbq('track', 'InitiateCheckout', {
});
</script>
{end:}

{if:getTarget()=#checkoutSuccess#}
<script>
// Purchase
// Track purchases or checkout flow completions (ex. landing on "Thank You" or confirmation page)
fbq('track', 'Purchase', {
value: {order.getTotal()},
currency: '{order.currency.getCode()}'
});
</script>
{end:}



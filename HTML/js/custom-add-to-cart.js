jQuery(document).ready(function($) {
    $('body').on('added_to_cart', function(event, fragments, cart_hash, $button) {
        console.log('Product added to cart:', $button);
        var viewCartButton = $button.closest('.product-box').find('.view-cart-button');
        if (viewCartButton.length) {
			            $button.hide();
            viewCartButton.show();
        }
    });
});

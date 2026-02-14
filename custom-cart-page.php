<?php
/**
 * Template Name: Custom Cart Page
 */

get_header(); ?>

<div class="custom-cart-page">
    <h1>Your Shopping Cart</h1>

    <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
        <form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            <table class="shop_table shop_table_responsive cart" cellspacing="0">
                <thead>
                    <tr>
                        <th class="product-thumbnail"><?php _e( 'Thumbnail', 'woocommerce' ); ?></th>
                        <th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
                        <th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
                        <th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
                        <th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
                        <th class="product-remove"><?php _e( 'Remove', 'woocommerce' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                            ?>
                            <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                                <td class="product-thumbnail">
                                    <?php
                                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                    if ( ! $product_permalink ) {
                                        echo $thumbnail;
                                    } else {
                                        printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                                    }
                                    ?>
                                </td>
                                <td class="product-name" data-title="<?php _e( 'Product', 'woocommerce' ); ?>">
                                    <?php
                                    if ( ! $product_permalink ) {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                    } else {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                    }

                                    // Meta data
                                    echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                    // Backorder notification
                                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>' ) );
                                    }
                                    ?>
                                </td>
                                <td class="product-price" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
                                    <?php
                                    echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                    ?>
                                </td>
                                <td class="product-quantity" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
                                    <div class="quantity-buttons">
                                        <button type="button" class="decrement">-</button>
                                        <?php
                                        if ( $_product->is_sold_individually() ) {
                                            $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                        } else {
                                            $product_quantity = woocommerce_quantity_input( array(
                                                'input_name'  => "cart[{$cart_item_key}][qty]",
                                                'input_value' => $cart_item['quantity'],
                                                'max_value'   => $_product->get_max_purchase_quantity(),
                                                'min_value'   => '0',
                                                'product_name' => $_product->get_name(),
                                            ), $_product, false );
                                        }

                                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                        ?>
                                        <button type="button" class="increment">+</button>
                                    </div>
                                </td>
                                <td class="product-subtotal" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
                                    <?php
                                    echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                    ?>
                                </td>
                                <td class="product-remove">
                                    <?php
                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                        __( 'Remove this item', 'woocommerce' ),
                                        esc_attr( $product_id ),
                                        esc_attr( $_product->get_sku() )
                                    ), $cart_item_key );
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    endforeach; ?>
                </tbody>
            </table>

            <div class="cart-collaterals">
                <div class="cart-subtotal">
                    <strong><?php _e( 'Subtotal', 'woocommerce' ); ?>:</strong> 
                    <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                </div>

                <div class="coupon">
                    <label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> 
                    <input type="text" name="coupon_code" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" /> 
                    <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
                    <?php do_action( 'woocommerce_cart_coupon' ); ?>
                </div>

                <?php if ( wc_coupons_enabled() ) : ?>
                    <div class="coupon">
                        <label for="coupon_code"><?php _e( 'Coupon:', 'woocommerce' ); ?></label> 
                        <input type="text" name="coupon_code" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" /> 
                        <button type="submit" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
                        <?php do_action( 'woocommerce_cart_coupon' ); ?>
                    </div>
                <?php endif; ?>

                <div class="shipping">
                    <h2><?php _e( 'Shipping', 'woocommerce' ); ?></h2>
                    <?php woocommerce_shipping_calculator(); ?>
                </div>

                <div class="address">
                    <h2><?php _e( 'Address', 'woocommerce' ); ?></h2>
                    <?php woocommerce_checkout_shipping(); ?>
                </div>
            </div>

            <div class="cart-actions">
                <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
                <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward"><?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?></a>
            </div>
        </form>

    <?php else : ?>
        <p><?php esc_html_e( 'Your cart is currently empty.', 'woocommerce' ); ?></p>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="button wc-backward"><?php esc_html_e( 'Return to shop', 'woocommerce' ); ?></a>
    <?php endif; ?>

</div>

<?php get_footer(); ?>

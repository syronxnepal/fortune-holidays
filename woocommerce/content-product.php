<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}
// Get product details
$product_id = $product->get_id();
$product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail');
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
$is_on_sale = $product->is_on_sale();
$product_categories = wp_get_post_terms($product_id, 'product_cat');

// Calculate percentage off
$percentage_off = 0;
if ($is_on_sale && $regular_price > 0) {
	$percentage_off = round((($regular_price - $sale_price) / $regular_price) * 100);
}

?>

<li <?php wc_product_class('', $product); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item' );
	
	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item_title' );
	
	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	// do_action( 'woocommerce_shop_loop_item_title' );
	
	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	// do_action( 'woocommerce_after_shop_loop_item_title' );
	
	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	// do_action( 'woocommerce_after_shop_loop_item' );
	?>
	    <div class="product-box">
		<a href="<?php the_permalink(); ?>" class="product-link"></a>
		<div class="image">
			<img src="<?php echo esc_url($product_image[0]); ?>" alt="<?php the_title(); ?>">
            </div>
            <div class="shade"></div>
            <div class="sale-box">
			<?php if ($is_on_sale): ?>
					<?php if ($percentage_off > 0): ?>
						<?php echo $percentage_off; ?>% off
					<?php else: ?>
						Sale
					<?php endif; ?>
				<?php else: ?>
				Best Buy
				<?php endif; ?>
            </div>
            <div class="cart-options">
			
              <span>
			  <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="out-of-stock">           
				     <i class="fa-solid fa-eye"></i>
			  </a>

              </span>
              <span>
                <i class="fa-solid fa-cart-shopping"></i>
              </span>
              <span>
			  <?php
				 echo do_shortcode("[ti_wishlists_addtowishlist loop=yes]");
				?>
              </span>
            </div>
            <div class="details">
			<?php foreach ($product_categories as $category): ?>
					<h5><a href="<?php echo get_term_link($category); ?>"><?php echo esc_html($category->name); ?></a></h5>
				<?php endforeach; ?>

              <h4><?php the_title(); ?></h4>
              <h5>nf-80293h</h5>
              <div class="price-box">
			  <?php if ($is_on_sale): ?>
					<span class="org-price"><?php echo wc_price($regular_price); ?></span>
					<span class="slashed-price"><?php echo wc_price($sale_price); ?></span>
				<?php else: ?>
					<span class="org-price"><?php echo wc_price($regular_price); ?></span>
				<?php endif; ?>

              </div>
              <!-- <a href="">View <span><i class="fa-solid fa-arrow-right"></i></span></a> -->
            </div>
          </div>
</li>
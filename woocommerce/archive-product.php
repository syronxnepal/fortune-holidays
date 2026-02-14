<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header('shop');
?>
<section class="section breadcrumb-section">
	<div class="container">
		<div class="inner">
			<?php /**
			  * Hook: woocommerce_before_main_content.
			  *
			  * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			  * @hooked woocommerce_breadcrumb - 20
			  * @hooked WC_Structured_Data::generate_website_data() - 30
			  */
			do_action('woocommerce_before_main_content');
			?>

		</div>
	</div>
</section>
<?php

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */

global $wp_query;
$query_vars = $wp_query->query_vars;

$search_terms = isset($query_vars['s']) ? $query_vars['s'] : '';
$product_cat = isset($_GET['product_cat']) ? $_GET['product_cat'] : '';

// Get category names from slugs
$category_names = [];
if (!empty($product_cat)) {
	$cat_slugs = explode(',', $product_cat);
	foreach ($cat_slugs as $slug) {
		$term = get_term_by('slug', $slug, 'product_cat');
		if ($term) {
			$category_names[] = $term->name;
		}
	}
}

// Check if there are any query parameters to display custom loop header
$has_query_params = !empty($search_terms) || !empty($category_names);



?>


<div class="section archive-container">
	<div class="container">
		<div class="inner">
			<div class="left">
				<div class="filter-slider-outer" id="filter-slider">
					<div class="cross-filter-slider">
						<i class="fa-solid fa-xmark"></i>
					</div>
					<div class="filter-slider-inner">

						<?php get_sidebar('woocommerce'); // This will load sidebar-woocommerce.php ?>

					</div>
				</div>

			</div>
			<div class="right">
				<?php
				// 				do_action('woocommerce_shop_loop_header');
				?>
				<header class="woocommerce-products-header">
					<?php if ($has_query_params): ?>
						<p class="search-term-title">
							<?php
							if (!empty($search_terms)) {
								echo sprintf(__('Search results for: %s', 'woocommerce'), '<span>' . esc_html($search_terms) . '</span>');
							}
							if (!empty($category_names)) {
								echo '<br><small>' . __('Search Categories: ', 'woocommerce') . implode(', ', $category_names) . '</small>';
							}
							?>
						</p>
					<?php else: ?>
						<?php if (apply_filters('woocommerce_show_page_title', true)): ?>
							<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
						<?php endif; ?>
						<?php
						// 			do_action('woocommerce_archive_description');
						?>
					<?php endif; ?>
				</header>
				<?php

				if (woocommerce_product_loop()) {

					/**
					 * Hook: woocommerce_before_shop_loop.
					 *
					 * @hooked woocommerce_output_all_notices - 10
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action('woocommerce_before_shop_loop');

					woocommerce_product_loop_start();

					if (wc_get_loop_prop('total')) {
						while (have_posts()) {
							the_post();

							/**
							 * Hook: woocommerce_shop_loop.
							 */
							do_action('woocommerce_shop_loop');

							wc_get_template_part('content', 'product');
						}
					}

					woocommerce_product_loop_end();

					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action('woocommerce_after_shop_loop');
				} else {
					/**
					 * Hook: woocommerce_no_products_found.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action('woocommerce_no_products_found');
				}

				/**
				 * Hook: woocommerce_after_main_content.
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action('woocommerce_after_main_content');

				/**
				 * Hook: woocommerce_sidebar.
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				?>
			</div>

		</div>
	</div>
</div>

<section id="product-filter" class="filter">
	<div class="filter-icon">
		<i class="fa-solid fa-filter"></i>
	</div>
</section>

<?php
get_footer('shop');
?>
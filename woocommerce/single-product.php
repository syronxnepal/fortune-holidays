<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop'); ?>
<section class="section breadcrumb-section">
    <div class="container">
        <div class="inner">
            <?php
            /**
             * woocommerce_before_main_content hook.
             *
             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
             * @hooked woocommerce_breadcrumb - 20
             */
            do_action('woocommerce_before_main_content');
            ?>
        </div>
    </div>
</section>
<?php
/**
 * Hook: woocommerce_before_single_product.
 */
do_action('woocommerce_before_single_product');
?>


<?php while (have_posts()): ?>
    <?php the_post(); ?>

    <?php
    //wc_get_template_part( 'content', 'single-product' );

    global $product;

    // Get product details
    $product_id = $product->get_id();
    $gallery = $product->get_gallery_image_ids();
    $product_images = get_field('product_images');
    $shipping_policy = get_field('shipping_policy');

    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price();
    $is_on_sale = $product->is_on_sale();
    $short_description = $product->get_short_description();
    $full_description = $product->get_description();
    $average_rating = $product->get_average_rating();
    $ingredients = get_post_meta($product->get_id(), 'ingredients', true);

    ?>
    <script>
        window.originalPriceHtml = <?php echo json_encode($product->is_on_sale()
            ? '<span class="original">' . wc_price($regular_price) . '</span><span class="new">' . wc_price($sale_price) . '</span>'
            : '<span class="new">' . wc_price($regular_price) . '</span>'); ?>;
    </script>
    <section class="section product-inner-section">
        <div class="container">
            <div class="inner">
                <div class="main-left">
                    <div class="top">
                        <div class="left">

                            <div class="swiper galleryswiper">
                                <div class="swiper-wrapper">
                                    <?php
                                    if ($product->is_type('variable')) {
                                        $available_variations = $product->get_available_variations();
                                        foreach ($available_variations as $variation) {
                                            $image = $variation['image']['src'];
                                            if ($image) {
                                                echo '<div class="swiper-slide gallery-image" data-image="' . esc_url($image_url) . '">';
                                                echo '<div class="magnify">';
                                                echo '<div class="magnifier" style="background-image: url(' . esc_url($image) . ');"></div>';
                                                echo '<div class="magnified"><img src="' . esc_url($image) . '" /></div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                    }
                                    // Display the main image
                                    if (has_post_thumbnail()) {
                                        $image_url = get_the_post_thumbnail_url($product_id, 'full');
                                        echo '<div class="thumbnail-image swiper-slide gallery-image" data-image="' . esc_url($image_url) . '">';
                                        echo '<div class="magnify">';
                                        echo '<div class="magnifier" style="background-image: url(' . esc_url($image_url) . ');"></div>';
                                        echo '<div class="magnified"><img src="' . esc_url($image_url) . '" /></div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }

                                    // Display the gallery images
                                    foreach ($gallery as $image_id) {
                                        $image_url = wp_get_attachment_url($image_id);
                                        echo '<div class="swiper-slide gallery-image" data-image="' . esc_url($image_url) . '">';
                                        echo '<div class="magnify">';
                                        echo '<div class="magnifier" style="background-image: url(' . esc_url($image_url) . ');"></div>';
                                        echo '<div class="magnified"><img src="' . esc_url($image_url) . '" /></div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    ?>




                                </div>
                            </div>


                            <?php


                            echo '<div thumbsSlider="" class="swiper gallerythumbnail">';
                            echo '<div class="swiper-wrapper">';
                            if ($product->is_type('variable')) {
                                $attribute = 'pa_color'; // Make sure it's defined before use
                                $available_variations = $product->get_available_variations();

                                foreach ($available_variations as $variation) {
                                    $image = $variation['image']['src'];
                                    if ($image) {
                                        echo '<div class="swiper-slide gallery-thumbnail">';
                                        echo '<img src="' . esc_url($image) . '" />';
                                        echo '</div>';
                                    }
                                }
                            }
                            // Display the main image
                            if (has_post_thumbnail()) {
                                echo '<div class="thumbnail-image swiper-slide gallery-thumbnail">';
                                echo get_the_post_thumbnail($product_id, 'large');
                                echo '</div>';
                            }

                            // Display the gallery images
                            foreach ($gallery as $image_id) {
                                echo '<div class="swiper-slide gallery-thumbnail">';
                                echo wp_get_attachment_image($image_id, 'large');
                                echo '</div>';
                            }




                            echo '</div>';
                            echo '</div>';
                            ?>

                        </div>
                        <div class="right">
                            <h2><?php the_title(); ?>
                            </h2>
                            <h3 class="price" id="custom-price">
                                <?php if ($is_on_sale): ?>
                                    <span class="original"><?php echo wc_price($regular_price); ?></span>
                                    <span class="new"><?php echo wc_price($sale_price); ?></span>
                                <?php else: ?>
                                    <span class="new"><?php echo wc_price($regular_price); ?></span>
                                <?php endif; ?>
                            </h3>

                            <h5 class="code" id="custom-sku">SKU: <?php echo $product->get_sku(); ?></h5>
                            <p class="info">
                                <?php if ($short_description): ?>
                                    <?php echo wpautop($short_description); ?>
                                <?php else: ?>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                    been the industry's standard dummy text ever since the 1500s.
                                <?php endif; ?>

                            </p>
                            <div class="stock">
                                <?php if ($product->is_in_stock()): ?>
                                    <span class="in-stock">In Stock</span>
                                <?php else: ?>
                                    <span class="out-stock">Out of Stock</span>
                                <?php endif; ?>
                            </div>
                            <?php
                            // 							woocommerce_variable_add_to_cart();
                        
                            // 							woocommerce_template_single_add_to_cart();
                            ?>


                            <?php
                            // Fixed PHP code for the variation section
                        
                            if ($product->is_type('variable')) {
                                $available_variations = $product->get_available_variations();
                                $attribute = 'pa_color'; // your attribute slug
                        
                                // Debug: Check if variations exist
                                if (empty($available_variations)) {
                                    echo '<!-- No variations found for this product -->';
                                    return;
                                }
                                ?>

                                <h4>Choose Color</h4>

                                <?php
                                echo '<div class="custom-image-swatches" data-attribute="' . esc_attr($attribute) . '">';

                                foreach ($available_variations as $variation) {
                                    $variation_id = $variation['variation_id'];
                                    $variation_obj = wc_get_product($variation_id);

                                    // Get the color attribute value - FIXED: proper attribute key
                                    $color_key = 'attribute_' . $attribute;
                                    $color = isset($variation['attributes'][$color_key]) ? $variation['attributes'][$color_key] : '';

                                    if (empty($color)) {
                                        continue; // Skip if no color attribute
                                    }

                                    $image = $variation['image']['src'] ?? '';

                                    // Get term for label
                                    $term = get_term_by('slug', $color, $attribute);
                                    $label = $term ? $term->name : $color;

                                    // Get image for swatch (use variation image or fallback)
                                    $swatch_image = $image ? $image : wc_placeholder_img_src();

                                    echo '<div class="image-swatch-wrapper" style="display: inline-block; text-align: center; margin: 5px;">';
                                    echo '<div style="font-size: 12px; margin-bottom: 3px;">' . esc_html($label) . '</div>';
                                    echo '<div class="image-swatch" 
            data-value="' . esc_attr($color) . '" 
            data-variation-id="' . esc_attr($variation_id) . '" 
            data-image="' . esc_url($image) . '"
            data-price="' . esc_attr($variation['display_price']) . '"
            data-sku="' . esc_attr($variation['sku']) . '"
            title="' . esc_attr($label) . '"
            style="background-image: url(' . esc_url($swatch_image) . ');
                   width: 50px; height: 50px; 
                   background-size: cover;
                   background-position: center;
                   border: 2px solid #ccc;
                   display: inline-block;
                   cursor: pointer;
                   border-radius: 5px;">
        </div>';
                                    echo '</div>';
                                }

                                echo '</div>';
                            }
                            ?>
                            <?php
                            do_action('woocommerce_before_add_to_cart_button'); ?>
                            <?php

                            if ($product->is_type('variable')) {
                                ?>
                                <!-- FIXED: Proper form structure -->
                                <form class="variations_form cart" method="post" enctype="multipart/form-data"
                                    data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                                    data-product_variations='<?php echo wp_json_encode($available_variations); ?>'>
                                    <?php
                                    // Add this right after getting available_variations
                                    echo '<pre style="background: #f0f0f0; padding: 10px; margin: 10px 0;">';
                                    echo 'Debug - Available Variations: ';
                                    var_dump($available_variations);
                                    echo '</pre>';
                                    ?>
                                    <!-- FIXED: Proper select with all options -->
                                    <select name="attribute_pa_color" id="attribute_pa_color"
                                        data-attribute_name="attribute_pa_color"
                                        style="position: absolute; left: -9999px; opacity: 0;">
                                        <option value="">Choose an option</option>
                                        <?php
                                        $terms = wc_get_product_terms($product->get_id(), 'pa_color', array('fields' => 'all'));
                                        foreach ($terms as $term) {
                                            echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                                        }
                                        ?>
                                    </select>

                                    <div class="cart-number">
                                        <div class="incrementor display">
                                            <button type="button" class="minus operator">-</button>
                                            <span class="operand">
                                                <input type="number" id="quantity_input" class="input-text qty text value"
                                                    min="1" max="1000" name="quantity" value="1" title="Qty" size="4"
                                                    pattern="[0-9]*" inputmode="numeric">
                                            </span>
                                            <button type="button" class="plus operator">+</button>
                                        </div>

                                        <div class="button">
                                            <!-- FIXED: All required hidden inputs -->
                                            <input type="hidden" name="product_id"
                                                value="<?php echo esc_attr($product->get_id()); ?>">
                                            <input type="hidden" name="add-to-cart"
                                                value="<?php echo esc_attr($product->get_id()); ?>">
                                            <input type="hidden" name="variation_id" class="variation_id" value="0">

                                            <button type="submit" class="single_add_to_cart_button main-button cart-button">
                                                <?php echo esc_html($product->single_add_to_cart_text()); ?>
                                            </button>

                                            <?php do_action('woocommerce_after_add_to_cart_button'); ?>

                                            <div class="like-button">
                                                <?php echo do_shortcode("[ti_wishlists_addtowishlist loop=yes]"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php } else {
                                ?>
                                <form class="cart" method="post" enctype='multipart/form-data'>
                                    <div class="cart-number">
                                        <div class="incrementor display">
                                            <button type="button" class="minus operator">-</button>
                                            <span class="operand"> <input type="number" id="quantity_input"
                                                    class="input-text qty text value" min="0" max="1000" name="quantity"
                                                    value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric"></span>
                                            <button type="button" class="plus operator">+</button>
                                        </div>
                                        <div class="button">
                                            <input type="hidden" name="add-to-cart"
                                                value="<?php echo absint($product->get_id()); ?>">
                                            <button type="submit" name="add-to-cart"
                                                value="<?php echo esc_attr($product->get_id()); ?>"
                                                class="single_add_to_cart_button main-button cart-button"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
                                            <?php do_action('woocommerce_after_add_to_cart_button'); ?>

                                            <div class="like-button">
                                                <?php
                                                echo do_shortcode("[ti_wishlists_addtowishlist loop=yes]");
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?>

                            <!-- <div class="cart-number">
                                <div class="display">
                                    <span class="operator">-</span>
                                    <span class="operand"><input type="number"></span>
                                    <span class="operator">+</span>
                                </div>
                                <div class="button">
                                    <button class="main-button cart-button">
                                        <span class="icon"><i class="fa-solid fa-cart-shopping"></i></span>
                                        <span class="text">Add To Cart</span>
                                    </button>
                                    <div class="like-button">
                                        <i class="fa-regular fa-heart"></i>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                    </div>
                    <div class="bottom">
                        <section class="section product-tab-section">
                            <div class="inner">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-product-images-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-product-images" type="button" role="tab"
                                            aria-controls="pills-snacks" aria-selected="true">Product Images</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-product-description-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-product-description" type="button" role="tab"
                                            aria-controls="pills-product-description" aria-selected="false">Product
                                            Description</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-shipping-policy-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-shipping-policy" type="button" role="tab"
                                            aria-controls="pills-shipping-policy" aria-selected="false">Shipping
                                            Policy</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active product-images-tab" id="pills-product-images"
                                        role="tabpanel" aria-labelledby="pills-product-images-tab" tabindex="0">
                                        <?php if ($product_images):

                                            foreach ($product_images as $image_id):
                                                $image_url = wp_get_attachment_image_url($image_id, 'large');
                                                $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                                ?>
                                                <img src="<?php echo esc_url($image_url); ?>">
                                                <?php
                                            endforeach;
                                        else:
                                            ?>
                                            <img src="https://www.naviforce-watch.com/wp-content/uploads/2023/04/5-282.jpg"
                                                alt="">
                                        <?php endif; ?>


                                    </div>
                                    <div class="tab-pane fade" id="pills-product-description" role="tabpanel"
                                        aria-labelledby="pills-product-description-tab" tabindex="1">
                                        <?php echo wpautop($full_description); ?>

                                    </div>
                                    <div class="tab-pane fade" id="pills-shipping-poicy" role="tabpanel"
                                        aria-labelledby="pills-shipping-poicy-tab" tabindex="2">
                                        <?php echo wpautop($shipping_policy); ?>

                                    </div>
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
                <div class="main-right">
                    <h3>
                        Recomended Products
                    </h3>
                    <div class="recent-product-list">


                        <?php $upsells = $product->get_upsell_ids();

                        if ($upsells) {
                            $args = array(
                                'post_type' => 'product',
                                'post__in' => $upsells,
                                'orderby' => 'post__in',
                                'posts_per_page' => -1,
                            );

                            $upsell_query = new WP_Query($args);

                            if ($upsell_query->have_posts()) {
                                while ($upsell_query->have_posts()) {
                                    $upsell_query->the_post();
                                    wc_get_template_part('content', 'product');
                                }
                                wp_reset_postdata();
                            }
                        }

                        ?>

                    </div>

                </div>
            </div>

        </div>
    </section>



<?php endwhile; // end of the loop. ?>

<?php
/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>

<?php
/**
 * woocommerce_sidebar hook.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
// do_action( 'woocommerce_sidebar' );
?>
<?php
/**
 * Hook: woocommerce_after_single_product.
 */
do_action('woocommerce_after_single_product');
?>
<script>
    // Complete WooCommerce Variation Handler with Debug
    document.addEventListener('DOMContentLoaded', function () {
        console.log('🚀 Variation handler initializing...');

        const swatches = document.querySelectorAll('.image-swatch');
        const variationForm = document.querySelector('form.variations_form');
        const select = variationForm?.querySelector('select[name="attribute_pa_color"]');

        console.log('Found elements:', {
            swatches: swatches.length,
            variationForm: !!variationForm,
            select: !!select
        });

        if (!variationForm || !select) {
            console.error('❌ Required elements not found!');
            return;
        }

        // Debug: Check available variations
        const variationsData = variationForm.getAttribute('data-product_variations');
        if (variationsData) {
            const variations = JSON.parse(variationsData);
            console.log('🔍 Available variations:', variations);

            // Log each variation's attributes
            variations.forEach((variation, index) => {
                console.log(`Variation ${index}:`, {
                    id: variation.variation_id,
                    attributes: variation.attributes,
                    sku: variation.sku
                });
            });
        }

        // Initialize WooCommerce variation form when jQuery is ready
        jQuery(document).ready(function ($) {
            console.log('📝 Initializing WooCommerce variation form...');

            $('.variations_form').each(function () {
                $(this).wc_variation_form();
            });

            // Debug: Check if form is properly initialized
            setTimeout(() => {
                const wcData = $(variationForm).data('wc_variation_form');
                console.log('WC Variation Form Data:', wcData);
            }, 100);
        });

        // Handle swatch clicks
        swatches.forEach(function (swatch, index) {
            console.log(`Swatch ${index}:`, {
                value: swatch.dataset.value,
                variationId: swatch.dataset.variationId,
                image: swatch.dataset.image
            });

            swatch.addEventListener('click', function (e) {
                e.preventDefault();

                const value = swatch.dataset.value;
                const variationId = swatch.dataset.variationId;

                console.log('🎯 Swatch clicked:', {
                    value: value,
                    variationId: variationId,
                    selectCurrentValue: select.value
                });

                if (!value) {
                    console.error('❌ No value found for swatch');
                    return;
                }

                // Remove selected class from all swatches
                swatches.forEach(el => el.classList.remove('selected'));
                swatch.classList.add('selected');

                // Set the select value
                select.value = value;
                console.log('🔄 Select value set to:', select.value);

                // Trigger multiple events to ensure WooCommerce responds
                select.dispatchEvent(new Event('change', { bubbles: true }));

                // Use jQuery to trigger WooCommerce events
                jQuery(select).trigger('change');
                jQuery(variationForm).trigger('check_variations');

                console.log('📡 Events triggered');
            });
        });

        // Listen for WooCommerce variation events with detailed logging
        jQuery(variationForm).on('found_variation', function (event, variation) {
            console.log('✅ FOUND_VARIATION event fired!');
            console.log('Variation data:', variation);

            // Update variation_id hidden input
            const variationIdInput = variationForm.querySelector('input.variation_id');
            if (variationIdInput) {
                const oldValue = variationIdInput.value;
                variationIdInput.value = variation.variation_id;
                console.log(`🔄 Updated variation_id: ${oldValue} → ${variation.variation_id}`);
            } else {
                console.error('❌ variation_id input not found!');
            }

            // Update price display
            const priceWrapper = document.getElementById('custom-price');
            if (priceWrapper && variation.price_html) {
                priceWrapper.innerHTML = variation.price_html;
                console.log('💰 Price updated');
            }

            // Update SKU display
            const skuField = document.getElementById('custom-sku');
            if (skuField && variation.sku) {
                skuField.textContent = 'SKU: ' + variation.sku;
                console.log('🏷️ SKU updated to:', variation.sku);
            }

            // Update stock status
            const stockDiv = document.querySelector('.stock');
            if (stockDiv) {
                if (variation.is_in_stock) {
                    stockDiv.innerHTML = '<span class="in-stock">In Stock</span>';
                } else {
                    stockDiv.innerHTML = '<span class="out-stock">Out of Stock</span>';
                }
                console.log('📦 Stock status updated');
            }
        });

        jQuery(variationForm).on('reset_data', function () {
            console.log('🔄 RESET_DATA event fired');

            // Reset variation_id
            const variationIdInput = variationForm.querySelector('input.variation_id');
            if (variationIdInput) {
                variationIdInput.value = '0';
                console.log('🔄 Reset variation_id to 0');
            }

            // Reset visual selection
            swatches.forEach(el => el.classList.remove('selected'));
            console.log('🎨 Visual selection reset');
        });

        jQuery(variationForm).on('hide_variation', function () {
            console.log('❌ HIDE_VARIATION event fired');
        });

        jQuery(variationForm).on('show_variation', function (event, variation) {
            console.log('👁️ SHOW_VARIATION event fired:', variation);
        });

        // Form submission validation with detailed logging
        variationForm.addEventListener('submit', function (e) {
            const variationIdInput = variationForm.querySelector('input.variation_id');
            const variationId = variationIdInput ? variationIdInput.value : '0';
            const selectedAttribute = select.value;

            console.log('📤 Form submission attempt:', {
                variationId: variationId,
                selectedAttribute: selectedAttribute,
                formData: new FormData(variationForm)
            });

            if (!variationId || variationId === '0') {
                e.preventDefault();
                console.error('❌ Form submission blocked - no variation selected');
                alert('Please select a color option before adding to cart.');
                return false;
            }

            console.log('✅ Form submission allowed');
        });

        // Debug helper - check current state
        window.debugVariations = function () {
            console.log('🔍 Current state debug:');
            console.log('Select value:', select.value);
            console.log('Variation ID input:', variationForm.querySelector('input.variation_id')?.value);
            console.log('Selected swatch:', document.querySelector('.image-swatch.selected')?.dataset);
            console.log('Form data:', new FormData(variationForm));
        };

        console.log('✅ Variation handler initialized. Use debugVariations() in console to check state.');
    });
</script>

<?php
get_footer('shop');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

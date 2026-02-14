<?php ?>
<section class="section landing-hero-section">
  <div class="image">
    <img src="https://zimsonwatches.com/cdn/shop/articles/Fossil-Blog-Image.png?v=1710996978&width=1100" alt="">
  </div>
  <div class="container">
    <div class="inner">

    </div>
  </div>
</section>
<section class="section landing-stat-box-section">
  <div class="container">
    <div class="inner">
      <div class="landing-stat-box">
        <div class="icon"><i class="fa-solid fa-money-bill"></i></div>
        <div class="details">
          <h4>Cash On Delivery</h4>
          <p>Payment Method</p>
        </div>
      </div>
      <div class="landing-stat-box">
        <div class="icon"><i class="fa-solid fa-dollar-sign"></i></div>
        <div class="details">
          <h4>Money Back Guarantee</h4>
          <p>7 Days Returned/Exchange
          </p>
        </div>
      </div>
      <div class="landing-stat-box">
        <div class="icon"><i class="fa-solid fa-truck-fast"></i></div>
        <div class="details">
          <h4>Free shipping</h4>
          <p>Logistic Delivery</p>
        </div>
      </div>
      <div class="landing-stat-box">
        <div class="icon"><i class="fa-solid fa-phone-volume"></i></div>
        <div class="details">
          <h4>Our Support</h4>
          <p>+923419300003</p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="section landing-category-section">
  <div class="container">
    <div class="inner">
      <div class="section-heading-container">
        <h5 class="section-heading-top">Diverse</h5>
        <h3 class="section-heading">Our Categories</h3>
      </div>
      <div class="topics">
        <?php
        $taxonomy = 'product_cat';
        $orderby = 'name';
        $show_count = false;
        $pad_counts = false;
        $hierarchical = true;
        $title = '';
        $empty = false;

        $args = array(
          'taxonomy' => $taxonomy,
          'orderby' => $orderby,
          'show_count' => $show_count,
          'pad_counts' => $pad_counts,
          'hierarchical' => $hierarchical,
          'title_li' => $title,
          'hide_empty' => $empty,
        );

        $product_categories = get_terms($args);

        if (!empty($product_categories) && !is_wp_error($product_categories)) {
          ?>
          <div class="swiper cat-slider">
            <div class="cat-swiper-pagination"></div>
            <div class="swiper-wrapper">
              <?php
              foreach ($product_categories as $category) {
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image_url = wp_get_attachment_url($thumbnail_id);
                $term_link = get_term_link($category);
                ?>
                <div class="swiper-slide category-box">
                  <div class="image">
                    <img src=<?php echo esc_url($image_url) ?> alt=<?php echo esc_attr($category->name) ?>>;
                  </div>
                  <div class="shade"></div>
                  <div class="details">
                    <h4><?php echo esc_html($category->name) ?></h4>
                    <a href=<?php echo esc_url($term_link); ?>>View <span><i class="fa-solid fa-arrow-right"></i></span></a>
                  </div>

                </div>

              <?php } ?>
            </div>
          </div>
                  <?php
        } else {
          echo '<p>No product categories found.</p>';
        }
        ?>


              </div>


            </div>
          </div>

</section>


<section class="section landing-product-section">
  <div class="container">
    <div class="inner">
      <div class="section-heading-container">
        <h5 class="section-heading-top">Best & New</h5>
        <h3 class="section-heading">Our Featured Products</h3>

      </div>
      <div class="topics">



        <?php
        // Query featured products
        // The tax query
        $tax_query[] = array(
          'taxonomy' => 'product_visibility',
          'field' => 'name',
          'terms' => 'featured',
          'operator' => 'IN', // or 'NOT IN' to exclude feature products
        );


        $args = array(
          'post_type' => 'product',
          'posts_per_page' => 10, // Adjust the number of products to display
          'tax_query' => $tax_query // <===
        
        );

        $featured_products = new WP_Query($args);

        // Check if there are featured products
        if ($featured_products->have_posts()): ?>

          <?php while ($featured_products->have_posts()):
            $featured_products->the_post();
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

            <div class="product-box">
              <a class="product-link" href="<?php the_permalink(); ?>" class="product-link"></a>
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
              <div class="like-button">
                <?php
                echo do_shortcode("[ti_wishlists_addtowishlist loop=yes]");
                ?>
              </div>

              <div class="cart-options">
                <?php if ($product->is_in_stock()): ?>
                  <?php woocommerce_template_loop_add_to_cart(array('class' => 'button add_to_cart_button ajax_add_to_cart')); ?>
                <?php else: ?>
                  <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>"
                    class="button out-of-stock"><?php esc_html_e('Out Of Stock', 'woocommerce'); ?></a>
                <?php endif; ?>
                <a href="<?php echo wc_get_cart_url(); ?>" class="button view-cart-button" style="display:none;"><i
                    class="fa-solid fa-cart-shopping"></i></a>

              </div>
              <div class="details">
                <p class="product-cat">
                  <?php foreach ($product_categories as $category): ?>
                    <a href="<?php echo get_term_link($category); ?>"><?php echo esc_html($category->name); ?></a>
                  <?php endforeach; ?>
                </p>

                <h4 class="product-title"><?php the_title(); ?></h4>
                <h5>nf-80293h</h5>
                <h4 class="price-box">
                  <?php if ($is_on_sale): ?>
                    <span class="org-price"><?php echo wc_price($regular_price); ?></span>
                    <span class="slashed-price"><?php echo wc_price($sale_price); ?></span>
                  <?php else: ?>
                    <span class="org-price"><?php echo wc_price($regular_price); ?></span>
                  <?php endif; ?>

                </h4>
                <!-- <a href="">View <span><i class="fa-solid fa-arrow-right"></i></span></a> -->
              </div>
            </div>

          <?php endwhile; ?>

          <?php wp_reset_postdata(); ?>
        <?php else: ?>
          <p>No featured products found</p>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>
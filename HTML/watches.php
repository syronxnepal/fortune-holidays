<?php ?>
<section class="section watches-page">
    <div class="container">
        <div class="inner">
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
                <div class="category-container">
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
                                <a href=<?php echo esc_url($term_link); ?>>View <span><i
                                            class="fa-solid fa-arrow-right"></i></span></a>
                            </div>

                        </div>

                    <?php } ?>
                    </ul>
                    <?php
            } else {
                echo '<p>No product categories found.</p>';
            }
            ?>


            </div>
        </div>
</section>
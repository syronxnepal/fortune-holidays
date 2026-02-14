<?php ?>


<section class="section offer">
  <div class="container">
    <div class="inner">
      <div class="section-heading-container">
        <h5 class="section-heading-top">What We Offer</h5>
        <h2 class="section-heading">Our Services</h2>
      </div>
      <div class="topics">
        <?php
        $args = array(
          'post_type' => 'service', // Custom post type
          'orderby' => 'date',
          'order' => 'DESC'
        );

        $recent_posts = new WP_Query($args);

        if ($recent_posts->have_posts()):
          while ($recent_posts->have_posts()):
            $recent_posts->the_post();
            ?>

            <div class="swiper-slide offer-box">
              <div class="image">
                <?php
                // Fetch the image custom field
                $image = get_post_meta(get_the_ID(), 'top_image', true);
                $image_url = wp_get_attachment_image_src($image, 'full')[0];

                if (!empty($image_url)): ?>
                  <img src="<?php echo esc_url($image_url); ?>" alt="">
                <?php else: ?>
                  <img src="path-to-placeholder.jpg" alt="Default Image">
                <?php endif; ?>
              </div>
              <div class="details">
                <h4>
                  <?php
                  // Fetch the title custom field
                  $title = get_post_meta(get_the_ID(), 'title', true);
                  echo esc_html($title ?: 'Untitled'); // Fallback if empty
                  ?>
                </h4>
                <p>
                  <?php
                  // Fetch and trim description to one line (approx. 15-20 words)
                  $description = get_post_meta(get_the_ID(), 'description', true);
                  echo esc_html(wp_trim_words($description, 15, '...'));
                  ?>
                </p>

                <a class="button" href="<?php echo the_permalink(); ?>">
                  <button class="main-button">Learn More</button>
                </a>
              </div>
              <div class="info-box">
                <h4>
                  <?php
                  // Fetch the title custom field
                  $title = get_post_meta(get_the_ID(), 'title', true);
                  echo esc_html($title ?: 'Untitled'); // Fallback if empty
                  ?>
                </h4>
                <a href="<?php echo the_permalink(); ?>">Learn More <span><i
                      class="fa-solid fa-arrow-right"></i></span></a>
              </div>
            </div>

            <?php
          endwhile;
          wp_reset_postdata(); // Reset query after loop
        else:
          echo '<p>No Services found.</p>';
        endif;
        ?>


      </div>

    </div>
  </div>
</section>
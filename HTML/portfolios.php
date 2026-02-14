<?php ?>

<section class="section  portfolio-page">
  <div class="container">
    <div class="inner">
      <?php
      $args = array(
        'post_type' => 'portfolio', // Replace 'tours' with the name of your custom post type
        'posts_per_page' => 10, // Number of posts to display
        'orderby' => 'date', // Order by date
        'order' => 'DESC' // Show the most recent posts first
      );

      $recent_posts = new WP_Query($args);

      if ($recent_posts->have_posts()):
        ?>

        <div class="portfolio-grid">

          <?php while ($recent_posts->have_posts()):
            $recent_posts->the_post();
            ?>

            <div class="box">
              <div class="image">
                <img src=<?php
                $image = get_post_field('image');
                $image_url = wp_get_attachment_image_src($image, 'medium')[0];

                echo $image_url; ?> alt="">
              </div>
              <div class="shade"></div>
              <div class="texts">
                <h5>Masonry</h5>
                <h4><?php the_title(); ?></h4>
                <a class="more" href="<?php the_permalink(); ?>">
                  <span class="text">Find Out More</span>
                  <span class="button">+</span>
                </a>
              </div>
            </div>

            <?php
          endwhile;
          ?>
        </div>
        <?php
        wp_reset_postdata();
      else:
        echo 'No portfolio found.';
      endif;
      ?>

    </div>
  </div>
</section>
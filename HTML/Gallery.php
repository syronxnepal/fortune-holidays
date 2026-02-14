<?php ?>
<section class="section gallery-section">
  <div class="container">
    <div class="inner">
      <?php
      $args = array(
        'post_type' => 'gallery',
        'posts_per_page' => -1, // Get all posts
      );

      // The custom query
      $gallery_query = new WP_Query($args);

      // Loop through each gallery post
      if ($gallery_query->have_posts()): ?>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <?php
          $index = 0;
          while ($gallery_query->have_posts()):
            $gallery_query->the_post();
            $class_name = ($index == 0) ? 'active' : '';
            $noSpaces = str_replace(' ', '', get_the_title());

            ?>
            <li class="nav-item" role="presentation">
              <button class="nav-link <?php echo $class_name; ?>" id="pills-<?php echo $noSpaces; ?>-tab"
                data-bs-toggle="pill" data-bs-target="#pills-<?php echo $noSpaces; ?>" type="button" role="tab"
                aria-controls="pills-<?php echo $noSpaces; ?>" aria-selected="true"><?php echo $noSpaces; ?></button>
            </li>
            <?php
            $index++;
          endwhile;
          ?>
        </ul>
        <?php
      else:
        echo '<p>No gallery posts found.</p>';
      endif;

      // Reset the query
      wp_reset_postdata();

      ?>

      <div class="tab-content" id="pills-tabContent">
        <?php
        $args = array(
          'post_type' => 'gallery',
          'posts_per_page' => -1, // Get all posts
        );

        // The custom query
        $gallery_query = new WP_Query($args);
        // Loop through each gallery post
        if ($gallery_query->have_posts()):
          while ($gallery_query->have_posts()):
            $gallery_query->the_post();

            // Get the gallery field
            $gallery = get_field('gallery'); // Adjust the field name if needed
            $count = 0;
            $noSpaces = str_replace(' ', '', get_the_title());

            ?>
            <?php
            if ($gallery):
              $class_name = ($count == 0) ? 'active' : '';

              ?>

              <div class="tab-pane fade show <?php echo $class_name; ?>" id="pills-<?php echo $noSpaces; ?>" role="tabpanel"
                aria-labelledby="pills-<?php echo $noSpaces; ?>-tab" tabindex="<? echo $count; ?>">
                <div id="<?php echo $noSpaces; ?>">

                  <?php foreach ($gallery as $image_id):
                    $image_url = wp_get_attachment_image_url($image_id, 'large');
                    $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    ?>
                    <a href="<?php echo esc_url($image_url); ?>">
                      <img src="<?php echo esc_url($image_url); ?>">
                    </a>
                    <?php
                  endforeach;
                  ?>
                </div>
              </div>
              <?php
            endif;
            $count++;

          endwhile;
        endif;
        // Reset the query
        wp_reset_postdata();
        ?>
      </div>
    </div>
  </div>
</section>
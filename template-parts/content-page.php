<?php

$topTitle = get_post_field('top_title');
$topSubTitle = get_post_field('top_subtitle');
$topImage = get_post_field('top_image');
$image_url = wp_get_attachment_image_src($topImage, 'full')[0];

if (!empty($topTitle) && !empty($topImage)) {
  ?>
  <section class="page-top">
    <div class="page-image">
      <img src=<?php echo $image_url; ?> alt="" />
      <div class="shade"></div>
    </div>
    <div class="container">
		      <p class="page-top-desc">
        Home <span class="icon"><i class="fa-solid fa-right-long"></i></span> <span class="text"> <?php echo get_the_title(); ?></span>
		</p>
      <h1 class="page-top-header"><?php echo $topTitle; ?>
        
      </h1>


    </div>
  </section>
  <?php
}
the_content();
?>
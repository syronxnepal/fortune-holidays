<a class="blog-box" href="<?php the_permalink(); ?>">
    <div class="blog-image">
        <img src="<?php the_post_thumbnail_url(); ?>" alt="" />
    </div>
    <div class="blog-info">
        <h3 class="blog-title">
            <?php the_title(); ?>
        </h3>
        <p class="blog-time"><?php the_date(); ?></p>
    </div>
</a>
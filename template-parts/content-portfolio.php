<?php

$topTitle = get_post_field('top_title');
$topSubTitle = get_post_field('top_subtitle');
$topImage = get_post_field('top_image');
$image_url = wp_get_attachment_image_src($topImage, 'full')[0];

?>
<section class="page-top">
    <div class="page-image">
        <img src=<?php echo $image_url; ?> alt="" />
        <div class="shade"></div>
    </div>
    <div class="container">
        <h1 class="page-top-header"><?php echo $topTitle; ?>

        </h1>
        <p class="page-top-desc">
            Home > <span> <?php echo get_the_title(); ?></span>

    </div>
</section>

<section class="section portfolio-info">
    <div class="container">
        <div class="inner">
            <div class="left">
                <div class="section-heading-container">
                    <h3 class="section-heading">Service Name</h3>
                </div>
                <div class="topics">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At qui nisi aliquid, commodi laborum
                        culpa accusamus enim quisquam nostrum eligendi officiis hic doloremque doloribus. Quasi, magni.
                        Quo earum doloribus repellat!</p>
                </div>
            </div>
            <div class="right">
                <div class="section-heading-container">
                    <h3 class="section-heading">Service Info</h3>
                </div>
                <div class="topics">
                    <div class="list-item">
                        <span class="title">Expertise :</span>
                        <span class="text">Intermediatery</span>
                    </div>
                    <div class="list-item">
                        <span class="title">Date :</span>
                        <span class="text">2024/01/20 - 2024/02/15</span>
                    </div>
                    <div class="list-item">
                        <span class="title">Total Workers :</span>
                        <span class="text">10</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section portfolio-images">
    <div class="container">
        <div class="inner">
            <div class="service-info">
                <div class="section-heading-container">
                    <h3 class="section-heading">Service Info</h3>
                </div>
                <div class="topics">
                    <div class="list-item">
                        <span class="title">Expertise :</span>
                        <span class="text">Intermediatery</span>
                    </div>
                    <div class="list-item">
                        <span class="title">Date :</span>
                        <span class="text">2024/01/20 - 2024/02/15</span>
                    </div>
                    <div class="list-item">
                        <span class="title">Total Workers :</span>
                        <span class="text">10</span>
                    </div>
                </div>
            </div>
            <div id="portfolio-gallery">
                <?php
                // Get the gallery field
                $gallery = get_field('gallery'); // Adjust the field name if needed
                $count = 0;
                $noSpaces = str_replace(' ', '', get_the_title());

                ?>
                <?php
                if ($gallery):
                    $class_name = ($count == 0) ? 'active' : '';

                    ?>
                    <div id="portfolio-gallery">

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
                    <?php
                endif;
                $count++;

                ?>
            </div>
        </div>

</section>
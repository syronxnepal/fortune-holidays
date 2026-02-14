<?php

$topTitle = get_post_field('top_title');
$topSubTitle = get_post_field('top_subtitle');
$description = get_post_field('description');

$topImage = get_post_field('top_image');
$image_url = wp_get_attachment_image_src($topImage, 'full')[0];

?>



<section class="page-top full-page-top">
        <div class="page-image">
        <img src=<?php echo $image_url; ?> alt="" />
        <div class="shade"></div>
        </div>
        <div class="container">
        <h1 class="page-top-header"><?php echo $topTitle; ?>
        <p class="page-top-desc">"<?php echo $topSubTitle; ?>"          </p>
        </div>
    </section>

    <section class="section service-section">
        <div class="container">
            <div class="inner">
                <div class="left">

                    <div class="section-heading-container">
                        <h5 class="section-heading-top">Description</h5>
                        <h2 class="section-heading">Everything In Detail</h2>
                    </div>
                    <div class="topics">
                        <?php echo $description;?>
                    </div>
                </div>
                <div class="right">
                    <div class="contact-box">
                        <div class="section-heading-container">
                            <h5 class="section-heading-top">Get a free quote</h5>
                            <h2 class="section-heading">Contact Us</h2>
                        </div>
                        <div class="topics">
                            <div class="topics contact-page-form">
                                <form action="">
                                    <div class="inputContainer">
                                        <label htmlFor="">Your Name (Required)</label>
                                        <input type="text" />
                                    </div>
                                    <div class="inputContainer">
                                        <label htmlFor="">Your Email (Required)</label>
                                        <input type="text" />
                                    </div>
                                    <div class="inputContainer">
                                        <label htmlFor="">Your Phone Number (Required)</label>
                                        <input type="text" />
                                    </div>
                                    <div class="inputContainer">
                                        <label htmlFor="">Your Address (Required)</label>
                                        <input type="text" />
                                    </div>
                                    <div class="inputContainer input-textarea">
                                        <label htmlFor="">Your Message (Optional)</label>
                                        <textarea type="text"></textarea>
                                    </div>
                                    <div class="inputContainer">
                                        <button class="main-button">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

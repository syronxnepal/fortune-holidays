<?php

function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 150,
		'single_image_width'    => 300,

        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
	) );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
// function create_wishlist_table() {
//     global $wpdb;
//     $table_name = $wpdb->prefix . 'wishlist';
//     $charset_collate = $wpdb->get_charset_collate();

//     $sql = "CREATE TABLE $table_name (
//         id mediumint(9) NOT NULL AUTO_INCREMENT,
//         user_id bigint(20) NOT NULL,
//         product_id bigint(20) NOT NULL,
//         PRIMARY KEY  (id)
//     ) $charset_collate;";

//     require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//     dbDelta($sql);
// }
// add_action('after_setup_theme', 'create_wishlist_table');
// 
// 
// 
// author column to the products table
add_filter('manage_edit-product_columns', 'add_author_column', 10, 1);
function add_author_column($columns) {
    $new_columns = array();

    foreach ($columns as $key => $column) {
        $new_columns[$key] = $column;

        // Insert the author column after the title column
        if ($key === 'name') {
            $new_columns['product_author'] = __('Author', 'your-textdomain');
        }
    }

    return $new_columns;
}
// author data in the custom column
add_action('manage_product_posts_custom_column', 'display_author_column', 10, 2);
function display_author_column($column, $post_id) {
    if ($column === 'product_author') {
        $post = get_post($post_id);
        $author_id = $post->post_author;
        $author_name = get_the_author_meta('display_name', $author_id);
        echo esc_html($author_name);
    }
}
//  author column sorting
add_filter('manage_edit-product_sortable_columns', 'make_author_column_sortable');
function make_author_column_sortable($columns) {
    $columns['product_author'] = 'author';
    return $columns;
}

// Handle sorting by author
add_action('pre_get_posts', 'sort_products_by_author');
function sort_products_by_author($query) {
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ($orderby === 'author') {
        $query->set('orderby', 'author');
    }
}
// CSS for author column
add_action('admin_head', 'style_author_column');
function style_author_column() {
    echo '<style>
        .column-product_author { width: 15%; }
    </style>';
}

 function footer_bg(){
    register_sidebar(array(
        'name' => 'Footer Background',
        'id' => 'Footer-Background',
        'description' => 'It contains footer bg',
        'before_widget' => '<div class="footer-bg">',
        'after_widget' => '</div>'
    ));
}
add_action( 'widgets_init', 'footer_bg');

function footer_about_widget(){
    register_sidebar(array(
        'name' => 'Footer About',
        'id' => 'Footer-About',
        'description' => 'It contains footer about',
        'before_widget' => '<div class="footer-about-container">',
        'after_widget' => '</div>'
    ));
}
add_action( 'widgets_init', 'footer_about_widget');
function social_links_widget(){
    register_sidebar(array(
        'name' => 'Social Links',
        'id' => 'Social-Links',
        'description' => 'It contains social links',
        'before_widget' => '<div class="social-icons-container">',
        'after_widget' => '</div>'
    ));
}
add_action( 'widgets_init', 'social_links_widget');


function email_widget(){
    register_sidebar(array(
        'name' => 'Email',
        'id' => 'Email',
        'description' => 'It contains email address',
        'before_widget' => '<div class="email-container">',
        'after_widget' => '</div>'
    ));
}
add_action( 'widgets_init', 'email_widget');


function contacts_widget(){
    register_sidebar(array(
        'name' => 'Contact Numbers',
        'id' => 'Contact-Numbers',
        'description' => 'It contains contact numbers',
        'before_widget' => '<div class="contact-container">',
        'after_widget' => '</div>'
    ));
}
add_action( 'widgets_init', 'contacts_widget');

function address_widget(){
    register_sidebar(array(
        'name' => 'Address',
        'id' => 'Address',
        'description' => 'It contains address',
        'before_widget' => '<div class="address-container">',
        'after_widget' => '</div>'
    ));
}
add_action( 'widgets_init', 'address_widget');



class My_Custom_Nav_Walker extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        // Add the dropdown icon for menu items with children
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $item_output .= ' +';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

function jujumenu(){
    $location = array(
        'category' => 'Category Menu',
        'pages' => 'Pages Menu',
        'support' => 'Support Menu'
    );
    register_nav_menus($location);
}
add_action('init', 'jujumenu');

/**
 * Change a currency symbol
 */
add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'NPR': $currency_symbol = 'Rs.'; break;
     }
     return $currency_symbol;
}


function custom_cart_count_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        function updateCartCount() {
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'get_cart_count'
                },
                success: function(data) {
                    $('.cart-count').text(data);
                }
            });
        }

        $(document.body).on('added_to_cart removed_from_cart updated_cart_totals', function() {
            updateCartCount();
        });

        updateCartCount();
    });
    </script>
    <?php
}
add_action('wp_footer', 'custom_cart_count_script');
function get_cart_count() {
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}
add_action('wp_ajax_get_cart_count', 'get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');
function ajax_product_search() {
    $search_query = sanitize_text_field($_POST['search_query']);

    // Arguments for the main query
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
        's' => $search_query,
    );

    $search_results = new WP_Query($args);

    if ($search_results->have_posts()) :
        while ($search_results->have_posts()) : $search_results->the_post();
            ?>
            <div class="searched-product">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('thumbnail'); ?>
                    <h2><?php the_title(); ?></h2>
                </a>
            </div>
            <?php
        endwhile;
    else :
        echo '<p>' . __('No products found', 'woocommerce') . '</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_ajax_product_search', 'ajax_product_search');
add_action('wp_ajax_nopriv_ajax_product_search', 'ajax_product_search');

function woocommerce_custom_sidebar(){
    register_sidebar(array(
        'name' => 'custom_sidebar',
        'id' => 'custom_sidebar',
        'description' => 'It contains woocommerce custom sidebar',
        'before_widget' => '<div class="woocommerce-custom-sidebar-container">',
        'after_widget' => '</div>'
    ));
}
add_action( 'widgets_init', 'woocommerce_custom_sidebar');


class Custom_WC_Filter_Widget extends WP_Widget {
    public function __construct() {
        $widget_ops = array(
            'classname' => 'custom_wc_filter_widget',
            'description' => 'Custom widget for filtering by price range, categories, sub-categories, and stock.',
        );
        parent::__construct( 'custom_wc_filter_widget', 'Custom WC Filter Widget', $widget_ops );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        // Get parent categories
        $terms = get_terms( array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'parent' => 0
        ) );

        // Get selected categories from query string
        $selected_categories = isset($_GET['product_cat']) ? explode(',', $_GET['product_cat']) : array();

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            echo '<form id="custom-filter-form" method="GET" action="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">';
            
            // Price filter
            echo '<div class="price-filter">';
			            echo '<h2>' . __( 'Price Range', 'my-theme' ) . '</h2>';

            echo '<div id="price-range"></div>';
						echo '<div class="price-input-container">';
            echo '<div>';
            echo '<label for="min_price">' . __( 'Min', 'my-theme' ) . '</label>';
            echo '<input type="number" name="min_price" id="min_price_input" />';
            echo '</div>';
            echo '<div>';
            echo '<label for="max_price">' . __( 'Max', 'my-theme' ) . '</label>';
            echo '<input type="number" name="max_price" id="max_price_input" />';
            echo '</div>';
			            echo '</div>';

            echo '<input type="hidden" name="min_price" id="min_price" />';
            echo '<input type="hidden" name="max_price" id="max_price" />';
			echo '</div>';


            // Category filter
            echo '<h2>' . __( 'Category', 'my-theme' ) . '</h2>';
            echo '<ul class="custom-category-list">';
            foreach ( $terms as $term ) {
                $sub_terms = get_terms( array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => false,
                    'parent' => $term->term_id
                ) );

                echo '<li>';
				                echo '<div class="main-category-items">';

                echo '<input type="checkbox" class="category-checkbox" name="product_cat[]" value="' . esc_attr( $term->slug ) . '" id="product_cat_' . esc_attr( $term->term_id ) . '"' . (in_array($term->slug, $selected_categories) ? ' checked' : '') . '>';
                echo '<label for="product_cat_' . esc_attr( $term->term_id ) . '">' . esc_html( $term->name ) . '</label>';

                if ( ! empty( $sub_terms ) && ! is_wp_error( $sub_terms ) ) {
                    echo '<span class="toggle-sub-categories" data-target="sub_cat_' . esc_attr( $term->term_id ) . '">+</span>';
					echo '</div>';
                    echo '<ul class="sub-category-list" id="sub_cat_' . esc_attr( $term->term_id ) . '" style="display:none;">';
                    foreach ( $sub_terms as $sub_term ) {
                        echo '<li>';
                        echo '<input type="checkbox" class="category-checkbox" name="product_cat[]" value="' . esc_attr( $sub_term->slug ) . '" id="product_cat_' . esc_attr( $sub_term->term_id ) . '"' . (in_array($sub_term->slug, $selected_categories) ? ' checked' : '') . '>';
                        echo '<label for="product_cat_' . esc_attr( $sub_term->term_id ) . '">' . esc_html( $sub_term->name ) . '</label>';
                        echo '</li>';
                    }
                    echo '</ul>';
                }

                echo '</li>';
            }
            echo '</ul>';

            // Stock filter
            echo '<div class="stock-filter">';
            echo '<input type="checkbox" id="in_stock" name="in_stock" value="1"'. (isset($_GET['stock']) ? ' checked' : '') .'>';
            echo '<label for="in_stock">' . __( 'In Stock', 'my-theme' ) . '</label>';
            echo '</div>';

            // Filter button
            echo '<button type="submit" class="main-button">' . esc_html__( 'Filter', 'my-theme' ) . '</button>';
            echo '</form>';
        }

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_attr_e( 'Title:', 'my-theme' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        return $instance;
    }
}

function register_custom_wc_filter_widget() {
    register_widget( 'Custom_WC_Filter_Widget' );
}
add_action( 'widgets_init', 'register_custom_wc_filter_widget' );
function register_styles()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style(
        'main-style',
        get_template_directory_uri() . "/style.css",
        array('bootstrap-styles'),
        $version
    );
    
    wp_enqueue_style(
        'fontawesome-styles',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css',
        array(),
        "6.2.1"
    );
    wp_enqueue_style(
        'jquery-ui-styles',
        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/jquery-ui.min.css',
        array(),
        "6.2.1"
    );
    wp_enqueue_style(
        'owlCarouselDefault-styles',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css',
        array(),
        "2.3.4"
    );
    wp_enqueue_style(
        'owlCarouselMin-styles',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css',
        array(),
        "2.3.4"
    );

    wp_enqueue_style(
        'googlefonts-jost-styles',
        'https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,700;1,500&display=swap',
        array(),
        ""
    );
    wp_enqueue_style(
        'googlefonts-mons-styles',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap',
        array(),
        ""
    );
    wp_enqueue_style(
        'googlefonts-styles',
        'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Archivo:ital,wght@0,100..900;1,100..900&&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&family=Playfair+Display:ital,wght@0,400..900;1,400..900display=swap',
        array(),
        ""
    );
    
    wp_enqueue_style(
        'googlefonts-josefin-styles',
        'https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap',
        array(),
        ""
    );
    wp_enqueue_style(
        'googlefonts-bellaza-styles',
        'https://fonts.googleapis.com/css2?family=Belleza&display=swap',
        array(),
        ""
    );


    wp_enqueue_style(
        'bootstrap-styles',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css',
        array(),
        "5.2.3"
    );

    wp_enqueue_style(
        'swipper-styles',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        "11"
    );

    wp_enqueue_style(
        'linearicons-styles',
        'https://cdn.linearicons.com/free/1.0.0/icon-font.min.css',
        array(),
        "1.0.0"
    );
    
}

add_action('wp_enqueue_scripts', 'register_styles');


function register_scripts()
{

    wp_enqueue_script(
        'jquery',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js',
        array(),
        "3.6.3",
        true
    );
    wp_enqueue_script(
        'jquery-ui',
        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/jquery-ui.min.js',
        array(),
        "1.13.3",
        true
    );
    wp_enqueue_script(
        'script-bootstrap',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js',
        array(),
        "5.2.3",
        true
    );
    wp_enqueue_script(
        'script-owlCarousel',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js',
        array(),
        "2.3.4",
        true
    );
    
	
   
    wp_enqueue_script(
        'swiper-js',
        "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js",
        array(),
        "11",
        true
    );
	
	  wp_enqueue_script('wc-add-to-cart');

       wp_enqueue_script('custom-add-to-cart', get_stylesheet_directory_uri() . '/assets/js/custom-add-to-cart.js', array('jquery', 'wc-add-to-cart'), "15", true);
	
    wp_enqueue_script('custom-wishlist', get_stylesheet_directory_uri() . '/assets/js/custom-wishlist.js', array('jquery'), "7", true);
    wp_localize_script('custom-wishlist', 'wishlist_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'is_user_logged_in' => is_user_logged_in(),
        'login_url' => wp_login_url()
    ));
	
    // Localize script with cart URL
   wp_localize_script('custom-add-to-cart', 'custom_add_to_cart_params', array(
      'cart_url' => wc_get_cart_url(),
    ));
	    wp_enqueue_script('ajax-search', get_template_directory_uri() . '/assets/js/ajax-search.js', array('jquery'), "13", true);
    wp_localize_script('ajax-search', 'ajax_search_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));

    wp_enqueue_script(
        'star-rating-js',
        get_template_directory_uri() . "/assets/js/star-rating.min.js",
        array(),
        "1",
        true
    );
    wp_enqueue_script(
        'nav-js',
        get_template_directory_uri() . "/assets/js/nav.js",
        array(),
        "52",
        true
    );
    wp_enqueue_script(
        'filter-js',
        get_template_directory_uri() . "/assets/js/filter.js",
        array(),
        "4",
        true
    );
    
    wp_enqueue_script(
        'productswiper-js',
        get_template_directory_uri() . "/assets/js/productswiper.js",
        array(),
        "4",
        true
    );

    wp_enqueue_script(
        'heroswiper-js',
        get_template_directory_uri() . "/assets/js/heroswiper.js",
        array(),
        "1",
        true
    );
    wp_enqueue_script(
        'galleryswiper-js',
        get_template_directory_uri() . "/assets/js/galleryswiper.js",
        array(),
        "1",
        true
    );
    wp_enqueue_script(
        'cart-js',
        get_template_directory_uri() . "/assets/js/cart.js",
        array(),
        "3",
        true
    );
    wp_enqueue_script(
        'sidebar-js',
        get_template_directory_uri() . "/assets/js/sidebar.js",
        array(),
        "13",
        true
    );
    wp_enqueue_script(
        'customcart-js',
        get_template_directory_uri() . "/assets/js/custom-cart.js",
        array(),
        "13",
        true
    );
	
}

add_action('wp_enqueue_scripts', 'register_scripts');




// Register Custom Post Type
function custom_post_type_Sliders() {

    $labels = array(
        'name'                  => _x( 'Sliders', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Slider', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Sliders', 'text_domain' ),
        'name_admin_bar'        => __( 'Slider', 'text_domain' ),
        'archives'              => __( 'Slider Archives', 'text_domain' ),
        'attributes'            => __( 'Slider Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Slider:', 'text_domain' ),
        'all_items'             => __( 'All Sliders', 'text_domain' ),
        'add_new_item'          => __( 'Add New Slider', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Slider', 'text_domain' ),
        'edit_item'             => __( 'Edit Slider', 'text_domain' ),
        'update_item'           => __( 'Update Slider', 'text_domain' ),
        'view_item'             => __( 'View Slider', 'text_domain' ),
        'view_items'            => __( 'View Sliders', 'text_domain' ),
        'search_items'          => __( 'Search Slider', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Slider', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Slider', 'text_domain' ),
        'items_list'            => __( 'Sliders list', 'text_domain' ),
        'items_list_navigation' => __( 'Sliders list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Sliders list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Slider', 'text_domain' ),
        'description'           => __( 'Sliders Post Type', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'comments' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-Slider-alt', // You can change this icon
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable Gutenberg editor
    );
    register_post_type( 'slider', $args );

}
add_action( 'init', 'custom_post_type_Sliders', 0 );


?>
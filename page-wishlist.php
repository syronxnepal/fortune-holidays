<?php
/**
 * Template Name: Wishlist
 */

get_header();

if ( ! is_user_logged_in() ) {
    echo '<p>You must be logged in to view your wishlist. <a href="' . wp_login_url() . '">Log in</a></p>';
    get_footer();
    return;
}

global $wpdb;
$user_id = get_current_user_id();
$table_name = $wpdb->prefix . 'wishlist';
$wishlist_items = $wpdb->get_results($wpdb->prepare("SELECT product_id FROM $table_name WHERE user_id = %d", $user_id));

if ($wishlist_items) {
    echo '<ul class="wishlist-items">';
    foreach ($wishlist_items as $item) {
        $product = wc_get_product($item->product_id);
        echo '<li><a href="' . get_permalink($product->get_id()) . '">' . $product->get_name() . '</a></li>';
    }
    echo '</ul>';
} else {
    echo '<p>No items in your wishlist.</p>';
}

get_footer();
?>

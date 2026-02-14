jQuery(document).ready(function($) {
    $('.add-to-wishlist').on('click', function(e) {
        e.preventDefault();
        var button = $(this);

        if (wishlist_params.is_user_logged_in !== '1') {
            window.location.href = wishlist_params.login_url;
            return;
        }

        var product_id = button.data('product-id');

        $.ajax({
            url: wishlist_params.ajax_url,
            type: 'POST',
            data: {
                action: 'add_to_wishlist',
                product_id: product_id
            },
            success: function(response) {
                if (response.success) {
                    alert(response.data); // Or show a custom message
                } else {
                    alert(response.data);
                }
            }
        });
    });
});

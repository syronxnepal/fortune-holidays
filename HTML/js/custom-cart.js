jQuery(document).ready(function($) {
    $('.quantity-buttons .increment').on('click', function() {
        var input = $(this).prev('input.qty');
        var val = parseInt(input.val());
        var max = parseInt(input.attr('max'));
        if (val < max || max === 0) {
            input.val(val + 1).change();
        }
    });

    $('.quantity-buttons .decrement').on('click', function() {
        var input = $(this).next('input.qty');
        var val = parseInt(input.val());
        var min = parseInt(input.attr('min'));
        if (val > min) {
            input.val(val - 1).change();
        }
    });
});

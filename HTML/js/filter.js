jQuery(document).ready(function($) {

    $('#product-filter').click(function() {
        // Add class "active" to the div with id "myDiv"
        $('#filter-slider').addClass('filter-slider-on');
        $('.bg-overlay-fixed').addClass('bg-overlay-on');

    });
    $('.bg-overlay-fixed').click(function() {
        // Add class "active" to the div with id "myDiv"
        $('#filter-slider').removeClass('filter-slider-on');
        $('.bg-overlay-fixed').removeClass('bg-overlay-on');

    });
    $('.cross-filter-slider').click(function() {
        // Add class "active" to the div with id "myDiv"
        $('#filter-slider').removeClass('filter-slider-on');
        $('.bg-overlay-fixed').removeClass('bg-overlay-on');

    });
})


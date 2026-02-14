jQuery(document).ready(function($) {
    // Function to get URL parameters
    function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    }

    // Toggle sub-categories
    $('.toggle-sub-categories').on('click', function() {
        var target = $(this).data('target');
        $('#' + target).toggle();
        var text = $(this).text() == '+' ? '-' : '+';
        $(this).text(text);
    });

    // Initialize price range
    var min_price = $('#min_price_input').data('value') || 0;
    var max_price = $('#max_price_input').data('value') || 1000;

    $("#price-range").slider({
        range: true,
        min: 0,
        max: 1000,
        values: [min_price, max_price],
        slide: function(event, ui) {
            $("#min_price_input").val(ui.values[0]);
            $("#max_price_input").val(ui.values[1]);
            $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
        }
    });

    $("#amount").val("$" + $("#price-range").slider("values", 0) + " - $" + $("#price-range").slider("values", 1));
    $("#min_price_input").val($("#price-range").slider("values", 0));
    $("#max_price_input").val($("#price-range").slider("values", 1));

    $('#min_price_input, #max_price_input').on('change', function() {
        var minPrice = $('#min_price_input').val();
        var maxPrice = $('#max_price_input').val();
        $("#price-range").slider("values", [minPrice, maxPrice]);
        $("#amount").val("$" + minPrice + " - $" + maxPrice);
    });

    // Pre-check selected categories and toggle sub-categories
    var selectedCategories = getUrlParameter('product_cat');
    if (selectedCategories) {
        var categories = selectedCategories.split(',');
        categories.forEach(function(category) {
            $('input.category-checkbox[value="' + category + '"]').prop('checked', true);
            var parentCategory = $('input.category-checkbox[value="' + category + '"]').closest('ul.sub-category-list').prev('.toggle-sub-categories');
            if (parentCategory.length) {
                var target = parentCategory.data('target');
                $('#' + target).show();
                parentCategory.text('-');
            }
        });
    }

    // Form submission handling
    $('#custom-filter-form').on('submit', function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var params = [];

        // Collect category parameters
        var selectedCategories = [];
        $('.category-checkbox:checked').each(function() {
            selectedCategories.push($(this).val());
        });
        if (selectedCategories.length > 0) {
            params.push('product_cat=' + selectedCategories.join(','));
        }

        // Collect price parameters
        var minPrice = $('#min_price_input').val();
        var maxPrice = $('#max_price_input').val();
        if (minPrice && maxPrice) {
            params.push('min_price=' + minPrice);
            params.push('max_price=' + maxPrice);
        }

        // Collect stock parameter
        if ($('#in_stock').is(':checked')) {
            params.push('stock=1');
        }

        // Create query string
        var queryString = params.join('&');

        // Redirect with the query string
        window.location.href = url + '?' + queryString;
    });
});

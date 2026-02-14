document.addEventListener('DOMContentLoaded', function() {

    var quantityInput = document.getElementById('quantity_input');
    var minusButton = document.querySelector('.incrementor .minus');
    var plusButton = document.querySelector('.incrementor .plus');

    minusButton.addEventListener('click', function() {
        var currentValue = parseInt(quantityInput.value);
        if (currentValue > parseInt(quantityInput.min)) {
            quantityInput.value = currentValue - 1;
        }
    });

    plusButton.addEventListener('click', function() {
        var currentValue = parseInt(quantityInput.value);
        if (currentValue < parseInt(quantityInput.max)) {
            quantityInput.value = currentValue + 1;
        }
    });
});

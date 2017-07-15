// Price Range
var price = document.getElementById('price');
noUiSlider.create(price, {
  start: current_rate,
  connect: true,
  range: rates
});
price.noUiSlider.on('update', function(values, handle) {
  var value = values[handle];
  if (handle) {
    $('#max-price').text('$' + Math.round(value));
    $('input[name="max-price"]').val(Math.round(value));
  } else {
    $('#min-price').text('$' + Math.round(value));
    $('input[name="min-price"]').val(Math.round(value));
  }
});
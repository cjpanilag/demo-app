$(document).ready(function() {
  $('#order-table').attr('hidden', true);

  $('#product-tab').click(function(event) {
    $('#product-tab').attr('class', 'nav-link active');
    $('#order-table').attr('hidden', true);

    $('#orders-tab').attr('class', 'nav-link');
    $('#product-table').removeAttr('hidden');
  });

  $('#orders-tab').click(function(event) {
    $('#orders-tab').attr('class', 'nav-link active');
    $('#product-table').attr('hidden', true);

    $('#product-tab').attr('class', 'nav-link');
    $('#order-table').removeAttr('hidden');
  });
});

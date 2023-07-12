$(document).ready(function() {
  $('#search').on('input', function(event) {
    var searchValue = $(this).val();
    var filterType;

    if (/^[a-zA-Z]+$/.test(searchValue)) {
      filterType = 'name';
    } else if (/^[0-9]+$/.test(searchValue)) {
      filterType = 'id';
    }

    if (searchValue !== '') {
      $.ajax({
        url: `http://127.0.0.1:8081/api/product?filter[${filterType}]=${searchValue}`,
        method: 'GET',
        success: function(data) {
          var product = data.data[0];
          $('#product_id').val(product.id);
          $('#name').val(product.name);
          $('#price').val(product.price);
        },
        error: function() {
          console.error('Failed to fetch data.');
        }
      });
    }

  });
});

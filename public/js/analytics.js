$(document).ready(function() {
  $.ajax({
    url: 'http://127.0.0.1:8081/api/order/analytics',
    method: 'GET',
    success: function(data) {
      $('#total_sales').text("$ " + Number(data.data.total_sales).toLocaleString('en-US'));
      $('#number_of_sales').text(Number(data.data.number_of_sales).toLocaleString('en-US'));
    },
    error: function() {
      console.error('Failed to fetch data.');
    }
  });
});


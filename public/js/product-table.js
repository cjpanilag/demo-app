let table;

$(document).ready(function() {
  $.ajax({
    url: 'http://127.0.0.1:8081/api/product',
    method: 'GET',
    success: function(data) {
      table = $('#productTable').DataTable({
        data: data.data,
        order: [],
        columns: [
          { data: 'id' },
          { data: 'name' },
          {
            data: 'price',
            render: function(data, type, row) {
              return '$ ' + Number(data).toLocaleString('en-US');
            }
          },
          {
            data: 'created_at',
            render: function(data, type, row) {
              var date = new Date(data);
              const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
              var formattedDate = date.toLocaleDateString('en', options);
              return formattedDate;
            }
          },
        ]
      });
    },
    error: function() {
      console.error('Failed to fetch data.');
    }
  });
});

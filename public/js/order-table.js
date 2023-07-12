var orderTable;
var from;
var to;

$(document).ready(function() {
  $(function() {
    start = moment().subtract(29, 'days');
    end = moment();
    function cb(start, end) {
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      // Get the selected date range values
      from = start.format('YYYY-MM-DD');
      to = end.format('YYYY-MM-DD');
      httpCall(from, to);
      orderTable.destroy();
    }
    $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, cb);
    cb(start, end);
    // Event handler for date range change
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
      // Get the selected date range values
      from = picker.startDate.format('YYYY-MM-DD');
      to = picker.endDate.format('YYYY-MM-DD');
      orderTable.destroy();
      httpCall(from, to);
    });
  });

  $('#orderTable tbody').on('click', '#btn-edit', function(event) {
    var rowData = $(this).closest('tr').find('td').map(function() {
      return $(this).text();
    }).get();
    $('#order_id').val(rowData[0]);
    $('#product_name').val(rowData[1]);
    $('#selling_price').val(rowData[2]);
    $('#tax_rate').val(rowData[4]);
    $('#total_price').val(rowData[5]);
    $('#order_at').val(rowData[6]);
    $('#quantity').val(rowData[3]);
    $('#editOrderModal').modal('show');
  });

  $('#editOrderForm').submit(function(event) {
    event.preventDefault();
    var formValues = $(this).serializeArray();
    var formData = {};
    $.each(formValues, function(index, field) {
      formData[field.name] = field.value;
    });
    console.log(formData);
    $.ajax({
      url: `http://127.0.0.1:8081/api/order/${formData.id}`,
      method: $(this).attr('method'),
      data: { 'quantity': formData.quantity },
      success: function(response) {
        alert(response.message);
        location.reload();
      },
      error: function(xhr, status, error) {
        alert(error);
      }
    });
  });

  $('#download-excel').on('click', function(event) {
    event.preventDefault();
    let from = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let to = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $.ajax({
      type: 'GET',
      cache: false,
      url: `http://127.0.0.1:8081/api/order/export?file_type=excel&filter[order_date_range]=${from},${to}`,
      xhrFields: {
        responseType: 'arraybuffer'
      }
    })
      .done(function(data, status, xmlHeaderRequest) {
        var downloadLink = document.createElement('a');
        var blob = new Blob([data],
          {
            type: xmlHeaderRequest.getResponseHeader('Content-Type')
          });
        var url = window.URL || window.webkitURL;
        var downloadUrl = url.createObjectURL(blob);
        var fileName = `order-report-${from} - ${to}`;
        if (typeof window.navigator.msSaveBlob !== 'undefined') {
          window.navigator.msSaveBlob(blob, fileName);
        } else {
          if (fileName) {
            if (typeof downloadLink.download === 'undefined') {
              window.location = downloadUrl;
            } else {
              downloadLink.href = downloadUrl;
              downloadLink.download = fileName;
              document.body.appendChild(downloadLink);
              downloadLink.click();
            }
          } else {
            window.location = downloadUrl;
          }

          setTimeout(function() {
            url.revokeObjectURL(downloadUrl);
          },
            100);
        }
      });
  });

  $('#download-pdf').on('click', function(event) {
    event.preventDefault();
    let from = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
    let to = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $.ajax({
      type: 'GET',
      cache: false,
      url: `http://127.0.0.1:8081/api/order/export?file_type=pdf&filter[order_date_range]=${from},${to}`,
      xhrFields: {
        responseType: 'arraybuffer'
      }
    })
      .done(function(data, status, xmlHeaderRequest) {
        var downloadLink = document.createElement('a');
        var blob = new Blob([data],
          {
            type: xmlHeaderRequest.getResponseHeader('Content-Type')
          });
        var url = window.URL || window.webkitURL;
        var downloadUrl = url.createObjectURL(blob);
        var fileName = `order-report-${from} - ${to}`;
        if (typeof window.navigator.msSaveBlob !== 'undefined') {
          window.navigator.msSaveBlob(blob, fileName);
        } else {
          if (fileName) {
            if (typeof downloadLink.download === 'undefined') {
              window.location = downloadUrl;
            } else {
              downloadLink.href = downloadUrl;
              downloadLink.download = fileName;
              document.body.appendChild(downloadLink);
              downloadLink.click();
            }
          } else {
            window.location = downloadUrl;
          }
          setTimeout(function() {
            url.revokeObjectURL(downloadUrl);
          },
            100);
        }
      });
  });
});

function httpCall(from, to) {
  $.ajax({
    url: `http://127.0.0.1:8081/api/order?filter[order_date_range]=${from},${to}`,
    method: 'GET',
    success: function(data) {
      orderTable = $('#orderTable').DataTable({
        data: data.data,
        order: [],
        columns: [
          { data: 'id' },
          { data: 'product.name' },
          {
            data: 'product.price',
            render: function(data, type, row) {
              return '$ ' + Number(data).toLocaleString('en-US');
            }
          },
          { data: 'quantity' },
          {
            data: 'tax.value',
            render: function(data, type, row) {
              return data + ' %';
            }
          },
          {
            data: 'total_amount',
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
          {
            targets: -1, // The last column
            data: null, // Use the entire row data
            render: function(data, type, row, meta) {
              // Build the action buttons HTML
              var editButton = '<button id="btn-edit" class="btn btn-success">Edit</button>';
              var deleteButton = '<button id="btn-delete" class="btn btn-danger">Delete</button>';

              // Return the HTML for the action buttons
              return editButton + ' ' + deleteButton;
            },
            className: 'text-center' // Optional: Add a class to center-align the content
          }
        ],
      });
    },
    error: function() {
      console.error('Failed to fetch data.');
    }
  });

  $('#orderTable tbody').on('click', '#btn-delete', function() {
    var rowData = $(this).closest('tr').find('td').map(function() {
      return $(this).text();
    }).get();
    var orderId = rowData[0];
    $.ajax({
      url: `http://127.0.0.1:8081/api/order/${orderId}`,
      method: 'DELETE',
      success: function(response) {
        alert(response.message);
        location.reload();
      },
      error: function(xhr, status, error) {
        alert(error);
      }
    });
  });
}

$(document).ready(function() {
  $('#orderForm').submit(function(event) {
    event.preventDefault();

    var formValues = $(this).serializeArray();

    var formData = {};
    $.each(formValues, function(index, field) {
      formData[field.name] = field.value;
    });

    $.ajax({
      url: 'http://127.0.0.1:8081/api/order',
      method: $(this).attr('method'),
      data: formData,
      success: function(response) {
        alert(response.message);
        location.reload();
      },
      error: function(xhr, status, error) {
        alert(error);
      }
    });
  });
});

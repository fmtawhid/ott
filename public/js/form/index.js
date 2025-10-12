function tableReload() {
  $('#datatable').DataTable().ajax.reload();
}
function getCsrfToken() {
  return $('meta[name="csrf-token"]').attr('content');
}
function handleAction(URL, method, confirmationMessage, successMessage) {
Swal.fire({
  title: confirmationMessage,
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes",
  reverseButtons: true 
}).then((result) => {
  if (result.isConfirmed) {
      $.ajax({
          url: URL,
          method: method,
          data: {
              _token: getCsrfToken()
          },
          dataType: 'json',
          success: function(res) {
              Swal.fire({
                  title: "Success!",
                  text: successMessage,
                  icon: "success"
              });
              tableReload();
          },
      });
  }
});
}

$(document).on('click', '.delete-tax', function(event) {
event.preventDefault();
const URL = $(this).attr('href');
handleAction(URL, 'DELETE', "Are you sure you want to delete this entry?", "Data deleted successfully!");
});

$(document).on('click', '.restore-tax', function(event) {
event.preventDefault();
const URL = $(this).attr('href');

let confirmMessage = "Are you sure you want to proceed?";
let successMessage = "Action completed successfully!";

if ($(this).data('confirm-message')) {
    confirmMessage = $(this).data('confirm-message');
}

if ($(this).data('success-message')) {
    successMessage = $(this).data('success-message');
}

handleAction(URL, 'POST', confirmMessage, successMessage);
});

$(document).on('click', '.force-delete-tax', function(event) {
event.preventDefault();
const URL = $(this).attr('href');
handleAction(URL, 'DELETE', "Are you sure you want to permanently delete this entry?", "Entry permanently deleted!");
});

document.addEventListener("DOMContentLoaded", function() {
    function showSnackbar() {
        var snackbar = document.getElementById("snackbar");
        if (snackbar) {
            snackbar.classList.add("show");
            setTimeout(function() {
                snackbar.classList.remove("show");
            }, 3000);
        }
    }
    showSnackbar();
});

function dismissSnackbar(event) {
  event.preventDefault(); // Prevent the default behavior of the anchor tag
  var snackbar = document.getElementById("snackbar");
  if (snackbar) {
      snackbar.style.display = "none"; // Hide the snackbar
  }
}

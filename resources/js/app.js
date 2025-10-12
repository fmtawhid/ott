(function(){
  "use strict";
  $(document).on('change', '.datatable-filter [data-filter="select"]', function() {
    window.renderedDataTable.ajax.reload(null, false)
  })

  $(document).on('input', '.dt-search', function() {
    window.renderedDataTable.ajax.reload(null, false)
  })

  const confirmSwal = async (message) => {
    return await Swal.fire({
      title: message,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#858482',
      confirmButtonText: 'Yes',
      showClass: {
        popup: 'animate__animated animate__zoomIn'
      },
      hideClass: {
        popup: 'animate__animated animate__zoomOut'
      }
    }).then((result) => {
      return result
    })
  }

  window.confirmSwal = confirmSwal

  $('#quick-action-form').on('submit', function(e) {
    e.preventDefault()
    const form = $(this)
    const url = form.attr('action')
    const message = $('[name="message_'+$('[name="action_type"]').val()+'"]').val()
    const rowdIds = $("#datatable_wrapper .select-table-row:checked").map(function() {
        return $(this).val();
    }).get();

    confirmSwal(message).then((result) => {
      if(!result.isConfirmed) return
      callActionAjax({url: `${url}?rowIds=${rowdIds}`,body: form.serialize()})
      //
    })
  })

  // Update status on switch
  $(document).on('change', '#datatable_wrapper .switch-status-featured', function() {
    let url = $(this).attr('data-url')
    let body = {
      featured: $(this).prop('checked') ? 1 : 0,
      _token: $(this).attr('data-token')
    }
    callActionAjax({url: url, body: body})
  })

    // Update status on switch
    $(document).on('change', '#datatable_wrapper .switch-status-change', function() {
      let url = $(this).attr('data-url')
      let body = {
        status: $(this).prop('checked') ? 1 : 0,
        _token: $(this).attr('data-token')
      }
      callActionAjax({url: url, body: body})
    })


    $(document).on('change', '#datatable_wrapper .switch-restricted-change', function() {
      let url = $(this).attr('data-url')
      let body = {
        status: $(this).prop('checked') ? 1 : 0,
        _token: $(this).attr('data-token')
      }
      callActionAjax({url: url, body: body})
    })

  $(document).on('change', '#datatable_wrapper .change-select', function() {
    let url = $(this).attr('data-url')
    let body = {
      value: $(this).val(),
      _token: $(this).attr('data-token')
    }
    callActionAjax({url: url, body: body})
  })

  function callActionAjax ({url, body}) {
    $.ajax({
      type: 'POST',
      url: url,
      data: body,
      success: function(res) {
        if (res.status) {
          window.successSnackbar(res.message)
          window.renderedDataTable.ajax.reload(resetActionButtons, false)
          const event = new CustomEvent('update_quick_action', {detail: {value: true}})
          document.dispatchEvent(event)
        } else {
          Swal.fire({
            title: 'Error',
            text: res.message,
            icon: "error",
            showClass: {
              popup: 'animate__animated animate__zoomIn'
            },
            hideClass: {
              popup: 'animate__animated animate__zoomOut'
            }
          })
          // window.errorSnackbar(res.message)
        }
      }
    })
  }

  // Update status on button click
  $(document).on('click', '#datatable_wrapper .button-status-change', function() {

    let url = $(this).attr('data-url')
    let body = {
      status: 1,
      _token: $(this).attr('data-token')
    }
    callActionAjax({url: url, body: body})
  })

  function callActionAjax ({url, body}) {
    $.ajax({
      type: 'POST',
      url: url,
      data: body,
      success: function(res) {
        if (res.status) {
          window.successSnackbar(res.message)
          window.renderedDataTable.ajax.reload(resetActionButtons, false)
          const event = new CustomEvent('update_quick_action', {detail: {value: true}})
          document.dispatchEvent(event)
        } else {
          window.errorSnackbar(res.message)
        }
      }
    })
  }

  //select row in datatable
  const dataTableRowCheck = (id, source = null) => {
    var dataType = source ? source.getAttribute('data-type') : null;
    checkRow();
    const actionDropdown = document.getElementById('quick-action-type');
    if ($(".select-table-row:checked").length > 0) {
        $("#quick-action-form").removeClass('form-disabled');
        //if at-least one row is selected
        document.getElementById("select-all-table").indeterminate = true;
        $("#quick-actions").find("input, textarea, button, select").removeAttr("disabled");
    } else {
        //if no row is selected
        document.getElementById("select-all-table").indeterminate = false;
        $("#select-all-table").attr("checked", false);
        resetActionButtons();
    }

    if ($("#datatable-row-" + id).is(":checked")) {
        $("#row-" + id).addClass("table-active");
    } else {
        $("#row-" + id).removeClass("table-active");
    }

    const rowdIds = $("#datatable_wrapper .select-table-row:checked").map(function() {
      return $(this).val();
    }).get();

    if(dataType !== null){

      if(dataType === 'cast-crew' || dataType === 'review'){
        if (actionDropdown.options[2] !== undefined) {
          actionDropdown.options[2].disabled = true;  // Restore option
        }
        if (actionDropdown.options[3] !== undefined) {
          actionDropdown.options[3].disabled = true;  // Permanently Delete option
        }
        if (actionDropdown.options[1] !== undefined) {
          actionDropdown.options[1].disabled = false;
        }
      }else{
        if (actionDropdown.options[3] !== undefined) {
          actionDropdown.options[3].disabled = true;  // Restore option
        }
        if (actionDropdown.options[4] !== undefined) {
          actionDropdown.options[4].disabled = true;  // Permanently Delete option
        }
        if (actionDropdown.options[2] !== undefined) {
          actionDropdown.options[2].disabled = false;
        }
      }

    }


    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      type: 'POST',
      headers: {
        'X-CSRF-Token': csrfToken,
    },
      url: baseUrl + "/app/check-in-trash",
      data: { ids: rowdIds, datatype: dataType },
      success: function(response) {
          if(response.all_in_trash == true){
            if(dataType === 'cast-crew' || dataType === 'review'){
                actionDropdown.options[2].disabled = false;  // Restore option
                actionDropdown.options[3].disabled = false;  // Permanently Delete option
                actionDropdown.options[1].disabled = true;
            }else{
              actionDropdown.options[3].disabled = false; // Restore option
              actionDropdown.options[4].disabled = false; // Permanently Delete option
              actionDropdown.options[2].disabled = true;
            }
          }
      }
    });
    checkRow();
  };
  window.dataTableRowCheck = dataTableRowCheck

  const selectAllTable = (source) => {
    var dataType = source.getAttribute('data-type');
    const checkboxes = document.getElementsByName("datatable_ids[]");
    const actionDropdown = document.getElementById('quick-action-type');
    const selectedIds = [];
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        // if disabled property is given to checkbox, it won't select particular checkbox.
        if (!$("#" + checkboxes[i].id).prop('disabled')){
            checkboxes[i].checked = source.checked;
            if (checkboxes[i].checked) {
              selectedIds.push(checkboxes[i].value);
            }else{
              document.getElementById("select-all-table").indeterminate = false;
              $("#select-all-table").attr("checked", false);
              resetActionButtons();
            }
        }
        // if ($("#" + checkboxes[i].id).is(":checked")) {
        //     $("#" + checkboxes[i].id)
        //         .closest("tr")
        //         .addClass("table-active");
        //     $("#quick-actions")
        //         .find("input, textarea, button, select")
        //         .removeAttr("disabled");
        //     if ($("#quick-action-type").val() == "") {
        //         $("#quick-action-apply").attr("disabled", true);
        //       }
        // } else {
        //     $("#" + checkboxes[i].id)
        //         .closest("tr")
        //         .removeClass("table-active");
        //     resetActionButtons();
        // }
    }
    if(dataType !== null){
      if(dataType === 'cast-crew' || dataType === 'review'){
         
        if (actionDropdown.options[2] !== undefined) {
          actionDropdown.options[2].disabled = true;  // Restore option
        }
        if (actionDropdown.options[3] !== undefined) {
          actionDropdown.options[3].disabled = true;  // Permanently Delete option
        }
        if (actionDropdown.options[1] !== undefined) {
          actionDropdown.options[1].disabled = false;
        }
      }else{
        if (actionDropdown.options[3] !== undefined) {
          actionDropdown.options[3].disabled = true;  // Restore option
        }
        if (actionDropdown.options[4] !== undefined) {
          actionDropdown.options[4].disabled = true;  // Permanently Delete option
        }
        if (actionDropdown.options[2] !== undefined) {
          actionDropdown.options[2].disabled = false;
        }
      }
    }

    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      type: 'POST',
      headers: {
        'X-CSRF-Token': csrfToken,
    },
      url: baseUrl + "/app/check-in-trash",
      data: { ids: selectedIds, datatype: dataType },
      success: function(response) {
          if(response.all_in_trash == true){

            if(dataType === 'cast-crew' || dataType === 'review'){
              actionDropdown.options[2].disabled = false;  // Restore option
              actionDropdown.options[3].disabled = false;  // Permanently Delete option
              actionDropdown.options[1].disabled = true;
            }else{
              actionDropdown.options[3].disabled = false; // Restore option
              actionDropdown.options[4].disabled = false; // Permanently Delete option
              actionDropdown.options[2].disabled = true;
            }

          }
      }
    });


    checkRow();
};


  window.selectAllTable = selectAllTable

  const checkRow = () => {
    if ($(".select-table-row:checked").length > 0) {
      $("#quick-action-type").prop('disabled', false);
      $("#quick-action-form").removeClass('form-disabled');
      // $("#quick-action-apply").removeClass("btn-primary").addClass("btn-primary");
    } else {
      $("#quick-action-type").prop('disabled', true);
      $("#quick-action-form").addClass('form-disabled');
      document.getElementById("select-all-table").indeterminate = false;
      // $("#quick-action-apply").removeClass("btn-primary").addClass("btn-primary");
    }
  }

  window.checkRow = checkRow

  //reset table action form elements
  const resetActionButtons = () => {
    checkRow()
    const quickActionForm = $("#quick-action-form")[0];
    if(document.getElementById("select-all-table") !== undefined && document.getElementById("select-all-table") !== null) {
      document.getElementById("select-all-table").checked = false;
      if (quickActionForm !== undefined && quickActionForm !== null) {
        quickActionForm.reset();  // Only reset if the form exists
    }
      $("#quick-actions")
          .find("input, textarea, button, select")
          .attr("disabled", "disabled");
      $("#quick-action-form").find("select").select2("destroy").select2().val(null).trigger("change")
    }
  };

  window.resetActionButtons = resetActionButtons


//  const initDatatable = ({url, finalColumns, advanceFilter, drawCallback = undefined, orderColumn}) => {

//     const data_table_limit = $('meta[name="data_table_limit"]').attr('content');

//     window.renderedDataTable = $('#datatable').DataTable({
//         processing: true,
//         serverSide: true,
//         autoWidth: false,
//         responsive: true,
//         fixedHeader: true,
//         order: orderColumn,
//         pageLength: data_table_limit,
//         dom: '<"table-responsive my-3 mt-3 mb-5 pb-1" rt>' +  // Table without search
//              '<"row"<"col-md-6" info><"col-md-6" p>>' +  // Removed length menu (l) and search (f)
//              '<"clear">',
//         ajax: {
//             "type": "GET",
//             "url": url,
//             "data": function(d) {
//                 d.search = {
//                     value: $('.dt-search').val()
//                 };
//                 d.filter = {
//                     column_status: $('#column_status').val()
//                 }
//                 if (typeof advanceFilter == 'function' && advanceFilter() !== undefined) {
//                     d.filter = { ...d.filter, ...advanceFilter() }
//                 }
//             },
//         },
//         drawCallback: function() {
//             if (laravel !== undefined) {
//                 window.laravel.initialize();
//             }
//             $('.select2').select2();
//             if (drawCallback !== undefined && typeof drawCallback == 'function') {
//                 drawCallback();
//             }
//         },
//         columns: finalColumns,
//         infoCallback: function(settings, start, end, max, total, pre) {
//             const info = `Showing ${start} to ${end} of ${total} entries`;

//             // Update the info display at the bottom
//             $('.data_table_widgets .info').html(info);

//             return info;
//         },
//     });

//     // Hide the search box by adding d-none class
//     $('.dataTables_filter').addClass('d-none');
// }

const initDatatable = ({url, finalColumns, advanceFilter, drawCallback = undefined, orderColumn}) => {

  const data_table_limit = parseInt($('meta[name="data_table_limit"]').attr('content'), 10);

  window.renderedDataTable = $('#datatable').DataTable({
      processing: true,
      serverSide: true,
      autoWidth: false,
      responsive: true,
      fixedHeader: true,
      order: orderColumn,
      pageLength: data_table_limit,
      dom: '<"table-responsive my-3 mt-3 mb-5 pb-1" rt>' +  // Table without search
           '<"row"<"col-md-6" info><"col-md-6" p>>' +  // Removed length menu (l) and search (f)
           '<"clear">',
      ajax: {
          type: "GET",
          url: url,
          data: function(d) {
              d.search = {
                  value: $('.dt-search').val()
              };
              d.filter = {
                  column_status: $('#column_status').val()
              };
              if (typeof advanceFilter === 'function' && advanceFilter() !== undefined) {
                  d.filter = { ...d.filter, ...advanceFilter() };
              }
          },
      },
      drawCallback: function() {
          if (typeof window.laravel !== 'undefined') {
              window.laravel.initialize();
          }
          $('.select2').select2();
          if (typeof drawCallback === 'function') {
              drawCallback();
          }
      },
      columns: finalColumns,
      infoCallback: function(settings, start, end, max, total, pre) {
          const info = `Showing ${start} to ${end} of ${total} entries`;

          // Update the info display at the bottom
          $('.data_table_widgets .info').html(info);

          return info;
      },
  });

  // Hide the search box by adding d-none class
  $('.dataTables_filter').addClass('d-none');
}

window.initDatatable = initDatatable;


  window.initDatatable = initDatatable

  function formatCurrency(number, noOfDecimal, decimalSeparator, thousandSeparator, currencyPosition, currencySymbol) {
    // Convert the number to a string with the desired decimal places
    let formattedNumber = number.toFixed(noOfDecimal)

    // Split the number into integer and decimal parts
    let [integerPart, decimalPart] = formattedNumber.split('.')

    // Add thousand separators to the integer part
    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator)

    // Set decimalPart to an empty string if it is undefined
    decimalPart = decimalPart || ''

    // Construct the final formatted currency string
    let currencyString = ''

    if (currencyPosition === 'left' || currencyPosition === 'left_with_space') {
      currencyString += currencySymbol
      if (currencyPosition === 'left_with_space') {
        currencyString += ' '
      }
      currencyString += integerPart
      // Add decimal part and decimal separator if applicable
      if (noOfDecimal > 0) {
        currencyString += decimalSeparator + decimalPart
      }
    }

    if (currencyPosition === 'right' || currencyPosition === 'right_with_space') {
      // Add decimal part and decimal separator if applicable
      if (noOfDecimal > 0) {
        currencyString += integerPart + decimalSeparator + decimalPart
      }
      if (currencyPosition === 'right_with_space') {
        currencyString += ' '
      }
      currencyString += currencySymbol
    }

    return currencyString
  }

  window.formatCurrency = formatCurrency

})()

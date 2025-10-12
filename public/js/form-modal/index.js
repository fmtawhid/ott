(function ($) {
  ("use strict");
  function createCustomEvent(eventName, data) {
      document.dispatchEvent(new CustomEvent(eventName, { detail: data }))
  }

  function setEditID({data, resetData, event}) {
      if (data.form_id !== '') {
          createCustomEvent(event, data)
      } else {
          removeEditID(resetData, event)
      }
  }
  function removeEditID(resetData, event) {
      createCustomEvent(event, resetData)
  }

  const resetData = {
    show: false,
  }

  $(document).on('click', '[data-modal="import"]', function() {
    const data = {
        show: true,
    }
    setEditID({data: data, resetData: resetData, event: 'import_modal'})
  })

  $(document).on('click', '[data-modal="export"]', function() {
    const data = {
        show: true,
    }
    setEditID({data: data, resetData: resetData, event: 'export_modal'})
  })
})(window.$)

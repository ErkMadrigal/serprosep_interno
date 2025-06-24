      $('.select2').select2({
        theme: 'bootstrap4',
      });
      $('.select2-multi').select2({
        multiple: true,
        theme: 'bootstrap4',
      });
      
      
      flatpickr(".datetimes", {
        dateFormat: "Y-m-d",
        locale: "es", // 👈 Idioma español
        mode: "range"
      });
      
      
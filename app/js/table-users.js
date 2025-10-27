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
      

      flatpickr(".drgpicker", {
        enableTime: false, // Sin selector de hora
        dateFormat: "Y-m-d", // Formato de fecha (ajusta según necesites)
        locale: "es", // Idioma español
        allowInput: true, // Permitir entrada manual
        altInput: true, // Mostrar formato alternativo legible
        altFormat: "d/m/Y" // Formato legible para el usuario
      });

      $("#finiquito").select2({
          theme: "bootstrap4",
          width: "100%"
      });

      
      $("#motivoBaja").select2({
          theme: "bootstrap4",
          width: "100%"
      });
      
      
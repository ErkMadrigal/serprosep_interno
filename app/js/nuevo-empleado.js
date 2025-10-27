
      $('.input-code').mask('00-000',
      {
         translation:
        {
          'Z':
          {
            pattern: /[0-9]/,
            optional: true
          }
        },
        placeholder: "__-___"
      });
      
      const input = document.getElementById('interbancaria');

      $('.select2').select2(
      {
        multiple: false,
        theme: 'bootstrap4',
      });
     
      function generarNoEmpleado() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hour = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        return `${year}${month}${day}${hour}${minutes}`;
      }

      const add = document.getElementById('add');
      const formulario = document.getElementById('formulario');

    (() => {
      'use strict'
      add.onclick = (e) => {
        e.preventDefault();
        e.stopPropagation();
          
        if (formulario.checkValidity()) {
          const fechaHora = generarNoEmpleado();
          
          const data = {
            action: "empleados",
            interbancaria: document.getElementById('interbancaria').value,
            institucionBancaria: document.getElementById('banco').value,
            paterno: document.getElementById('paterno').value,
            materno: document.getElementById('materno').value,
            nombre: document.getElementById('nombre').value,
            curp: document.getElementById('curp').value,
            rfc: document.getElementById('rfc').value,
            nss: document.getElementById('nss').value,
            cp: document.getElementById('cp').value,
            alergias: document.getElementById('alergias').value,
            id_regional: document.getElementById('regional').value,
            no_empleado: fechaHora,
            id_unidad_negocio: document.getElementById('unidadNegocio').value,
            id_zona: document.getElementById('zona').value,
            id_empresa: document.getElementById('empresa').value,
            id_servicio: document.getElementById('servicioId').value,
            id_turno: document.getElementById('turno').value,
            id_puesto: document.getElementById('puesto').value,
            sueldo: document.getElementById('sueldo').value,
            id_periocidad: document.getElementById('periocidad').value,
            cuenta: document.getElementById('cuenta').value,
            estatus: 1
          };
          
          const API_BASE_URL = window.env.API_URL + 'employees';
          
          fetch(API_BASE_URL, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-API-KEY': window.env.API_KEY, // API Key fija
              'Authorization': `Bearer ${localStorage.getItem('token')}` // Token guardado en localStorage
            },
            body: JSON.stringify(data)
          })
            .then(response => {
              if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
              }
              return response.json();
            })
            .then(result => {
              console.log('Empleado agregado:', result);
              Toast.fire({
                icon: "success",
                title: result.mensaje
              });
              formulario.reset();
              formulario.classList.remove('was-validated');
            })
            .catch(error => {
              console.error('Error en el fetch:', error);
              Toast.fire({
                icon: "error",
                title: error.message
              });
            });
        } else {
          formulario.classList.add('was-validated');
        }
      };
      
    })();
     



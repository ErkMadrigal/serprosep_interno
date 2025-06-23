
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
     
      let add = document.getElementById('add');

      add.onclick = () =>{
        let data = {
          "nombre": document.getElementById('nombre').value,
          "paterno": document.getElementById('paterno').value,
          "materno": document.getElementById('materno').value,
          "curp": document.getElementById('curp').value,
          "rfc": document.getElementById('rfc').value,
          "nss": document.getElementById('nss').value,
          "cp": document.getElementById('cp').value,
          "unidadNegocio": document.getElementById('unidadNegocio').value,
          "zona": document.getElementById('zona').value,
          "turno": document.getElementById('turno').value,
          "puesto": document.getElementById('puesto').value,
          "sueldo": document.getElementById('sueldo').value,
          "periocidad": document.getElementById('periocidad').value,
          "cuenta": document.getElementById('cuenta').value,
          "interbancaria": document.getElementById('interbancaria').value,
          "institucionBancaria": document.getElementById('banco').value,
          "servicio": document.getElementById('servicioId').value,
        }

        const API_BASE_URL = window.env.API_URL+'';

        fetch(url, {
        method: 'POST',

        headers: {
          'Content-Type': 'application/json',
        },
          body: data ? JSON.stringify(data) : null 
        }).then(response => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error('Network response was not ok');
          }
        }).then(data => {
          console.log(data)
        }).catch(error => {
          console.error('There was a problem with the fetch operation:', error);
        });
        }


      // (function()
      // {
      //   'use strict';
      //   window.addEventListener('load', function()
      //   {
      //     // Fetch all the forms we want to apply custom Bootstrap validation styles to
      //     var forms = document.getElementsByClassName('needs-validation');
      //     // Loop over them and prevent submission
      //     var validation = Array.prototype.filter.call(forms, function(form){
      //       form.addEventListener('submit', function(event)
      //       {
      //         if (form.checkValidity() === false)
      //         {
      //           event.preventDefault();
      //           event.stopPropagation();
      //         }
      //         form.classList.add('was-validated');
      //       }, false);
      //     });
      //   }, false);
      // })();
   
     



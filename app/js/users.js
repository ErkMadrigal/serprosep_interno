const API_BASE_URL = window.env.API_URL + 'users'; // Replace with your actual API base URL

(async () => {
  try {
    const response = await fetch(API_BASE_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': window.env.API_KEY, // API Key fija
        'Authorization': `Bearer ${localStorage.getItem('token')}` // Token guardado en localStorage
      },
      body: JSON.stringify({ action: "getRoles" })
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    // Generar checkboxes dinámicamente
    const container = document.getElementById('checkboxContainer');
    data.data.forEach(item => {
      const div = document.createElement('div');
      div.className = 'col-lg-2 col-md-3 col-sm-12 mb-3'; // Añadir clase para el estilo
      div.innerHTML = `
        <div class="custom-control custom-switch mb-2">
            <input type="checkbox" class="custom-control-input" id="check_${item.id}" value="${item.id}" data-tipo="${item.tipo}">
            <label class="custom-control-label" for="check_${item.id}">${item.tipo}</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="actualizar_${item.id}" value="1">
            <label class="form-check-label" for="actualizar_${item.id}">Actualizar</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="eliminar_${item.id}" value="2">
            <label class="form-check-label" for="eliminar_${item.id}">Eliminar</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="crear_${item.id}" value="3">
            <label class="form-check-label" for="crear_${item.id}">Crear</label>
        </div>
      `;
      container.appendChild(div);
    });
  } catch (error) {
    console.error('Error fetching catalogos:', error);
    throw error;
  }
})();

// JavaScript
const copiarTexto = async () => {
    // Obtener los valores de los labels
    const usuario = document.getElementById('usuarioMsg').textContent;
    const contrasenia = document.getElementById('passMsg').textContent;
    
    // Formatear el texto a copiar
    const texto = `Usuario: ${usuario}\nContraseña: ${contrasenia}`;
    
    try {
        // Copiar al portapapeles
        await navigator.clipboard.writeText(texto);
        // console.log(texto)

         Toast.fire({
          icon: "success",
          title: "Exito",
          text: "Credenciales copiadas al portapapeles!"
        });
    } catch (err) {
        console.error('Error al copiar: ', err);
         Toast.fire({
          icon: "error",
          title: "Error",
          text: "Error al copiar las credenciales"
        });
    }
}

// Función para mostrar los elementos seleccionados
const mostrarSeleccionados = () => {
  const mainCheckboxes = document.querySelectorAll('input.custom-control-input:checked');
  const seleccionados = Array.from(mainCheckboxes).map(checkbox => {
    const id = parseInt(checkbox.value);
    const tipo = checkbox.getAttribute('data-tipo');
    const permisos = [];
    if (document.querySelector(`#actualizar_${id}:checked`)) permisos.push('Actualizar');
    if (document.querySelector(`#eliminar_${id}:checked`)) permisos.push('Eliminar');
    if (document.querySelector(`#crear_${id}:checked`)) permisos.push('Crear');
    return { id, tipo, permisos };
  });

  // if (seleccionados.length === 0) {
  //   console.log("No hay elementos seleccionados.");
  // } else {
  //   console.log("Elementos seleccionados:", seleccionados);
  // }
  return seleccionados; // Devolver los seleccionados para usarlos en newUsuario
};

const newUsuario = async (event) => {
  event.preventDefault();
  event.stopPropagation();

  const formulario = document.querySelector(".needs-invalidation");

  if (!formulario) {
    console.error('Formulario .needs-invalidation no encontrado');
    Toast.fire({
      icon: "error",
      title: "Error",
      text: "Formulario no encontrado"
    });
    return;
  }

  if (formulario.checkValidity()) {
    const seleccionados = mostrarSeleccionados(); // Obtener los roles seleccionados
    const data_json = {
        action: "newUser",
        nombre: document.querySelector("#nombre").value,
        paterno: document.querySelector("#paterno").value,
        materno: document.querySelector("#materno").value,
        correo: document.querySelector("#correo").value,
        roles: seleccionados // Enviar los roles seleccionados en lugar de solo id
    };

    try {
      const response = await fetch(API_BASE_URL, { // Usa API_BASE_URL o corrige si es API_BASE_URL_EMPLEADOS
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-API-KEY': window.env.API_KEY,
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(data_json)
      }); 

      if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
      const data = await response.json();
      if (data.status === "ok") {
        
        document.querySelector("#alert_new_empleado").classList.remove("d-none")
        document.querySelector("#usuarioMsg").innerText = data.userName
        document.querySelector("#passMsg").innerText = data.password


        Toast.fire({
          icon: "success",
          title: data.mensaje
        });
        const responseRoles = await fetch(API_BASE_URL, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-API-KEY': window.env.API_KEY,
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          },
          body: JSON.stringify({ 
            action: "setRoles",
            id_usuario: data.last_insert_id, // Asegúrate de que data.data.id es el ID del usuario recién creado
            roles: seleccionados // Enviar los roles seleccionados
          })
        });
        if (!responseRoles.ok) throw new Error(`HTTP error! status: ${responseRoles.status}`);
        const rolesData = await responseRoles.json();
        setTimeout(() => {
          if (rolesData.status === "ok") {
             
              Toast.fire({
                  icon: "success",
                  title: rolesData.mensaje
              });
  
          } else {
              Toast.fire({
                  icon: "error",
                  title: rolesData.mensaje
              });
          }
          formulario.reset();
          formulario.classList.remove('was-validated');
        }, 3000);
      } else {
        Toast.fire({
          icon: "error",
          title: data.mensaje
        });
      }
    } catch (error) {
      console.error('Error al obtener datos:', error);
      Toast.fire({
        icon: "error",
        title: "Error",
        text: "Error al enviar los datos"
      });
    }
  } else {
    formulario.classList.add('was-validated');
  }
};

// Asignar el evento con addEventListener
document.querySelector("#add").addEventListener('click', newUsuario);
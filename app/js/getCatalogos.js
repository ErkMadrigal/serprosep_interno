const API_BASE_URL = window.env.API_URL+'catalogs'; // Replace with your actual API base URL

(async() => {
  try {
    const response = await fetch(API_BASE_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': window.env.API_KEY, // API Key fija
        'Authorization': `Bearer ${localStorage.getItem('token')}` // Token guardado en localStorage
      },
      body: JSON.stringify({ action: "getRegionales", })
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    
    let regional = document.getElementById('regional');
    regional.innerHTML = `<option selected disabled value="">Seleccione un Gerente Regional</option>`;
    data.data.forEach(item => {  
        regional.innerHTML += `<option value="${item.id}">${item.valor}</option>`;
    });
    regional.disabled = false; // Habilitar el select después de cargar los datos
    
  } catch (error) {
    console.error('Error fetching catalogos:', error);
    throw error;
  }
})();

const getCatalogos = async (url, id) => {
  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': window.env.API_KEY, // API Key fija
        'Authorization': `Bearer ${localStorage.getItem('token')}` // Token guardado en localStorage
      },
      body: id ? JSON.stringify({ 
        action: "getCatalogos",
        id_catalogo: id 
      }) : null
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    return data;

  } catch (error) {
    console.error('Error fetching catalogos:', error);
    throw error;
  }
};


let empresa = document.getElementById('empresa');

getCatalogos(API_BASE_URL, 13)
.then(data => {
    empresa.innerHTML = `<option selected disabled value="">Seleccione una empresa</option>`;
    data.data.forEach(item => {  
        empresa.innerHTML += `<option value="${item.id}">${item.valor}</option>`;
    });
    empresa.disabled = false; // Habilitar el select después de cargar los datos
})
.catch(error => {
  console.error('Error in getCatalogos:', error);
});


let unidadNegocio = document.getElementById('unidadNegocio');
getCatalogos(API_BASE_URL, 12)
.then(data => { 
    unidadNegocio.innerHTML = `<option selected disabled value="">Seleccione una unidad de negocio</option>`;
    data.data.forEach(item => {
        unidadNegocio.innerHTML += `<option value="${item.id}">${item.valor}</option>`;
    });
    unidadNegocio.disabled = false; // Habilitar el select después de cargar los datos
})
.catch(error => {
  console.error('Error in getCatalogos:', error);
});

let zona = document.getElementById('zona');
getCatalogos(API_BASE_URL, 11)
.then(data => { 
    zona.innerHTML = `<option selected disabled value="">Seleccione una zona/área</option>`;
    data.data.forEach(item => {
        zona.innerHTML += `<option value="${item.id}">${item.valor}</option>`;
    });
    zona.disabled = false; // Habilitar el select después de cargar los datos
})
.catch(error => {
  console.error('Error in getCatalogos:', error);
});

let turno = document.getElementById('turno');
getCatalogos(API_BASE_URL, 7)
.then(data => { 
    turno.innerHTML = `<option selected disabled value="">Seleccione un turno</option>`;
    data.data.forEach(item => {
        turno.innerHTML += `<option value="${item.id}">${item.valor}</option>`;
    });
    turno.disabled = false; // Habilitar el select después de cargar los datos
})
.catch(error => {
  console.error('Error in getCatalogos:', error);
});

let puesto = document.getElementById('puesto');
getCatalogos(API_BASE_URL, 10)
.then(data => { 
    puesto.innerHTML = `<option selected disabled value="">Seleccione un puesto</option>`;
    data.data.forEach(item => {
        puesto.innerHTML += `<option value="${item.id}">${item.valor}</option>`;
    });
    puesto.disabled = false; // Habilitar el select después de cargar los datos
})
.catch(error => {
  console.error('Error in getCatalogos:', error);
});

let periocidad = document.getElementById('periocidad');
getCatalogos(API_BASE_URL, 9)
.then(data => { 
    periocidad.innerHTML = `<option selected disabled value="">Seleccione una periocidad</option>`;
    data.data.forEach(item => {
        periocidad.innerHTML += `<option value="${item.id}">${item.valor}</option>`;
    });
    periocidad.disabled = false; // Habilitar el select después de cargar los datos
})
.catch(error => {
  console.error('Error in getCatalogos:', error);
});



const servicioInput = document.getElementById('servicio');
const serviciosList = document.getElementById('servicios');

let debounceTimer;

let serviciosData = []; // Guardar los datos originales

servicioInput.addEventListener('input', () => {
  clearTimeout(debounceTimer);

  debounceTimer = setTimeout(() => {
    const selectedValue = servicioInput.value.trim();
    if (selectedValue.length < 2) return;

    fetch(API_BASE_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': window.env.API_KEY,
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: JSON.stringify({
        action: "getCatalogosName",
        id_catalogo: 8,
        name: selectedValue
      })
    })
    .then(response => response.json())
    .then(data => {
      serviciosList.innerHTML = '';
      serviciosData = data.data || [];

      serviciosData.forEach(item => {
        const option = document.createElement('option');
        option.value = item.valor; // lo que el usuario ve y selecciona
        serviciosList.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error en la búsqueda de servicios:', error);
    });

  }, 1000);
});

// Cuando se pierde el foco o se confirma la entrada, buscar el ID del valor seleccionado
servicioInput.addEventListener('change', () => {
  const inputValue = servicioInput.value.trim();
  const selected = serviciosData.find(item => item.valor === inputValue);
  if (selected) {
    document.getElementById('servicioId').value = selected.id; // asigna el id al input oculto
  } else {
    document.getElementById('servicioId').value = ''; // limpia si no hay match
    console.warn('Servicio no encontrado');
  }
});


let interbancaria = document.getElementById('interbancaria');
const invalidFeedback = interbancaria.parentElement.querySelector('.invalid-feedback');

// Formatear mientras escribe (solo números, hasta 18)
interbancaria.addEventListener('input', () => {
  let value = interbancaria.value.replace(/\D/g, '').slice(0, 18);
  interbancaria.value = formatCLABE(value);
  clearError();
});

// Al salir del input, rellenar con ceros al inicio si es menor a 18 y validar
interbancaria.addEventListener('blur', () => {
  let digits = interbancaria.value.replace(/\D/g, '');
  if (digits.length < 18) {
    digits = digits.padStart(18, '0');
  }
  interbancaria.value = formatCLABE(digits);
  validateLeadingZeros(digits);
  getBanco(); // Llamar a la función para obtener el banco  
});

// Formatear CLABE con guiones
function formatCLABE(digits) {
  let parts = [];
  parts.push(digits.substring(0, 4));
  parts.push(digits.substring(4, 8));
  parts.push(digits.substring(8, 12));
  parts.push(digits.substring(12, 16));
  parts.push(digits.substring(16, 18));
  return `${parts[0]}-${parts[1]}-${parts[2]}-${parts[3]}-${parts[4]}`;
}

// Validar ceros al inicio
function validateLeadingZeros(digits) {
  const match = digits.match(/^0+/);
  const zerosCount = match ? match[0].length : 0;

  if (zerosCount > 3) {
    showError(`la CLABE interbancaria no es correcta le faltan digitos, debe tener 18 dígitos y no más de 3 ceros al inicio.`);
  } else {
    clearError();
  }
}

// Mostrar error usando clases Bootstrap
function showError(msg) {
  interbancaria.classList.add('is-invalid');
  if (invalidFeedback) {
    invalidFeedback.textContent = msg;
    invalidFeedback.style.display = 'block';
  }
}

// Limpiar error
function clearError() {
  interbancaria.classList.remove('is-invalid');
  if (invalidFeedback) {
    invalidFeedback.textContent = 'El campo es requerido'; // mensaje original
    invalidFeedback.style.display = 'none';
  }
}


const getBanco = () => {
  const digits = interbancaria.value.replace(/\D/g, '');
  
  // Extraer los primeros 3 dígitos
  const primerosTres = digits.substring(0, 3);
  
  if (primerosTres.length === 3) {
    // URL de ejemplo, cambia a la que necesites
  
    fetch(API_BASE_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': window.env.API_KEY,
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: JSON.stringify({
        action: "getInstitucionBancaria",
        clabe: primerosTres
      })
    })
      .then(response => {
        if (!response.ok) throw new Error('Error en la respuesta');
        return response.json();
      })
      .then(data => {
        document.getElementById('institucionBancaria').value = data.data.valor || '';
        document.getElementById('banco').value = data.data.id; 
      })
      .catch(error => {
        console.error('Error en fetch:', error);
      });
  } else {
    console.log('No hay suficientes dígitos para hacer la consulta');
  }
}



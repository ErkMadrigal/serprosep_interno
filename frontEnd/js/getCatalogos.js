const API_BASE_URL = 'http://localhost/serprosep_interno/API/catalogs'; // Replace with your actual API base URL

const getCatalogos = async (url, id) => {
  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': 'k8sd7f9a2v1b4mzqp0xlj5ngtu3wrceh', // API Key fija
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
    console.log('Catalogos data:', data);
    empresa.innerHTML = `<option value="">Seleccione una empresa</option>`;
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
    console.log('Catalogos data:', data);
    unidadNegocio.innerHTML = `<option value="">Seleccione una unidad de negocio</option>`;
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
    console.log('Catalogos data:', data);
    zona.innerHTML = `<option value="">Seleccione una zona/área</option>`;
    data.data.forEach(item => {
        zona.innerHTML += `<option value="${item.id}">${item.valor}</option>`;
    });
    zona.disabled = false; // Habilitar el select después de cargar los datos
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
        'X-API-KEY': 'k8sd7f9a2v1b4mzqp0xlj5ngtu3wrceh',
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
    console.log('ID del servicio seleccionado:', selected.id);
    // Aquí puedes usar selected.id para enviar al backend, guardar, etc.
  } else {
    console.warn('Servicio no encontrado');
  }
});



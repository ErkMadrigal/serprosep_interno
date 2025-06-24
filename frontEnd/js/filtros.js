const API = window.env.API_URL+'catalogs'; // Replace with your actual API base URL


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

let zonaSelect = document.getElementById('zona');
getCatalogos(API, 11)
.then(data => { 
    zonaSelect.innerHTML = `<option disabled value="">Seleccione una zona/área</option>`;
    data.data.forEach(item => {
        zonaSelect.innerHTML += `<option value="${item.id}">${item.valor}</option>`;
    });
    zonaSelect.disabled = false; // Habilitar el select después de cargar los datos
})
.catch(error => {
  console.error('Error in getCatalogos:', error);
});

let puestoSelect = document.getElementById('puesto');
getCatalogos(API, 10)
.then(data => { 
    puestoSelect.innerHTML = `<option disabled value="">Seleccione un puesto</option>`;
    data.data.forEach(item => {
        puestoSelect.innerHTML += `<option value="${item.id}">${item.valor}</option>`;
    });
    puestoSelect.disabled = false; // Habilitar el select después de cargar los datos
})
.catch(error => {
  console.error('Error in getCatalogos:', error);
});

document.getElementById("btnRecargar").onclick = () => {
  location.reload();
};

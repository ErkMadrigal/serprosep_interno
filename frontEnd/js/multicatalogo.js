const API = window.env.API_URL + 'catalogs';



const getCatalogos = async () => {
    try {
        const response = await fetch(API, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-API-KEY': window.env.API_KEY,
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify({ 
                action: "getTipoCatalogos"
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        const $id_Catalogo = $('#id_Catalogo').select2({
            theme: "bootstrap4",
            width: "100%",
            placeholder: "Seleccione un puesto",
            allowClear: true
        });
        $id_Catalogo.empty();

        $id_Catalogo.append(new Option("Seleccione un puesto", "", true, true));

        data.data.forEach(item => {
            $id_Catalogo.append(new Option(item.descripcion, item.id));
        });

        $id_Catalogo.prop('disabled', false);

        $id_Catalogo.trigger('change');
    } catch (error) {
        console.error('Error fetching catalogos:', error);
        throw error;
    }
};

// Ejecutar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    

    getCatalogos()
        .catch(error => {
            console.error('Error in getCatalogos:', error);
            // Mostrar mensaje de error al usuario
            $id_Catalogo.empty().append(new Option("Error al cargar datos", ""));
            $id_Catalogo.prop('disabled', true);
            $id_Catalogo.trigger('change');
        });
});


const newCatalogo = async (e) => {

    e.preventDefault();
    e.stopPropagation();

  const formulario = document.querySelector('.needs-invalidation-catalogo');

  if (formulario.checkValidity()) {
    let data_json = {
      "action": 'newCatalogo',
      "tipo": 'catalogo',
      "descripcion": document.getElementById("descripcion").value,
    };
   
    try {
      const response = await fetch(API, {
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
      
      Toast.fire({
        icon: "success",
        title: data.mensaje
      });
      formulario.reset();
      formulario.classList.remove('was-validated');
      getCatalogos();
      
    } catch (error) {
      console.error('Error al obtener datos:', error);
    }
  }else{
    formulario.classList.add('was-validated');
  }
}

document.querySelector("#add_catalogo").addEventListener("click", newCatalogo);


const newCatalogoMulti = async (e) => {
    e.preventDefault();
    e.stopPropagation();

  const formulario_multi = document.querySelector('.needs-invalidation');

  if (formulario_multi.checkValidity()) {
    let data_json = {
      "action": 'newCatalogo',
      "tipo": 'multicatalogo',
      "id_Catalogo": document.getElementById("id_Catalogo").value,
      "valor": document.getElementById("valor").value,
      "descripcion": document.getElementById("descripcion").value,
    };
   
    try {
      const response = await fetch(API, {
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
      
      Toast.fire({
        icon: "success",
        title: data.mensaje
      });
      formulario_multi.reset();
      formulario_multi.classList.remove('was-validated');
      
    } catch (error) {
      console.error('Error al obtener datos:', error);
    }
  }else{
    formulario_multi.classList.add('was-validated');
  }
}

document.querySelector("#add").addEventListener("click", newCatalogoMulti);
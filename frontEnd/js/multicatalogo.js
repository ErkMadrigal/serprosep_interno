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
        const $id_Catalogo = $('.catalogosSelect').select2({
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

const getCatalogosSearch = async () => {
    try {
        const id_Catalogo_Search = document.getElementById('id_Catalogo_Search');
        const selectedValue = id_Catalogo_Search ? id_Catalogo_Search.value : '';
        if (!selectedValue) {
            console.warn('No se seleccionó ningún catálogo en id_Catalogo_Search');
            const tableBody = document.querySelector('#tableCatalogos tbody');
            if (tableBody) {
                tableBody.innerHTML = '<tr><td colspan="3">Seleccione un catálogo</td></tr>';
            }
            return { data: [] };
        }

        const response = await fetch(API, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-API-KEY': window.env.API_KEY,
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify({ 
                action: "getCatalogosSelect",
                id_catalogo: selectedValue
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        // console.log('Datos de getCatalogosSearch:', data);

        // Actualizar otro select con los datos obtenidos
        const $id_Catalogo_Result = $('#id_Catalogo_Result');
        if ($id_Catalogo_Result.length) {
            $id_Catalogo_Result.empty();
            $id_Catalogo_Result.append(new Option("Seleccione una opción", "", true, true));
            if (data.data && Array.isArray(data.data)) {
                data.data.forEach(item => {
                    $id_Catalogo_Result.append(new Option(item.descripcion, item.id));
                });
            }
            $id_Catalogo_Result.prop('disabled', false);
            $id_Catalogo_Result.trigger('change');
        }

        // Actualizar la tabla con los datos obtenidos
        const tableBody = document.querySelector('#tableCatalogos');
        if (tableBody) {
            tableBody.innerHTML = '';
            if (data.data && Array.isArray(data.data)) {
                data.data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.valor}</td>
                        <td>${item.descripcion}</td>
                        <td>${item.catalogo}</td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="3">No se encontraron datos</td></tr>';
            }
        } else {
            console.error('No se encontró el cuerpo de la tabla con id "tableCatalogos"');
        }

        // Aplicar filtro de búsqueda actual (si hay un término en el input)
        const searchTable = document.getElementById('searchTable');
        if (searchTable && searchTable.value) {
            const searchTerm = searchTable.value.toLowerCase();
            const rows = tableBody ? tableBody.querySelectorAll('tr') : [];
            rows.forEach(row => {
                const text = Array.from(row.cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        }

        return data;
    } catch (error) {
        console.error('Error fetching catalogos:', error);
        const tableBody = document.querySelector('#tableCatalogos tbody');
        if (tableBody) {
            tableBody.innerHTML = '<tr><td colspan="3">Error al cargar datos</td></tr>';
        }
        throw error;
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // Inicializar Select2 para id_Catalogo_Search
    const id_Catalogo_Search = document.getElementById('id_Catalogo_Search');
    if (!id_Catalogo_Search) {
        console.error('Elemento con id "id_Catalogo_Search" no encontrado');
        return;
    }
    $(id_Catalogo_Search).select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Seleccione una opción',
        allowClear: true
    });

    // Llenar id_Catalogo_Search con datos de getCatalogos
    getCatalogos().then(() => {
        const $catalogosSelect = $('.catalogosSelect');
        const $id_Catalogo_Search = $(id_Catalogo_Search);
        $id_Catalogo_Search.empty();
        $catalogosSelect.find('option').each(function() {
            $id_Catalogo_Search.append(new Option(this.text, this.value, false, this.selected));
        });
        $id_Catalogo_Search.prop('disabled', false);
        $id_Catalogo_Search.trigger('change');
    }).catch(error => {
        console.error('Error in getCatalogos:', error);
        const $id_Catalogo = $('.catalogosSelect');
        $id_Catalogo.empty().append(new Option("Error al cargar datos", ""));
        $id_Catalogo.prop('disabled', true);
        $id_Catalogo.trigger('change');
        $(id_Catalogo_Search).empty().append(new Option("Error al cargar datos", ""));
        $(id_Catalogo_Search).prop('disabled', true);
        $(id_Catalogo_Search).trigger('change');
    });

    // Manejar el evento select2:select para id_Catalogo_Search
    $(id_Catalogo_Search).on('select2:select', (e) => {
        // console.log('Cambio de catálogo:', e.target.value);
        getCatalogosSearch().catch(error => {
            console.error('Error in getCatalogosSearch:', error);
            Toast.fire({
                icon: 'error',
                title: 'Error al cargar datos'
            });
        });
    });

    // Funcionalidad de búsqueda en la tabla
    const searchTable = document.getElementById('searchTable');
    if (searchTable) {
        searchTable.addEventListener('input', () => {
            const searchTerm = searchTable.value.toLowerCase();
            const table = document.getElementById('tableCatalogos');
            const rows = table ? table.querySelectorAll('tbody tr') : [];

            if (rows.length === 0) {
                console.warn('No hay filas en la tabla para filtrar');
                return;
            }

            rows.forEach(row => {
                const text = Array.from(row.cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    } else {
        console.error('Elemento con id "searchTable" no encontrado');
    }
});

const newCatalogo = async (e) => {
    e.preventDefault();
    e.stopPropagation();
    const formulario = document.querySelector('.needs-invalidation-catalogo');
    if (formulario.checkValidity()) {
        let data_json = {
            action: 'newCatalogo',
            tipo: 'catalogo',
            descripcion: document.getElementById("descripcion").value
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
    } else {
        formulario.classList.add('was-validated');
    }
};

document.querySelector("#add_catalogo").addEventListener("click", newCatalogo);

const newCatalogoMulti = async (e) => {
    e.preventDefault();
    e.stopPropagation();
    const formulario_multi = document.querySelector('.needs-invalidation');
    if (formulario_multi.checkValidity()) {
        let data_json = {
            action: 'newCatalogo',
            tipo: 'multicatalogo',
            id_Catalogo: document.getElementById("id_Catalogo").value,
            valor: document.getElementById("valor").value,
            descripcion: document.getElementById("descripcion").value
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
    } else {
        formulario_multi.classList.add('was-validated');
    }
};

document.querySelector("#add").addEventListener("click", newCatalogoMulti);
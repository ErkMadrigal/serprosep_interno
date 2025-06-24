const API_BASE_URL = window.env.API_URL + 'employees';

const dataTable = document.querySelector("#dataTable");
const inputLang = document.getElementById("inputLang");
const progressBar = document.querySelector("#progressBar");
const loadingContainer = document.querySelector("#loadingContainer");
const searchInput = document.getElementById("search");
const reload = document.querySelector("#reload");
const btnReset = document.querySelector("#btnReset");

let totalEmpleados = 0;
let paginaActual = 1;

// Muestra barra de carga progresiva
const showLoading = () => {
  loadingContainer.style.display = 'block';
  progressBar.style.width = '0%';
  progressBar.setAttribute('aria-valuenow', 0);

  let progreso = 0;
  return setInterval(() => {
    progreso += 10;
    if (progreso <= 90) {
      progressBar.style.width = `${progreso}%`;
      progressBar.setAttribute('aria-valuenow', progreso);
    }
  }, 100);
};

const hideLoading = (interval) => {
  clearInterval(interval);
  progressBar.style.width = '100%';
  progressBar.setAttribute('aria-valuenow', 100);
  setTimeout(() => {
    loadingContainer.style.display = 'none';
    progressBar.style.width = '0%';
  }, 300);
};

const renderTablaEmpleados = (lista = []) => {
  dataTable.innerHTML = lista.map(value => `
    <tr>
      <td>${value.id}</td>
      <td>${value.nombre}</td>
      <td>${value.curp}</td>
      <td>${value.fecha_ingreso}</td>
      <td>${value.id_puesto}</td>
      <td>${value.id_zona}</td>
      <td>${value.estatus}</td>
      <td>
        <div class="dropdown">
          <button class="btn btn-sm dropdown-toggle more-vertical" type="button" data-toggle="dropdown">
            <span class="text-muted sr-only">Action</span>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Editar</a>
            <a class="dropdown-item" href="#">Activar</a>
            <a class="dropdown-item" href="#">Eliminar</a>
            <a class="dropdown-item" href="#">Asignar</a>
          </div>
        </div>
      </td>
    </tr>
  `).join('');
};

const generarPaginacion = (totalItems, itemsPorPagina, paginaActual, isSearch = false, searchTerm = '') => {
  const totalPaginas = Math.ceil(totalItems / itemsPorPagina);
  const ul = document.querySelector('.pagination');
  ul.innerHTML = '';

  const crearLi = (label, pagina, disabled = false, active = false) => {
    const li = document.createElement('li');
    li.className = `page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
    li.innerHTML = `<a class="page-link" href="#">${label}</a>`;
    if (!disabled) {
      li.addEventListener('click', e => {
        e.preventDefault();
        if (isSearch) {
          searchData(searchTerm, itemsPorPagina, pagina);
        } else {
          getData(pagina, itemsPorPagina);
        }
      });
    }
    return li;
  };

  // Previous
  ul.appendChild(crearLi("«", paginaActual - 1, paginaActual === 1));

  // Número de páginas
  for (let i = 1; i <= totalPaginas; i++) {
    ul.appendChild(crearLi(i, i, false, i === paginaActual));
  }

  // Next
  ul.appendChild(crearLi("»", paginaActual + 1, paginaActual === totalPaginas));
};

const getData = async (pagina = 1, items = parseInt(inputLang.value)) => {
  paginaActual = pagina;
  reload.disabled = true;
  reload.innerText = "Cargando...";

  const interval = showLoading();

  try {
    const response = await fetch(API_BASE_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': window.env.API_KEY,
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: JSON.stringify({
        action: "getEmpleados",
        pagina,
        limit: items
      })
    });

    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

    const data = await response.json();

    renderTablaEmpleados(data?.empleado?.data || []);

    document.querySelector("#completado").innerText = data?.completados?.empleadosTotales ?? 0;
    document.querySelector("#bajas").innerText = data?.bajas?.empleadosTotales ?? 0;
    document.querySelector("#pendeintes").innerText = data?.pendientes?.empleadosTotales ?? 0;
    document.querySelector("#total").innerText = data?.AllEmpleados?.empleadosTotales ?? 0;

    totalEmpleados = data?.AllEmpleados?.empleadosTotales ?? 0;
    generarPaginacion(totalEmpleados, items, pagina);

  } catch (error) {
    console.error('Error al obtener datos:', error);
  } finally {
    reload.disabled = false;
    reload.innerHTML = `<span class="fe fe-refresh-ccw fe-16 text-muted"></span>`;
    hideLoading(interval);
  }
};

const searchData = async (search, limit = 10, pagina = 1) => {
  const offset = (pagina - 1) * limit;
  const interval = showLoading();

  try {
    const response = await fetch(API_BASE_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': window.env.API_KEY,
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: JSON.stringify({
        action: "searchEmpleado",
        search,
        limit,
        offset
      })
    });

    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

    const data = await response.json();
    renderTablaEmpleados(data.data);
    generarPaginacion(data.total, limit, pagina, true, search);

  } catch (error) {
    console.error('Error en la búsqueda:', error);
  } finally {
    hideLoading(interval);
  }
};

// Eventos
reload.onclick = () => getData();
inputLang.onchange = () => getData(1, parseInt(inputLang.value));

let debounceTimer;
searchInput.onkeyup = () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    const valor = searchInput.value.trim();
    if (valor.length > 0) {
      searchData(valor, parseInt(inputLang.value), 1);
    } else {
      getData(1, parseInt(inputLang.value));
    }
  }, 500);
};

btnReset.onclick = () => {
  searchInput.value = '';        // Limpiar el input de búsqueda
  getData(1, parseInt(inputLang.value)); // Recargar datos desde la página 1
};
// Carga inicial
getData();
